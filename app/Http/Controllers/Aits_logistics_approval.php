<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\AitsNotif;
use App\Models\AitsDelivery;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\AitsMessenger;
use App\Models\DepartmentModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class Aits_logistics_approval extends Controller
{
    public function get_logistics_request(Request $request)
    {


        $logistics_arr = [
            'all' => 0,
            'for delivery' => 1,
            'for collection' => 2,
            'for pick up' => 3,
        ];

        $filter = [
            'all' => 0,
            'pending' => 'Pending',
            'rescheduled' => 'Reschedule',
            'completed' => 'Delivered'
        ];



        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname', 'get_messenger_name'])
            ->where('status', 1);
        if ($request->pending_data) {
            $data->where('request_status', 'Pending');
        }
        if ($request->filt_params) {
            $filters = $filter[$request->filt_params];
            if ($filters != 0) {
                $data->where('request_status', $filters);
            }
        }
        if ($request->logs_params) {
            $logistics = $logistics_arr[$request->logs_params];
            if ($logistics != 0) {
                $data->where('procedures', $logistics);
            }
        }

        $data = $data->orderBy('procedures', 'asc')
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
            ->addColumn('collection_number', function ($data) {
                // $collect_number = '';
                // if ($data->delivery_type_id == 3) {
                //     $collect_number = 
                // }
                if ($data->delivery_type_id == 3) {
                    return $data->count_documents;
                } else {
                    return '';
                }


            })

            ->addColumn('req_status', function ($data) {
                if ($data->status == 0) {
                    return ' <h5> <span class="badge rounded-pill bg-danger">Cancelled</span></h5>';
                }
                $aits_deliver = new Aits_Delivery_Controller();
                return $aits_deliver->status_html($data->request_status, $data->procedures, $data->if);

            })
            ->addColumn('messenger_name_data', function ($data) {
                $mess_name = '';
                if ($data->get_messenger_name) {
                    $mess_name = $data['get_messenger_name']['firstname'] . ' ' . $data['get_messenger_name']['lastname'];
                }
                return $mess_name;
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

                $hidden = $data->messenger_id != null ? 'hidden' : '';
                $cancel = ($data->request_status == 'Cancelled') ? 'hidden' : '';
                $hidden = 'hidden';
                return '
             <div  class="btn-group dropstart input_spec my-1">
            <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="1" data-id="' . $data->id . '" href="javascript:void(0);">Assign Messenger</a></li>
                <li hidden><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="2" data-id="' . $data->id . '" href="javascript:void(0);">Reschedule</a></li>
                <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                    <li><a class="dropdown-item btn_delete" ' . $cancel . ' data-id="' . $data->id . '" href="javascript:void(0);">Cancel</a></li>
                
            </ul>
             </div>  ';

            })

            ->rawColumns(['action', 'view_file_request', 'req_status', 'messenger_stat'])
            //ginagawa neto yung html char is ginagawa nyang html attr-> kapag dinakalagay magigign text lang yan.
            ->make(true);

    }

    public function assigned_messenger(Request $request)
    {
        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'messenger_id' => ['required'],
                    'procedure_date' => ['required'],
                    'assign_remarks' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            // $messenger_data = AitsMessenger::find($request->messenger_id)->cen_user_id;
            $request->merge([
                // 'messenger_id' => $messenger_data,
                'assign_by' => Auth::user()->id,
                'date_assign' => Carbon::now(),
                'procedure_date' => Carbon::parse($request->procedure_date, 'Asia/Manila')->format('Y-m-d h:i A'),

            ]);

            AitsDelivery::where('id', $request->id)->update($request->except(['id']));


            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Admin Logistic Request',
                'description' => 'Assign messenger logistics Request',
                'table_name' => 'aits_deliveries',
                'transact_id' => $request->id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];


            // AitsNotif::create([
            //     'aits_table' => "aits_shuttle_requests",
            //     'aits_id' => $request->id,
            //     'aits_process' => 'assign_messenger',
            //     'send_to_user_id' => $request->messenger_id,
            //     'date_created' => Carbon::now(),
            //     'remarks' => $request->assign_remarks,
            // ]);
            insert_audit($object);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'data' => [],
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }






    public function get_data_email()
    {

        $request_logistic = AitsNotif::where('aits_table', 'aits_deliveries')
            ->where('notif', 0)
            ->where('status', 1)
            ->get();

        $data = [];

        foreach ($request_logistic as $email_logistic) {
            $data_log = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->where('id', $email_logistic->aits_id)->first();

            if ($data_log) {
                $number = $data_log->request_no ?: 0;
                $request_number = sprintf('%03d', $number);
                $req_number = Carbon::parse($email_logistic->date_created)->format('Y-m-d') . '-' . $request_number;
                $procedure = $data_log->procedures;

                if ($procedure == 1) {
                    $stat = 'For Delivery';
                }
                if ($procedure == 2) {
                    $stat = 'For Collection';
                }
                if ($procedure == 3) {
                    $stat = 'For Pick Up';
                }

                $subject = 'Notification for Logisitic Request' . ' ' . $stat . ' Request#' . ' ' . $req_number;

                $process = "";
                if ($email_logistic->aits_process == 'Delivered messenger') {
                    $process = $stat . ' ' . 'is completed';
                }
                if ($email_logistic->aits_process == 'Request') {
                    $process = 'Request is for Assigning';
                }

                if ($email_logistic->aits_process == 'Reschedule messenger') {
                    $process = $stat . ' ' . 'is rescheduled';
                }
                $data = [
                    'requestor' => $data_log['get_requestor_fullname']['firstname'] . ' ' . $data_log['get_requestor_fullname']['lastname'],
                    // 'request_number' => $req_number,
                    'type' => $data_log['get_delivery_type']['del_type'],
                    'reqeust_for' => $stat,
                    'date_requested' => date_converter($email_logistic->date_created),
                    'area' => $data_log['get_area_request']['area'],
                    'company_name' => $data_log->company_name,
                    'address' => $data_log->complete_address,
                    "trans_process" => 3,
                    'process' => $process,
                    "subject" => $subject,
                ];

            }

        }

        return $data;

    }
}




//1 = delivery, 2 = collection , 3 pickup