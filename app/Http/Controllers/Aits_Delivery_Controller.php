<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class Aits_Delivery_Controller extends Controller
{




    public function show_data()
    {

       return UserModel::with(['get_user_data'])->limit(5)->get();

    }

}
