<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AitsNotif;
use Illuminate\Http\Request;
use App\Models\AitsRoomModel;
use App\Models\AitsEventModel;
use App\Models\AitsRequestRoomModel;
use Illuminate\Support\Facades\Auth;

class Aits_Request_Room_approval_Controller extends Controller
{


    public function room_approval_view()
    {
        $room = AitsRoomModel::where('status', 1)->get();
        $event = AitsEventModel::where('status', 1)->get();


        return view('aits_pages.aits_room_request_approval', compact(['room', 'event']));

    }

    public function get_room_approval_data(Request $request)
    {

        try {

            // $data = AitsRequestRoomModel::
            //     where('is_transact', 1);
            // if ($request->pending_all) {
            //     $data->where('request_status', 'Pending');
            // }
            // $data = $data->get();
            // $data = AitsRequestRoomModel::where('is_transact', 1)
            //     ->when($request->pending_all, function ($query) {
            //         return $query->where('request_status', 'Pending');
            //     })
            //     ->when($request->filter_Data, function ($query) use ($request) {
            //         $filter = "Pending";
            //         return $query->where('request_status', $filter);
            //     })
            //     ->get();


            $filters_arr = [
                'all pending' => 'Pending',
                'all approved' => 'Approved',
                'all disapproved' => 'Disapproved'
            ];
            $filters = 'Pending';



            $data = AitsRequestRoomModel::where('is_transact', 1);
            if ($request->pending_all) {
                $data->where('request_status', 'Pending')->where('status', 1);
            }
            if ($request->filter_data) {
                if ($request->filter_data != 'all') {
                    $filters = $filters_arr[$request->filter_data];
                    $data->where('request_status', $filters);
                }
            }
            $data = $data->get();



            $controller = new Aits_Request_Room_Controller();
            return $controller->room_request_datatable($data);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }

    public function approved_room_request($id, $approve, $remarks)
    {
        try {
            if ($approve == 1) {
                $status = 'Approved';
            }
            if ($approve == 2) {
                $status = 'Disapproved';

            }


            $object = [
                'attachment_id' => $id,
                'remarks' => $remarks,
                'procedures' => $status . ' of Room Request',
                'table_name' => 'aits_request_room_models',
                'users_id' => Auth::user()->id,
                'status' => 1,
                'ate_created' => Carbon::now(),

            ];
            process_remarks($object);

            $request_room_details = AitsRequestRoomModel::where('id', $id)->first();

            AitsNotif::create([
                'aits_table' => "aits_request_room_models",
                'aits_id' => $id,
                'aits_process' => $status,
                'send_to_user_id' => $request_room_details->request_by,
                'date_created' => Carbon::now(),
                'remarks' => $remarks,
            ]);


            $query = AitsRequestRoomModel::where('id', $id)->update([
                'approve_by' => Auth::user()->id,
                'approve_date' => Carbon::now(),
                'request_status' => $status,
            ]);


            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Admin Request Module',
                'description' => $status . ' Room',
                'table_name' => 'aits_request_room_models',
                'transact_id' => $id,
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
