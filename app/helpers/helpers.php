<?php

use App\Models\Aits_audit_logs;
use App\Models\AitsProcessRemarks;
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

    if (is_null($date)) {
        return null;
    }

    $carbonDate = Carbon::make($date);
    return $carbonDate ? $carbonDate->format('M j, Y, g:i A') : null;
}

function date_coverters($date)
{
    return Carbon::parse($date)->format('Y-m-d\TH:i');
}

function date_coverters_transit($date)
{
    return Carbon::createFromFormat('Y-m-d H:i:s.v', $date)->format('Y-m-d\TH:i');
}


function date_from_to_converter_date($date)
{

}


function get_user_profile($id)
{
    return UserProfile::where('user_id', $id)->first();
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

function dynamic_file($path, $link)
{

    if (config('app.env') == 'local') {
        return ($link . '/' . $path);
    } else {
        return url(env('APP_ENV') . 'public/' . $path);
    }
}

function insert_driver()
{


    DB::table('aits_drivers')->insert([

        'fname' => 'Paul',
        'mname' => 'D.',
        'lname' => 'Makr',
        'status' => 1,
        'date_created' => Carbon::now(),
    ]);

}

function request_number($no, $date)
{
    $number = $no;
    $request_number = sprintf('%03d', $number);
    return Carbon::parse($date)->format('Y-m-d') . '-' . $request_number;
}

function add_messenger()
{

    // DB::table('aits_messengers')->insert([
    //     'fname' => 'Messenger',
    //     'mname' => 'Delivery',
    //     'lname' => 'two',
    //     'cen_user_id' => 1126,
    //     'status' => 1,
    //     'date_created' => Carbon::now(),
    // ]);
}

function insert_audit($object)
{
    Aits_audit_logs::create($object);
}


function process_remarks($object)
{

    AitsProcessRemarks::create($object);
}



// function next_date_pms($start_date, $type)
// {

//     // $type =
//     // $now = Carbon::now();
//     // echo $now->format('Y-m-d H:i:s');

//     $next_date = "";

//     if ($type == "monthly") {

//     }
//     if ($type == "yearly") {

//     }
//     if ($type == "quarterly") {

//     }
// }

function next_date_pms($start_date, $type)
{
    // Initialize Carbon instance from the start date
    $date = Carbon::parse($start_date);

    $date = Carbon::parse($start_date);

    switch ($type) {
        case 'daily':
            $date->addDay();
            break;
        case 'weekly':
            $date->addWeek();
            break;

        case 'semi-monthly':
            $date->addDays(15);
            break;

        case 'monthly':
            $date->addMonthNoOverflow();
            break;

        case 'quarterly':
            $date->addMonthsNoOverflow(3);
            break;
        case 'tri-annual':
            $date->addMonthsNoOverflow(4);
            break;
        case 'semi-annual':
            $date->addMonthsNoOverflow(6);
            break;
        case 'annual':
        case 'yearly':
            $date->addYear();
            break;

        default:
            throw new InvalidArgumentException("Invalid frequency type: {$type}");
    }


    return $date->format('Y-m-d');


}

function compare_dates($date1, $date2)
{
    // Parse the date strings into Carbon instances
    $datetime1 = Carbon::parse($date1);
    $datetime2 = Carbon::parse($date2);

    // Compare the two dates
    if ($datetime1->gt($datetime2)) {
        return 1; // $date1 is later
    } elseif ($datetime1->lt($datetime2)) {
        return -1; // $date2 is later
    } else {
        return 0; // Both dates are equal
    }
}

function roles_array($user_id)
{
    return $roles = DB::table('aits_role_access')
        ->where('user_id', $user_id)
        ->where('status', 1)
        ->pluck('role_id')
        ->toArray();

}


function add_schedule()
{


    $schedule = ['annual', 'semi-annual', 'tri-annual', 'quarterly', 'monthly', 'bi-monthly', 'semi-monthly', 'weekly', 'daily'];
    foreach ($schedule as $schedules) {


        DB::table('pms_schedule_types')->insert([
            'user_id' => Auth::user()->id,
            'date_created' => Carbon::now(),
            'schedule' => $schedules

        ]);

    }

}

function messenger_id($area_id)
{


    $data = DB::table('aits_messengers_areas')
        ->where('status', 1)
        ->where('area_id', $area_id)
        ->first();

    if ($data) {
        $data_stat = [
            'stat' => 1,
            'data' => $data
        ];

    } else {
        $data_stat = [
            'stat' => 0,
            'data' => []
        ];

    }

    return $data_stat;
}


function get_person_fname($user_id)
{
    return $data = UserProfile::where('user_id', $user_id)->first();
}






// $dateString = '2025-07-09 00:00:00.000';
// $formattedDate = Carbon::createFromFormat('Y-m-d H:i:s.u', $dateString)->format('Y-m-d');

// echo $formattedDate; // Outputs: 2025-07-09