<?php

namespace App\Http\Controllers;
use App\Models\AitsRequestCloser;
use Carbon\Carbon;
use App\Models\AitsNotif;
use App\Models\AitsDriver;
use Illuminate\Http\Request;
use App\Models\AitsShuttleType;
use App\Models\AitsVehicleModel;
use App\Models\AitsShuttleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DriverController extends Controller
{
    //


    public function driver_view()
    {
        return view('aits_pages.aits_driver_viewing_page');
    }


    public function driver_data()
    {
        $data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data', 'get_car_data', 'get_driver_data'])
            ->where('driver_id', Auth::user()->id)
            ->where('status', 1);
        $data = $data->get();

        $new_controller = new Aits_Transit_Controller();
        return $new_controller->transit_data_table($data);


    }


    public function upload_driver(Request $request)
    {
        try {
            $this->uploade_file_transit($request->id, "driver_file", 'driver_file', $request->file('file'));

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }
}
