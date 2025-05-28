<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Aits_User_Controller extends Controller
{
    //


    public function aits_usermanagement()
    {
        // return $gender = DB::connection('ict_ticketing')->table('ref_gender')->get();
        return view('aits_pages_SA.usermanage');
    }


    public function get_data()
    {

    }
}








// citizen     {
// id: "1001",
// description: "Filipino",

// civil  
// id: "1000",
// description: "Not Applicable",

//gender


// ref_position_level
// id,desc














//citizen,civilstatus,gender,[ref_position_level],suffix,
//create project for users tbl_personal_data