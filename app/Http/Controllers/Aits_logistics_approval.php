<?php

namespace App\Http\Controllers;

use App\Models\AitsDelivery;
use App\Models\AitsMessenger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\DepartmentModel;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Validator;

class Aits_logistics_approval extends Controller
{


    public function get_logistics_request()
    {

        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->where('is_transact', 1)
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
                return $aits_deliver->status_html($data->request_status, $data->procedures,$data->if);

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

                return '
             <div  class="btn-group dropstart input_spec my-1">
            <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="1" data-id="' . $data->id . '" href="javascript:void(0);">Assign Messenger</a></li>
                <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="2" data-id="' . $data->id . '" href="javascript:void(0);">Reschedule</a></li>
                <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
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
                    'messenger_id' => [
                        'required',
                    ],
                    'procedure_date' => ['required'],

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

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'data' => [],
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

}




//1 = delivery, 2 = collection , 3 pickup