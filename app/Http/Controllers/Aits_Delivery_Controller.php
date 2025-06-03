<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use Validator;
use Carbon\Carbon;
use App\Models\AitsArea;
use App\Models\UserModel;
use App\Models\AitsDelivery;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\AitsDeliveryType;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class Aits_Delivery_Controller extends Controller
{



    public function show_data()
    {

        return UserModel::with(['get_user_data'])->limit(5)->get();

    }

    public function aits_collection_view()
    {
        $type = AitsDeliveryType::where('status', 1)->get();
        $area = AitsArea::where('status', 1)->get();
        return view('aits_pages.aits_collection', compact(['type', 'area']));
    }

    public function aits_pick_up_view()
    {
        $type = AitsDeliveryType::where('status', 1)->get();
        $area = AitsArea::where('status', 1)->get();
        return view('aits_pages.aits_pick_up', compact(['type', 'area']));
    }

    public function aits_delivery_view()
    {
        $type = AitsDeliveryType::where('status', 1)->get();
        $area = AitsArea::where('status', 1)->get();
        return view('aits_pages.aits_logistics_delivery', compact(['type', 'area']));
    }




    public function aits_save_delivery(Request $request)
    {

        try {
            // $object = [];
            // if ($request->procedures != 3) {
            //     $object = ['count_documents' => ['required']];
            // }

            // $validated = Validator::make(
            //     $request->all(),
            //     [
            //         'name_receiver' => [
            //             'required',
            //         ],
            //         'company_name' => ['required'],
            //         'contact_receiver' => ['required'],
            //         'delivery_type_id' => ['required'],
            //         'area_id' => ['required'],

            //         $object,
            //         'complete_address' => ['required'],
            //         'delivery_remarks' => ['required'],
            //     ],
            // );

            $rules = [
                'name_receiver' => ['required'],
                'company_name' => ['required'],
                'contact_receiver' => ['required'],
                'delivery_type_id' => ['required'],
                'area_id' => ['required'],
                'complete_address' => ['required'],
                'delivery_remarks' => ['required'],
            ];

            if ($request->procedures != 3) {
                $rules['count_documents'] = ['required'];
            }

            $validated = Validator::make(
                $request->all(),
                $rules
            );

            

            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            $request->merge([
                'is_transact' => 1,
                'date_created' => Carbon::now(),
                'request_no' => $this->request_no($request->procedures),
                'status' => 1,
                'user_id' => Auth::user()->id,
                'request_status' => 'Pending',
            ]);


            $data = AitsDelivery::create($request->except(['file']));



            
            $this->uploade_file_transit($data->id, 'AitsDelivery', $request->file('file'), $request->procedures);
            $latestRecord = AitsDelivery::orderByDesc('id')->first();
            $latest_id = $latestRecord ? $latestRecord->id : null;
            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Logistic Request',
                'description' => 'Added Request',
                'table_name' => 'aits_deliveries',
                'transact_id' => $latest_id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];


            insert_audit($object);
            // public function uploade_file_transit($id, $table_name, $files, $delivery)
            return response()->json([
                'msg' => 'Successfully Inserted Request For delivery',
                'status' => 200,
                'data' => $data,
                "isValid" => true,
            ]);

        } catch (\Exception $e) {


            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }




    public function uploade_file_transit($id, $table_name, $files, $delivery)
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
                'user_id' => Auth::user()->id,
            ]);


            $item->move('aits_delivery_file/' . $year . '/', $format_name . '.' . $ext);
        }

    }


    public function request_no($procedure)
    {
        $request_no = 1;
        $recent_request = AitsDelivery::where('is_transact', 1)
            ->where('procedures', $procedure)
            ->whereDate('date_created', Carbon::today()->toDateString())
            ->orderBy('request_no', 'desc')
            ->first();

        if ($recent_request) {
            $request_no = (int) $recent_request->request_no + 1;
        }
        return $request_no;

    }

    public function show_delivery_request($procedure)
    {

        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->where('procedures', $procedure)->where('is_transact', 1)->where('user_id', Auth::user()->id)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {

                if ($data->status == 0 || $data->request_status != 'Pending') {
                    return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-dark btn-sm btn_show_data  spec_input"><i class="bi bi-eye-fill"></i></button> 
                       </center> ';
                }
                return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-dark btn-sm btn_show_data  spec_input"><i class="bi bi-eye-fill"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center> ';
            })
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

            ->addColumn('req_status', function ($data) use ($procedure) {
                if ($data->status == 0) {
                    return ' <h5> <span class="badge rounded-pill bg-danger">Cancelled</span></h5>';
                }
                return $this->status_html($data->request_status, $procedure, $data->id);

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
                $url = dynamic_file($path);
                return ' <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>';

            })
            ->rawColumns(['action', 'view_file_request', 'req_status'])
            ->make(true);

    }

    public function get_delivery_data($id)
    {
        try {


            $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname', 'get_admin_data', 'get_messenger_name'])->find($id);
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

            $direction = 'nofile';
            $filename = '';
            $messenge_file = AitsFileModel::where('table_name', 'AitsDelivery')
                ->where('status', 1)
                ->where('attachment_id', $id)
                ->where('delivery_mess', 1)
                ->first();

            if ($messenge_file) {

                $path = $messenge_file->folder_name . '/' . $messenge_file->year . '/' . $messenge_file->file_name;
                $direction = dynamic_file($path);
                $filename = $messenge_file->orig_file;
            }


            $data->req_name = $data['get_requestor_fullname']['firstname'] . ' ' . $data['get_requestor_fullname']['lastname'];
            $data->req_stat = $stat;
            $data->request_number = request_number($data->request_no, $data->date_created);
            $data->date_requested = date_converter($data->date_created);
            $data->date_assign = date_converter($data->date_assign);
            $data->procedure_date = date_converter($data->procedure_date);
            $data->messenger_file = $direction;
            $data->file_name = $filename;


            return response()->json([
                'msg' => 'Successfully Inserted Request Room',
                'status' => 200,
                'data' => $data,
                "isValid" => true,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }



    public function status_html($status, $procedure, $request_id)
    {

        if ($procedure == 1) {
            if ($status == "Pending") {
                $stat = '<span class="badge rounded-pill bg-warning">Undelivered</span>';
            } else if ($status == "Delivered") {
                $stat = '   <span class="badge rounded-pill bg-success">Delivered</span>';

            } else if ($status == "Reschedule") {
                $stat = ' <span class="badge rounded-pill bg-secondary">Rescheduled</span> ';

            } else {
                $stat = '<span class="badge rounded-pill bg-danger">Error</span>';
            }
            return '<center><h5>' . $stat . '</h5></center>';
        }

        if ($procedure == 2) {
            if ($status == "Pending") {
                $stat = '<span class="badge rounded-pill bg-warning">Uncollected</span>';
            } else if ($status == "Delivered") {
                $stat = '<span class="badge rounded-pill bg-success">Collected</span>';
            } else if ($status == "Reschedule") {
                $stat = ' <span class="badge rounded-pill bg-secondary">Rescheduled</span> ';

            } else {
                $stat = '<span class="badge rounded-pill bg-danger">Error</span>';
            }
            return '<center><h5>' . $stat . '</h5></center>';
        }

        if ($procedure == 3) {
            if ($status == "Pending") {
                $stat = '<span class="badge rounded-pill bg-warning">Pending</span>';
            } else if ($status == "Delivered") {
                $stat = '<span class="badge rounded-pill bg-success">Pick up</span>';
            } else if ($status == "Reschedule") {
                $stat = ' <span class="badge rounded-pill bg-secondary">Rescheduled</span> ';

            } else {
                $stat = '<span class="badge rounded-pill bg-danger">Error</span>';
            }
            return '<center><h5>' . $stat . '</h5></center>';
        }






    }




    public function delete_delivery_request($id)
    {
        $data = AitsDelivery::where('id', $id)->update(['status' => 0]);

        $object = [
            'user_id' => Auth::user()->id,
            'page' => 'Logistic Request',
            'description' => 'Delete logistics Request',
            'table_name' => 'aits_deliveries',
            'transact_id' => $id,
            'status' => 1,
            'date_created' => Carbon::now(),
        ];

        insert_audit($object);

    }

    public function edit_delivery_request(Request $request)
    {

        try {

            $validated = Validator::make(
                $request->all(),
                [
                    'name_receiver' => [
                        'required',
                    ],
                    'company_name' => ['required'],
                    'contact_receiver' => ['required'],
                    'delivery_type_id' => ['required'],
                    'area_id' => ['required'],
                    'count_documents' => ['required'],
                    'complete_address' => ['required'],
                    'delivery_remarks' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $old_data = AitsDelivery::find($request->id);


            $logs = AitsDelivery::create([
                'orig_id' => $request->id,
                'edited_by' => Auth::user()->id,
                'company_name' => $old_data->company_name,
                'name_receiver' => $old_data->name_receiver,
                'delivery_type_id' => $old_data->delivery_type_id,
                'area_id' => $old_data->area_id,
                'count_documents' => $old_data->count_documents,
                'complete_address' => $old_data->complete_address,
                'delivery_remarks' => $old_data->delivery_remarks,
                'procedures' => $old_data->procedures,
                'date_created' => Carbon::now(),
                'status' => 0,
                'is_transact' => 0,
            ]);

            if ($request->file('file')) {
                AitsFileModel::where('procedure', $request->procedures)->where('attachment_id', $request->id)->where('table_name', 'AitsDelivery')->update(['status' => 0]);
                $this->uploade_file_transit($request->id, 'AitsDelivery', $request->file('file'), $request->procedures);
            }
            AitsDelivery::where('id', $request->id)->update($request->except(['id', 'file']));


            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Logistic Request',
                'description' => 'Edit logistics Request',
                'table_name' => 'aits_deliveries',
                'transact_id' => $request->id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];


            insert_audit($object);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }

}
