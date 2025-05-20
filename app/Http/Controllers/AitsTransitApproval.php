<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AitsDriver;
use Illuminate\Http\Request;
use App\Models\AitsShuttleType;
use App\Models\AitsVehicleModel;
use App\Models\AitsShuttleRequest;
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



    public function disapprove_shuttle($id)
    {
        return AitsShuttleRequest::where('id', $id)->update([
            'approved_by' => Auth::user()->id,
            'request_status' => "Disapproved",
            "date_approved" => Carbon::now()
        ]);
    }
}
