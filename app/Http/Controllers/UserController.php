<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function user_manage_view()
    {

        return view("aits_pages.aits_usermanage");
    }

    // $ticket = DB::connection('ict_ticketing')
    // ->table('ref_departments') 
    // ->where('id', 1001)
    // ->first();




    public function add_user_data(Request $request)
    {


    }

    public function retrieve_department()
    {


    return $ticket = DB::connection('ict_ticketing')
        ->table('ref_departments') 
        ->where('id', 1001)
        ->first();
    }




    public function retrieve_user($id)
    {



    }



    public function update_user(Request $request)
    {




    }


}
