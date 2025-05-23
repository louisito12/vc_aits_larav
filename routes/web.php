<?php

use App\Http\Controllers\Aits_Car_Management_Controller;
use App\Http\Controllers\Aits_Delivery_Controller;
use App\Http\Controllers\Aits_Request_Room_approval_Controller;
use App\Http\Controllers\Aits_Request_Room_Controller;
use App\Http\Controllers\Aits_Transit_Controller;
use App\Http\Controllers\AitsDeliveryApprove;
use App\Http\Controllers\AitsTransitApproval;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RequestRoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    Route::get('delete_request/{id}', 'delete_request')->name('delete_request');
});

Route::controller(Aits_Request_Room_approval_Controller::class)->group(function () {
    Route::get('get_room_approval_data', 'get_room_approval_data')->name('get_room_approval_data');
    Route::get('approved_room_request/{id}/{approve}', 'approved_room_request')->name('approved_room_request');
});


Route::controller(Aits_Transit_Controller::class)->group(function () {
    Route::post('aits_save_shuttle_request', 'aits_save_shuttle_request')->name('aits_save_shuttle_request');
    Route::get('get_shuttel_request_data', 'get_shuttel_request_data')->name('get_shuttel_request_data');
    Route::get('retrieve_shuttle_request/{id}', 'retrieve_shuttle_request')->name('retrieve_shuttle_request');
    Route::get('delete_shuttle_request/{id}', 'delete_shuttle_request')->name('delete_shuttle_request');
    Route::post('update_shuttle_request', 'update_shuttle_request')->name('update_shuttle_request');
    Route::get('show_list_managers', 'show_list_managers')->name('show_list_managers');
});


Route::controller(Aits_Delivery_Controller::class)->group(function () {
    Route::post('aits_save_delivery', 'aits_save_delivery')->name('aits_save_delivery');
    Route::get('show_delivery_request', 'show_delivery_request')->name('show_delivery_request');
    Route::get('show_delivery_request', 'show_delivery_request')->name('show_delivery_request');
    Route::get('get_delivery_data/{id}', 'get_delivery_data')->name('get_delivery_data');
    Route::get('delete_delivery_request/{id}', 'delete_delivery_request')->name('delete_delivery_request');
    Route::post('edit_delivery_request', 'edit_delivery_request')->name('edit_delivery_request');
});


Route::controller(Aits_Car_Management_Controller::class)->group(function () {
    Route::post('save_vehicle', 'save_vehicle')->name('save_vehicle');
    Route::get('get_vehicle_data', 'get_vehicle_data')->name('get_vehicle_data');
    Route::get('get_car_details/{id}', 'get_car_details')->name('get_car_details');
    Route::post('edit_vehicle', 'edit_vehicle')->name('edit_vehicle');
});


Route::controller(AitsTransitApproval::class)->group(function () {
    Route::Get('get_approval_transit', 'get_approval_transit')->name('get_approval_transit');
    Route::Get('disapprove_shuttle/{id}', 'disapprove_shuttle')->name('disapprove_shuttle');
    Route::post('approve_shuttle_request', 'approve_shuttle_request')->name('approve_shuttle_request');
});









//page authentication
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

});


// role -> admin,driver('itenerary arrive'),messenger(''),user
// Route::get('show_data', [Aits_Delivery_Controller::class, 'show_data'])->name('show_data');