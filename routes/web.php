<?php

use Carbon\Carbon;
use App\Models\PmsFiles;
use App\Mail\RequestMail;
use App\Mail\ManulifeMail;
use App\Models\AitsDelivery;
use App\Models\AitsRoleList;
use App\Models\AitsRequestCloser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Aits_Dashboard;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AitsDeliveryApprove;
use App\Http\Controllers\AitsTransitApproval;
use App\Http\Controllers\Aits_User_Controller;
use App\Http\Controllers\Aits_roles_controller;
use App\Http\Controllers\PmsApprovalController;
use App\Http\Controllers\RequestRoomController;
use App\Http\Controllers\Aits_logistics_approval;
use App\Http\Controllers\Aits_Transit_Controller;
use App\Http\Controllers\PmsvalidationController;
use App\Http\Controllers\Aits_Delivery_Controller;
use App\Http\Controllers\AitsAssignAreaController;
use App\Http\Controllers\Aits_Messenger_Controller;
use App\Http\Controllers\Pms_Maintenance_Controller;
use App\Http\Controllers\Aits_Request_Room_Controller;
use App\Http\Controllers\Aits_Car_Management_Controller;
use App\Http\Controllers\Aits_Request_Room_approval_Controller;
use App\Models\Pms_Details;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {


    if (Auth::check()) {

        return redirect()->route('aits_dashboard');
    }
    return view('login');
})->name('login');

Route::get('registed_user', function () {
    if (Auth::check()) {

        return redirect()->route('aits_dashboard');
    }
    $gender = DB::connection('ict_ticketing')->table('ref_gender')->get();
    $citizen = DB::connection('ict_ticketing')->table('ref_citizenship')->get();
    $civil = DB::connection('ict_ticketing')->table('ref_civil_status')->get();
    $department = DB::connection('ict_ticketing')->table('ref_departments')->get();
    $suffix = DB::connection('ict_ticketing')->table('ref_suffix')->get();
    $role = AitsRoleList::where('status', 1)->get();
    return view('aits_user_reg', compact('gender', 'citizen', 'civil', 'department', 'role', 'suffix'));


})->name('registed_user');


Route::controller(UserController::class)->group(function () {
    Route::post('register_user', 'register_user')->name('register_user');
});


Route::controller(LoginController::class)->group(function () {
    Route::post('login_function', 'login_function')->name('login_function');
    Route::get('data_tbl', 'data_tbl')->name('data_tbl');
    Route::post('get_doctors_data', 'get_doctors_data')->name('get_doctors_data');
    Route::get('logout', 'logout')->name('logout');
});



Route::controller(UserController::class)->group(function () {
    Route::post('add_user_data', 'add_user_data')->name('add_user_data');
    Route::get('retrieve_user/{id}', 'retrieve_user')->name('retrieve_user');
    Route::post('update_user', 'update_user')->name('update_user');
    Route::get('retrieve_department', 'retrieve_department')->name('retrieve_department');
});


Route::controller(Aits_Request_Room_Controller::class)->group(function () {
    Route::post('aits_save_room_request', 'aits_save_room_request')->name('aits_save_room_request');
    Route::get('get_request_data', 'get_request_data')->name('get_request_data');
    Route::get('retrieve_room_request/{id}', 'retrieve_room_request')->name('retrieve_room_request');
    Route::post('update_request_room', 'update_request_room')->name('update_request_room');
    Route::get('delete_request/{id}/{remarks}', 'delete_request')->name('delete_request');
});

Route::controller(Aits_Request_Room_approval_Controller::class)->group(function () {
    Route::post('get_room_approval_data', 'get_room_approval_data')->name('get_room_approval_data');
    Route::get('approved_room_request/{id}/{approve}/{remarks}', 'approved_room_request')->name('approved_room_request');
});



Route::controller(Aits_Dashboard::class)->group(function () {
    Route::get('room_request_dash/{params}', 'room_request_dash')->name('room_request_dash');
    Route::get('aits_dashboard_counts', 'aits_dashboard_counts')->name('aits_dashboard_counts');
    Route::get('transit_request_dash/{params}', 'transit_request_dash')->name('transit_request_dash');
    Route::get('aits_dashboard_logistics/{params}/{procedure}', 'aits_dashboard_logistics')->name('aits_dashboard_logistics');
    Route::get('aits_dashboard_logistics_mess/{params}/{procedure}', 'aits_dashboard_logistics_mess')->name('aits_dashboard_logistics_mess');
    Route::get('aits_dashboard_counts_messenger', 'aits_dashboard_counts_messenger')->name('aits_dashboard_counts_messenger');
});



Route::controller(Aits_Transit_Controller::class)->group(function () {
    Route::post('aits_save_shuttle_request', 'aits_save_shuttle_request')->name('aits_save_shuttle_request');
    Route::get('get_shuttel_request_data', 'get_shuttel_request_data')->name('get_shuttel_request_data');
    Route::get('retrieve_shuttle_request/{id}', 'retrieve_shuttle_request')->name('retrieve_shuttle_request');
    Route::get('delete_shuttle_request/{id}/{remarks}', 'delete_shuttle_request')->name('delete_shuttle_request');
    Route::post('update_shuttle_request', 'update_shuttle_request')->name('update_shuttle_request');
    Route::get('show_list_managers', 'show_list_managers')->name('show_list_managers');

});


Route::controller(Aits_Delivery_Controller::class)->group(function () {
    Route::post('aits_save_delivery', 'aits_save_delivery')->name('aits_save_delivery');
    Route::get('show_delivery_request/{procedure}', 'show_delivery_request')->name('show_delivery_request');
    Route::get('get_delivery_data/{id}', 'get_delivery_data')->name('get_delivery_data');
    Route::get('delete_delivery_request/{id}/{remarks}', 'delete_delivery_request')->name('delete_delivery_request');
    Route::post('edit_delivery_request', 'edit_delivery_request')->name('edit_delivery_request');
});


Route::controller(Aits_Car_Management_Controller::class)->group(function () {
    Route::post('save_vehicle', 'save_vehicle')->name('save_vehicle');
    Route::get('get_vehicle_data', 'get_vehicle_data')->name('get_vehicle_data');
    Route::get('get_car_details/{id}', 'get_car_details')->name('get_car_details');
    Route::post('edit_vehicle', 'edit_vehicle')->name('edit_vehicle');
});

Route::controller(AitsAssignAreaController::class)->group(function () {
    Route::Get('aits_area_user_data', 'aits_area_user_data')->name('aits_area_user_data');
    Route::post('aits_save_area_messenger', 'aits_save_area_messenger')->name('aits_save_area_messenger');
    Route::Get('aits_show_area_messenger/{id}', 'aits_show_area_messenger')->name('aits_show_area_messenger');
    Route::post('aits_mess_area_edit', 'aits_mess_area_edit')->name('aits_mess_area_edit');
    Route::Get('aits_mess_area_delete/{id}', 'aits_mess_area_delete')->name('aits_mess_area_delete');

});


Route::controller(AitsTransitApproval::class)->group(function () {
    Route::post('get_approval_transit', 'get_approval_transit')->name('get_approval_transit');
    Route::Get('disapprove_shuttle/{id}/{remarks}', 'disapprove_shuttle')->name('disapprove_shuttle');
    Route::post('approve_shuttle_request', 'approve_shuttle_request')->name('approve_shuttle_request');
});

Route::controller(Aits_logistics_approval::class)->group(function () {
    Route::post('get_logistics_request', 'get_logistics_request')->name('get_logistics_request');
    Route::post('assigned_messenger', 'assigned_messenger')->name('assigned_messenger');
    Route::get('get_data_email', 'get_data_email')->name('get_data_email');
});




Route::controller(Aits_Messenger_Controller::class)->group(function () {
    Route::get('aits_messenger_logistics', 'aits_messenger_logistics')->name('aits_messenger_logistics');
    Route::post('messenger_delivered', 'messenger_delivered')->name('messenger_delivered');

    Route::get('get_doctors_hospitals', 'get_doctors_hospitals')->name('get_doctors_hospitals');
});


Route::controller(Aits_roles_controller::class)->group(function () {
    Route::post('save_roles', 'save_roles')->name('save_roles');
    Route::get('roles_data', 'roles_data')->name('roles_data');
    Route::post('edit_roles', 'edit_roles')->name('edit_roles');
    Route::get('role_delete/{id}', 'role_delete')->name('role_delete');
});


Route::controller(Aits_User_Controller::class)->group(function () {
    Route::post('show_users', 'show_users')->name('show_users');
    Route::post('aits_save_user', 'aits_save_user')->name('aits_save_user');
    Route::get('get_user_info/{id}', 'get_user_info')->name('get_user_info');
    Route::post('aits_edit_user', 'aits_edit_user')->name('aits_edit_user');
    Route::get('users_delete/{id}', 'users_delete')->name('users_delete');
});


Route::controller(Pms_Maintenance_Controller::class)->group(function () {
    Route::post('save_pms_request', 'save_pms_request')->name('save_pms_request');
    Route::get('get_pms_data', 'get_pms_data')->name('get_pms_data');
    Route::get('get_pms_sched_table/{year}', 'get_pms_sched_table')->name('get_pms_sched_table');
    Route::get('get_pms_details/{id}', 'get_pms_details')->name('get_pms_details');
    Route::post('pms_edit_details', 'pms_edit_details')->name('pms_edit_details');
    Route::get('delete_pms_request/{id}', 'delete_pms_request')->name('delete_pms_request');
    Route::get('test_dates', 'test_dates')->name('test_dates');
    Route::post('add_pms_remarks', 'add_pms_remarks')->name('add_pms_remarks');
    Route::post('get_noted_by', 'get_noted_by')->name('get_noted_by');
});


Route::controller(PmsApprovalController::class)->group(function () {
    Route::get('get_pms_approval', 'get_pms_approval')->name('get_pms_approval');
    Route::get('approved_pms/{id}/{val}/{remarks}', 'approved_pms')->name('approved_pms');
});

Route::controller(PmsvalidationController::class)->group(function () {
    Route::get('pms_alert', 'pms_alert')->name('pms_alert');
    Route::get('save_cancellation_request/{date}/{start}', 'save_cancellation_request')->name('save_cancellation_request');
    Route::get('get_close_schedule', 'get_close_schedule')->name('get_close_schedule');
    Route::get('save_open_req', 'save_open_req')->name('save_open_req');
});
Route::controller(PdfController::class)->group(function () {
    Route::get('bp_pdf_view', 'bp_pdf_view')->name('bp_pdf_view');
    Route::get('bmi_pdf_view', 'bmi_pdf_view')->name('bmi_pdf_view');
    Route::get('oximeter_pdf_view', 'oximeter_pdf_view')->name('oximeter_pdf_view');
});


Route::controller(DriverController::class)->group(function () {
    Route::get('/driver_data', 'driver_data')->name('driver_data');
    Route::post('driver_upload_remarks', 'driver_upload_remarks')->name('driver_upload_remarks');
});
//pages authentication
Route::middleware(['auth'])->group(function () {
    Route::get('aits_dashboard', [LoginController::class, 'aits_dashboard'])->name('aits_dashboard');
    Route::get('user_manage_view', [UserController::class, 'user_manage_view'])->name('user_manage_view');
    Route::get('request_room_view', [Aits_Request_Room_Controller::class, 'request_room_view'])->name('request_room_view');
    Route::get('transit_request_view', [Aits_Transit_Controller::class, 'transit_request_view'])->name('transit_request_view');
    Route::get('room_approval_view', [Aits_Request_Room_approval_Controller::class, 'room_approval_view'])->name('room_approval_view');
    Route::get('aits_transit_approval_view', [AitsTransitApproval::class, 'aits_transit_approval_view'])->name('aits_transit_approval_view');
    Route::get('aits_delivery_view', [Aits_Delivery_Controller::class, 'aits_delivery_view'])->name('aits_delivery_view');
    Route::get('aits_car_view', [Aits_Car_Management_Controller::class, 'aits_car_view'])->name('aits_car_view');
    Route::get('aits_deliver_assign', [AitsDeliveryApprove::class, 'aits_deliver_assign'])->name('aits_deliver_assign');
    Route::get('aits_collection_view', [Aits_Delivery_Controller::class, 'aits_collection_view'])->name('aits_collection_view');
    Route::get('aits_pick_up_view', [Aits_Delivery_Controller::class, 'aits_pick_up_view'])->name('aits_pick_up_view');
    Route::get('aits_messenger_view', [Aits_Messenger_Controller::class, 'aits_messenger_view'])->name('aits_messenger_view');
    //superadmin
    Route::get('aits_roles_view', [Aits_roles_controller::class, 'aits_roles_view'])->name('aits_roles_view');
    Route::get('aits_usermanagement', [Aits_User_Controller::class, 'aits_usermanagement'])->name('aits_usermanagement');
    Route::get('aits_assign_area', [AitsAssignAreaController::class, 'aits_assign_area'])->name('aits_assign_area');
    //pms
    Route::get('pms_page', [Pms_Maintenance_Controller::class, 'pms_page'])->name('pms_page');
    Route::get('pms_approval_view', [PmsApprovalController::class, 'pms_approval_view'])->name('pms_approval_view');

    //Driver
    Route::get('driver_view', [DriverController::class, 'driver_view'])->name('driver_view');
});


Route::get('email_template', function () {
    return view('emails.email');
});

Route::get('test_pdf', [Aits_Messenger_Controller::class, 'test_pdf'])->name('test_pdf');

Route::Get('test_time', function () {
    $five_mins = Carbon::now()->addMinutes(5)->format('Y-m-d H:i:s.v');
    $time_now = Carbon::parse('2025-06-26 16:20:40.090')->addMinutes(5)->format('Y-m-d H:i:s.v');
    if ($five_mins > $time_now) {
        echo 'Help';
        return;
    }
    return 'Sige';
});


route::get('test_fullname', function () {
    // return $dept_id = get_person_fname(Auth::user()->id);
    phpinfo();
});


Route::get('test_api_data', [PmsApprovalController::class, 'test_api_data']);



// Route::Get('test_data', function () {
//     $now = Carbon::now();
//     $date_pick_up = $formatted = Carbon::parse('2025-07-22 12:00:00.000', 'Asia/Manila')->format('Y-m-d H:i:s.u');


//     if ($now > $date_pick_up) {
//         return 'Wag';
//     }

//     return 'Sige lang';


// });




// role -> admin,driver('itenerary arrive'),messenger(''),user
// Route::get('show_data', [Aits_Delivery_Controller::class, 'show_data'])->name('show_data');




// SELECT * 
// FROM your_table 
// WHERE DATE(created_at) > '2025-06-10';


// use Carbon\Carbon;

// YourModel::where('created_at', '>', Carbon::parse('2025-06-10'))->get();

// YourModel::where('created_at', '>', '2025-06-10 00:00:00')->get();