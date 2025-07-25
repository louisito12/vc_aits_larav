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


        $vehicle = AitsVehicleModel::where('status', 1)
            ->where('expiry_date', '>=', Carbon::now())
            ->get();
        $type = AitsShuttleType::where('status', 1)->get();
        // $manager = DB::connection('main_user')
        //     ->table('tbl_personal_datas')
        //     ->where('poslevel_id', 1003)
        //     ->orderBy('firstname','asc')
        //     ->get();

        $manager_sql = "
        SELECT users.id as user_id,tbl_personal_datas.firstname,tbl_personal_datas.lastname FROM users 
        LEFT JOIN tbl_personal_datas  ON users.id = tbl_personal_datas.user_id
        WHERE tbl_personal_datas.poslevel_id = 1003 AND users.isactive= 1
        ORDER BY  tbl_personal_datas.firstname ASC";


        $manager = DB::connection('main_user')->select(
            $manager_sql,
            []
        );



        return view('aits_pages.aits_driver_viewing_page', compact('vehicle', 'type', 'manager'));
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


    public function driver_upload_remarks(Request $request)
    {
        try {
            $driver_remarks = AitsShuttleRequest::where('id', $request->id)->update([
                'driver_stamp' => Carbon::now(),
                'driver_remarks' => $request->driver_remarks,
            ]);

            $transit_cotroller = new Aits_Transit_Controller();
            $transit_cotroller->uploade_file_transit($request->id, "driver_file", 'driver_file', $request->file('file'));


            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Driver page',
                'description' => 'Upload a file',
                'table_name' => 'aits_shuttle_requests',
                'transact_id' => $request->id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];
            insert_audit($object);



        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }
}
