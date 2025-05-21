<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        $type = AitsShuttleType::where('status', 1)->get();

        $driver = AitsDriver::where('status', 1)->get();
        return view(
            'aits_pages.aits_transit_approval',
            compact('car', 'driver', 'type')
        );
    }


    public function get_approval_transit()
    {



        $data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data'])
            ->where('status', 1)
            ->get();

        return app(Aits_Transit_Controller::class)->transit_data_table($data);

    }
    public function approve_shuttle_request(Request $request)
    {
        try {



            $data = AitsShuttleRequest::find($request->id);
            $validation = $this->date_validation($data->pick_up_date, $data->departure_date, $request->car_id);


            if ($validation != 0) {
                return response()->json([
                    'msg' => 'The service shuttle Car for that time is no longer available !',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            AitsShuttleRequest::where('id', $request->id)->update([
                'car_id' => $request->car_id,
                'driver_id' => $request->driver_id,
                'request_status' => 'Approved',
                'approved_by' => Auth::user()->id,
                "date_approved" => Carbon::now()

            ]);


        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }



    public function disapprove_shuttle($id)
    {
        return AitsShuttleRequest::where('id', $id)->update([
            'approved_by' => Auth::user()->id,
            'request_status' => "Disapproved",
            "date_approved" => Carbon::now()
        ]);
    }

    public function date_validation($date_from, $date_to, $car_id)
    {

        $fromDate = Carbon::parse($date_from)->format('Y-m-d H:i:s');
        $toDate = Carbon::parse($date_to)->format('Y-m-d H:i:s');

        $query = "
        SELECT COUNT(*) AS overlapping_count
        FROM aits_shuttle_requests    WHERE
        ((pick_up_date BETWEEN  '$fromDate' AND '$toDate')
        OR (departure_date BETWEEN  '$fromDate' AND '$toDate')
        OR ('$fromDate' BETWEEN pick_up_date AND departure_date)
        OR ('$toDate' BETWEEN pick_up_date AND departure_date) )
        AND request_status='Approved' AND car_id=$car_id;
        ";


        $data = DB::connection('sqlsrv')->select($query, []);


        $count = 0;

        if ($data) {
            $count = $data[0]->overlapping_count;
        }


        return $count;

    }
}
