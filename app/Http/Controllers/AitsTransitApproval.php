<?php

namespace App\Http\Controllers;

use App\Models\AitsRequestCloser;
use Carbon\Carbon;
use App\Models\AitsNotif;
use App\Models\AitsDriver;
use Illuminate\Http\Request;
use App\Models\AitsShuttleType;
use App\Models\AitsVehicleModel;
use App\Models\AitsShuttleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AitsTransitApproval extends Controller
{
    //

    public function aits_transit_approval_view()
    {

        $car = $models = AitsVehicleModel::
            where('expiry_date', '>', Carbon::now())
            ->where('status', 1)
            ->get();

        $close_req = AitsRequestCloser::where('status', 1)->first();
        $close_params = 0;

        if ($close_req) {
            $close_params = 1;
        }

        $type = AitsShuttleType::where('status', 1)->get();
        $driver = AitsDriver::where('status', 1)->get();

        $req_date = AitsRequestCloser::where('status', 1)->first();

        $closer = AitsRequestCloser::where('status', 1)
            ->first();

        // if ($closer) {
        //     $closer_date = $closer->date_end;
        //     if ($closer_date < Carbon::now()) {
        //         AitsRequestCloser::where('status', 1)->update([
        //             'status' => 0,
        //         ]);
        //     }
        // }



        return view(
            'aits_pages.aits_transit_approval',
            compact('car', 'driver', 'type', 'close_params')
        );
    }


    public function get_approval_transit(Request $request)
    {
        $filters_arr = [
            'all pending' => 'Pending',
            'all approved' => 'Approved',
            'all disapproved' => 'Disapproved',
            'all cancelled' => 'Cancelled'
        ];
        $filters = 'Pending';
        $data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data', 'get_car_data', 'get_driver_data'])
            ->where('status', 1);
        if ($request->pending_data) {
            $data->where('request_status', 'Pending');
        }
        if ($request->apt_date) {
            $data->whereDate('appointment_date', $request->apt_date);
        }
        if ($request->filter_data) {
            if ($request->filter_data != 'all') {
                $filters = $filters_arr[$request->filter_data];
                $data->where('request_status', $filters);
            }
        }

        $data = $data->get();
        $new_controller = new Aits_Transit_Controller();
        return $new_controller->transit_data_table($data);


    }
    public function approve_shuttle_request(Request $request)
    {
        try {
            $data = AitsShuttleRequest::find($request->id);
            $spec_approve = 0;
            if ($request->spec_approval == 3) {
                $spec_approve = 1;
            }

            if ($request->spec_approval != 3) {
                $validation = $this->date_validation($data->departure_date, $data->pick_up_date, $request->car_id, $request->driver_id);
                if ($validation != 0) {
                    return response()->json([
                        'msg' => 'The service shuttle Car for that time is no longer available !',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }

            AitsShuttleRequest::where('id', $request->id)->update([
                'car_id' => $request->car_id,
                'driver_id' => $request->driver_id,
                'request_status' => 'Approved',
                'approved_by' => Auth::user()->id,
                "date_approved" => Carbon::now(),
                'is_special_approve' => $spec_approve,
            ]);

            $object = [
                'attachment_id' => $request->id,
                'remarks' => $request->remarks,
                'procedures' => 'Approve- Shuttle Request',
                'table_name' => 'aits_shuttle_requests',
                'users_id' => Auth::user()->id,
                'status' => 1,
                'ate_created' => Carbon::now(),

            ];
            process_remarks($object);

            AitsNotif::create([
                'aits_table' => "aits_shuttle_requests",
                'aits_id' => $request->id,
                'aits_process' => 'Approve',
                'send_to_user_id' => $data->user_id,
                'date_created' => Carbon::now(),
                'remarks' => $request->remarks,
            ]);
            //driver remarks

            AitsNotif::create([
                'aits_table' => "aits_shuttle_requests",
                'aits_id' => $request->id,
                'aits_process' => 'Approve_driver',
                'send_to_user_id' => $request->driver_id,
                'date_created' => Carbon::now(),
                'remarks' => $request->driver_remarks,
                'is_driver' => 1,
            ]);

            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Admin Shuttle Request Module',
                'description' => 'Approve Request Shuttle',
                'table_name' => 'aits_shuttle_requests',
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



    public function disapprove_shuttle($id, $remarks)
    {
        AitsShuttleRequest::where('id', $id)->update([
            'approved_by' => Auth::user()->id,
            'request_status' => "Disapproved",
            "date_approved" => Carbon::now()
        ]);

        $object = [
            'attachment_id' => $id,
            'remarks' => $remarks,
            'procedures' => 'Disapprove Shuttle Request',
            'table_name' => 'aits_shuttle_requests',
            'users_id' => Auth::user()->id,
            'status' => 1,
            'ate_created' => Carbon::now(),

        ];
        process_remarks($object);
        $data = AitsShuttleRequest::where('id', $id)->first();

        AitsNotif::create([
            'aits_table' => "aits_shuttle_requests",
            'aits_id' => $id,
            'aits_process' => 'Disapprove',
            'send_to_user_id' => $data->user_id,
            'date_created' => Carbon::now(),
            'remarks' => $remarks,
        ]);

        $object = [
            'user_id' => Auth::user()->id,
            'page' => 'Admin Shuttle Request Module',
            'description' => 'Disapprove Request Shuttle',
            'table_name' => 'aits_shuttle_requests',
            'transact_id' => $id,
            'status' => 1,
            'date_created' => Carbon::now(),
        ];
        insert_audit($object);
    }

    public function date_validation($date_from, $date_to, $car_id, $driver_id)
    {

        // $fromDate = Carbon::parse($date_from)->format('Y-m-d H:i:s');
        // $toDate = Carbon::parse($date_to)->format('Y-m-d H:i:s');

        // $query = "
        // SELECT COUNT(*) AS overlapping_count
        // FROM aits_shuttle_requests    WHERE
        // ((pick_up_date BETWEEN  '$fromDate' AND '$toDate')
        // OR (departure_date BETWEEN  '$fromDate' AND '$toDate')
        // OR ('$fromDate' BETWEEN pick_up_date AND departure_date)
        // OR ('$toDate' BETWEEN pick_up_date AND departure_date) )
        // AND request_status='Approved' AND car_id=$car_id;
        //appointment_date
        // ";


        //         $query = "
        // SELECT COUNT(*) AS overlapping_count
        // FROM aits_shuttle_requests
        // WHERE
        // (
        //   (pick_up_date    BETWEEN '$fromDate' AND '$toDate')
        //   OR (departure_date BETWEEN '$fromDate' AND '$toDate')
        //   OR ('$fromDate'   BETWEEN pick_up_date    AND departure_date)
        //   OR ('$toDate'     BETWEEN pick_up_date    AND departure_date)
        //   OR (appointment_date BETWEEN '$fromDate' AND '$toDate')
        // )
        // AND request_status = 'Approved'
        // AND car_id = $car_id;
        // ";

        $fromDate = Carbon::parse($date_from)->format('Y-m-d H:i:s');
        $toDate = Carbon::parse($date_to)->format('Y-m-d H:i:s');

        // $query = "
        //     SELECT COUNT(*) AS overlapping_count
        //     FROM aits_shuttle_requests WHERE
        //     ((pick_up_date    BETWEEN '$fromDate' AND '$toDate')
        //     OR (departure_date BETWEEN '$fromDate' AND '$toDate')
        //     OR ('$fromDate'   BETWEEN pick_up_date    AND departure_date)
        //     OR ('$toDate'     BETWEEN pick_up_date    AND departure_date)
        //     OR (appointment_date BETWEEN '$fromDate' AND '$toDate'))
        //     AND request_status = 'Approved'
        //     AND car_id =$car_id AND driver_id=$driver_id";

        $overlappingCount = AitsShuttleRequest::where(function ($query) use ($fromDate, $toDate) {
            $query->whereBetween('pick_up_date', [$fromDate, $toDate])
                ->orWhereBetween('departure_date', [$fromDate, $toDate])
                ->orWhereBetween('appointment_date', [$fromDate, $toDate]);
        })
            ->where('request_status', 'Approved')
            ->where('car_id', $car_id)
            ->where('driver_id', $driver_id)
            ->count();

        // $data = DB::connection('sqlsrv')->select($query, []);
        $count = 0;
        if ($overlappingCount > 0) {
            $count = $overlappingCount;
        }
        return $count;

    }
}
