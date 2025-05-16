<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Aits_Transit_Controller extends Controller
{


    public function transit_request_view()
    {
        return view('aits_pages.aits_transit_request_view');
    }
}
