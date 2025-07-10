<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\AitsArea;
use App\Models\AitsNotif;
use App\Models\AitsDriver;
use App\Models\AitsDelivery;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\DepartmentModel;
use App\Models\AitsDeliveryType;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\AitsLogisticsResched;
use Illuminate\Support\Facades\Auth;
use Omaralalwi\Gpdf\Facade\Gpdf as GpdfFacade;

class Aits_Messenger_Controller extends Controller
{
    //


    public function aits_messenger_view()
    {
        $type = AitsDeliveryType::where('status', 1)->get();
        $area = AitsArea::where('status', 1)->get();
        return view('aits_pages.aits_messenger_approval', compact(['type', 'area']));
    }


    public function aits_messenger_logistics()
    {


        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])
            ->where('status', 1)
            ->where('messenger_id', Auth::user()->id)
            ->whereNot('request_status', 'Delivered')
            ->orderBy('procedures', 'asc')
            ->get();
        return DataTables::of($data)
            ->addColumn('request_no', function ($data) {
                return request_number($data->request_no, $data->date_created);
            })
            ->addColumn('date_created', function ($data) {
                return date_converter($data->date_created);

            })
            ->addColumn('department', function ($data) {
                return DepartmentModel::find($data->get_requestor_fullname->deparment_id)->description;

            })
            ->addColumn('delivery_type', function ($data) {
                return $data['get_delivery_type']['del_type'];

            })
            ->addColumn('requestor', function ($data) {
                return $data['get_requestor_fullname']['firstname'] . ' ' . $data['get_requestor_fullname']['lastname'];

            })

            ->addColumn('req_status', function ($data) {
                if ($data->status == 0) {
                    return ' <h5> <span class="badge rounded-pill bg-danger">Cancelled</span></h5>';
                }
                $aits_deliver = new Aits_Delivery_Controller();
                return $aits_deliver->status_html($data->request_status, $data->procedures, $data->id);

            })

            ->addColumn('view_file_request', function ($data) {
                $data_file = AitsFileModel::where('table_name', 'AitsDelivery')
                    ->where('procedure', $data->procedures)
                    ->where('status', 1)
                    ->where('attachment_id', $data->id)
                    ->first();
                if (!$data_file) {
                    return '';
                }

                $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                $link = $data_file->file_link;
                $url = dynamic_file($path, $link);
                return ' <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>';

            })
            ->addColumn('logistics_stat', function ($data) {
                $procedure = $data->procedures;
                $stat = '';

                if ($procedure == 1) {
                    $stat = 'For Delivery';
                }
                if ($procedure == 2) {
                    $stat = 'For Collection';
                }
                if ($procedure == 3) {
                    $stat = 'For Pick Up';
                }

                return $stat;

            })
            ->addColumn('messenger_stat', function ($data) {
                $html = '';

                if ($data->messenger_id != null) {
                    $stat = '<span class="badge rounded-pill bg-success">Messenger Assigned</span>';
                } else {

                    $stat = '<span class="badge rounded-pill bg-warning">Pending</span>';
                }

                return '<h5>' . $stat . '</h5>';

            })

            ->addColumn('action', function ($data) {

                // $hidden = $data->messenger_id != null ? 'hidden' : '';
                $hidden = '';
                $procedures = $data->procedures;

                if ($data->request_status == 'Delivered') {
                    return $html = '
                       <div  class="btn-group dropstart input_spec my-1">
                        <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                        </ul>
                        </div> ';
                }

                //for delivery action
                $html = '
                       <div  class="btn-group dropstart input_spec my-1">
                        <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btn_deliver" ' . $hidden . ' data-val="1" data-processs= "' . $data->procedures . '" data-id="' . $data->id . '" href="javascript:void(0);">' . $this->procedure_text($data->procedures) . '</a></li>
                            <li><a class="dropdown-item btn_deliver" ' . $hidden . ' data-val="2" data-id="' . $data->id . '" href="javascript:void(0);">Reschedule</a></li>
                            <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                        </ul>
                        </div> ';


                return $html;

            })

            ->rawColumns(['action', 'view_file_request', 'req_status', 'messenger_stat'])
            //ginagawa neto yung html char is ginagawa nyang html attr-> kapag dinakalagay magigign text lang yan.
            ->make(true);
    }

    public function procedure_text($procedure)
    {
        if ($procedure == 1) {
            $stat = 'Deliver';
        }

        if ($procedure == 2) {
            $stat = 'Collect';
        }
        if ($procedure == 3) {
            $stat = 'Pick Up';
        }


        return $stat;
    }

    public function messenger_delivered(Request $request)
    {

        try {

            $status = 'Reschedule';
            $remarks = "";
            $data = AitsDelivery::findOr($request->id);
            if ($request->process_val == 1) {
                $remarks = $request->messenger_remarks;
                $validated = Validator::make(
                    $request->all(),
                    [
                        'messenger_remarks' => ['required'],
                    ],
                );
            }
            if ($request->process_val == 2) {
                $remarks = $request->reschedule_remarks;
                $validated = Validator::make(
                    $request->all(),
                    [
                        'reschedule_remarks' => ['required'],
                        'date_resched' => ['required'],
                    ],
                );


                $data_update = [
                    'request_status' => $status,
                    'delivery_date' => Carbon::now(),
                    'messenger_remarks' => $remarks,
                    'procedure_date' => Carbon::createFromFormat('Y-m-d\TH:i', $request->date_resched, 'Asia/Manila')->format('Y-m-d H:i:s'),
                ];
            }


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All Fields Are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            if ($request->process_val == 1) {
                $status = 'Delivered';
                if (!$request->file('file')) {
                    return response()->json([
                        'msg' => 'Proof Files Is required',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
                $this->messenger_file_upload($request->id, 'AitsDelivery', $request->file('file'), $data->procedures);
                AitsLogisticsResched::where('logistic_id', $request->id)->update(['status' => 0]);

                $data_update = [
                    'request_status' => $status,
                    'delivery_date' => Carbon::now(),
                    'messenger_remarks' => $remarks,
                ];

            }


            if ($request->process_val == 2) {
                $log_data = AitsDelivery::where('id', $request->id)->first();
                AitsLogisticsResched::create([
                    'logistic_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'date_resched' => $log_data->delivery_date,
                    'remarks' => $request->reschedule_remarks,
                    'is_messenger' => 1,
                    'status' => 1,
                    'date_created' => Carbon::now(),
                    'procedure_logs' => $log_data->procedure_date,
                ]);
            }

            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Messenger Approval',
                'description' => $status . ' Request for logistics',
                'table_name' => 'aits_deliveries',
                'transact_id' => $request->id,
                'status' => 1,
                'date_created' => Carbon::now(),
                'is_messenger' => 1,
            ];
            insert_audit($object);

            AitsNotif::create([
                'aits_table' => "aits_deliveries",
                'aits_id' => $request->id,
                'aits_process' => $status . ' messenger',
                'send_to_user_id' => $data->user_id,
                'date_created' => Carbon::now(),
                'remarks' => $remarks,
            ]);


            $message = 'Rescheduled';


            $update = AitsDelivery::where('id', $request->id)->update($data_update);

            $data_proc = AitsDelivery::where('id', $request->id)->first();
            if ($request->process_val != 2) {
                $procedure = $data_proc->procedures;
                $message = $procedure == 1 ? 'Delivered'
                    : ($procedure == 2 ? 'Collected'
                        : ($procedure ==3 ? 'Picked Up' : ''));

            }

            return response()->json([
                'alert_msg' => $message,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'data' => [],
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }


    public function messenger_file_upload($id, $table_name, $files, $delivery)
    {
        foreach ($files as $item) {
            $ext = $item->getClientOriginalExtension();
            $fname = $item->getClientOriginalName();
            $year = Carbon::now()->year;

            $format_name = now()->format('YmdHis') . '_' . mt_rand('1111', '9999');

            AitsFileModel::create([
                "table_name" => $table_name,
                "attachment_id" => $id,
                "orig_file" => $fname,
                "file_name" => $format_name . '.' . $ext,
                "folder_name" => 'aits_delivery_file',
                "year" => Carbon::now()->year,
                "status" => 1,
                "date_created" => Carbon::now(),
                'procedure' => $delivery,
                'delivery_mess' => 1,
                'user_id' => Auth::user()->id,
                'file_link' => url('/'),
            ]);


            $item->move('aits_delivery_file/' . $year . '/', $format_name . '.' . $ext);
        }

    }

    public function test_pdf()
    {
        $driver = AitsDriver::get();
        $hello = 'GG PARE';
        $html = view('test_pdf', compact('driver', 'hello'))->render();
        $pdfContent = GpdfFacade::generate($html);
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice.pdf"',
        ]);


        // $driver = AitsDriver::get();
        // $hello = 'GG PARE';
        // // Render the Blade view to HTML
        // $html = view('test_pdf', compact('driver', 'hello'))->render();
        // // Generate PDF from HTML with landscape orientation
        // $pdfContent = GpdfFacade::generate($html);
        // // Return the generated PDF as a response
        // return response($pdfContent, 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="invoice.pdf"',
        // ]);
        // return $url = url('/');
    }


    // public function get_doctors_hospitals()
    // {

    //     // doc_city
    //     // 382



    //     $query = "
    //             SELECT doc_id,doc_address,doc_city FROM Doctors WHERE doc_id NOT IN (  SELECT d.doc_id
    //             FROM Doctors d
    //             JOIN cities c ON d.doc_address LIKE '%' + c.city_name + '%')  AND (doc_address IS NOT NULL OR doc_address = '') AND doc_id != doc_city ";


    //     $results = DB::connection('sqlsrv_secondary')->select($query, [


    //     ]);
    //     $data = [];

    //     foreach ($results as $result) {
    //         if ($result->doc_address == "" && $result->doc_city != 0) {
    //             if ($result->doc_city != 1101) {
    //                 $data[] = $result->doc_id;
    //             }
    //         }
    //     }


    //     $doc_id = implode(',', $data);
    //     $query_2 = "
    //       SELECT doc_id,doc_city,doc_address FROM Doctors WHERE doc_id IN($doc_id)";


    //    $data_2 = DB::connection('sqlsrv_secondary')->select($query_2);


    //     // foreach ($data_2 as $data_update) {
    //     //     $city = DB::connection('sqlsrv_secondary')
    //     //         ->select('SELECT city_name FROM cities WHERE city_id = :city_id', ['city_id' => $data_update->doc_city]);


    //     //     DB::connection('sqlsrv_secondary')->table('Doctors')->where('doc_id', $data_update->doc_id)->update([
    //     //         'doc_address' => $city[0]->city_name ?? 'nocity',
    //     //     ]);
    //     // }

    // }
}
