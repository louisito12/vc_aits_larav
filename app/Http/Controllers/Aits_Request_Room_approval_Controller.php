<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    public function get_room_approval_data()
    {

        try {

            $data = AitsRequestRoomModel::where('status', 1)->get();
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

    public function approved_room_request($id, $approve)
    {
        try {
            if ($approve == 1) {
                $status = 'Approved';
            }
            if ($approve == 2) {
                $status = 'Disapproved';

            }

            $query = AitsRequestRoomModel::where('id', $id)->update([
                'approve_by' => Auth::user()->id,
                'approve_date' => Carbon::now(),
                'request_status' => $status,
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }
}
