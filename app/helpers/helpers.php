<?php

use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;







function insert_position()
{

    $insert = DB::table('aits_user_positions')->insert([
        'position' => 'System Developer',
        'date_created' => Carbon::now()
    ]);
}

function get_department($id)
{
    $ticket = DB::connection('ict_ticketing')
        ->table('ref_departments')
        ->where('id', $id)
        ->first();
}

function date_converter($date)
{


    return Carbon::parse($date)->format('M j, Y, g:i A');
}

function date_coverters($date)
{

    return Carbon::createFromFormat('Y-m-d h:i A', $date)->format('Y-m-d\TH:i');
}


function date_from_to_converter_date($date)
{

}


function get_user_profile($id)
{
    return UserProfile::where('id', $id)->first();
}

function date_converter_date($date)
{


    return Carbon::parse($date)->format('M j, Y');
}


function insert_type()
{


    $array = [
        'Accompany To The Airports',
        'Account Visit',
        'Aircon Cleaning',
        'Benefit Orientation',
        'Bidding Proposal F2F Submission',
        'Billing Concerns',
        'Business Presentation'
    ];

    $data = array_map(function ($type) {
        return [
            'type' => $type,
            'status' => 1,
            'date_created' => Carbon::now()
        ];
    }, $array);

    DB::table('aits_shuttle_types')->insert($data);

}
