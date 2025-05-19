<?php

namespace App\Http\Controllers;

use App\Models\AitsShuttleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AitsVehicleModel;

class Aits_Transit_Controller extends Controller
{


    public function transit_request_view()
    {
        $vehicle = AitsVehicleModel::where('status', 1)
            ->where('expiry_date', '>=', Carbon::now())
            ->get();
        $type = AitsShuttleType::where('status', 1)->get();

        return view('aits_pages.aits_transit_request_view', compact('vehicle', 'type'));
    }

    public function aits_save_shuttle_request(Request $request)
    {


        return $request->all();
    }
}
