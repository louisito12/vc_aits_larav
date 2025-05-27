<?php

namespace App\Http\Controllers;

use App\Models\AitsArea;
use Illuminate\Http\Request;
use App\Models\AitsMessenger;
use App\Models\AitsDeliveryType;

class AitsDeliveryApprove extends Controller
{



    public function aits_deliver_assign()
    {

        $messenger = AitsMessenger::where('status', 1)->get();

        $type = AitsDeliveryType::where('status', 1)->get();
        $area = AitsArea::where('status', 1)->get();

        return view('aits_pages.aits_delivery_assigned', compact('messenger', 'type', 'area'));
    }
}
