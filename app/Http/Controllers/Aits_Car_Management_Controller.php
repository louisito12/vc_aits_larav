<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AitsVehicleModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class Aits_Car_Management_Controller extends Controller
{



    public function aits_car_view()
    {
        return view('aits_pages.aits_vehicle_management');
    }



    public function save_vehicle(Request $request)
    {
        $request->merge(['status' => 1, 'date_created' => Carbon::now(), 'user_id' => Auth::user()->id, 'is_transact' => 1]);
        AitsVehicleModel::create($request->all());

    }

    public function get_vehicle_data()
    {


        try {
            $data = AitsVehicleModel::where('status', 1)->get();


            return DataTables::of($data)
                ->addColumn('status', function ($data) {
                    $expiry = $data->expiry_date;
                    $expiryDate = Carbon::parse($expiry);
                    $currentDate = Carbon::now();


                    if ($currentDate->greaterThan($expiryDate)) {
                        $status = 'expired';
                    } else {
                        $status = 'valid';
                    }

                    return $this->status_html($status);

                })
                ->addColumn('action', function ($data) {

                    return '<center>
                        <div  class="btn-group dropstart input_spec my-1 ">
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle rounded-pill"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"  data-id="' . $data->id . '" href="javascript:void(0);">Add</a></li>
                                <li><a class="dropdown-item btn_view "  data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                                <li><a class="dropdown-item btn_edit" data-id="' . $data->id . '" href="javascript:void(0);">Edit</a></li>
                            </ul>
                        </div>
                        </center>
                    ';

                })
                ->addColumn('expiry_date', function ($data) {
                    $expiry = $data->expiry_date;
                    return date_converter_date($expiry);

                })
                ->rawColumns(['action', 'status'])
                ->make(true);

        } catch (\Exception $e) {

        }






    }


    public function status_html($status)
    {

        if ($status == "valid") {
            $stat = '
            <span class="badge rounded-pill bg-success">Valid</span>
            ';
        } else if ($status == "expired") {
            $stat = '
            <span class="badge rounded-pill bg-danger">Expired</span>
            
            ';
        } else {
            $stat = '
            <span class="badge rounded-pill bg-danger">Error</span>
            
            ';
        }

        return '<center><h5>' . $stat . '</h5></center>';
    }


    public function get_car_details($id)
    {

        try {

            $data = AitsVehicleModel::find($id);
            $data->start_date = Carbon::createFromFormat('Y-m-d H:i:s.u', $data->start_date)->format('Y-m-d');
            $data->expiry_date = Carbon::createFromFormat('Y-m-d H:i:s.u', $data->expiry_date)->format('Y-m-d');



            return [

                'msg' => 'Succesfully Provided',
                'data' => $data,
                'status' => 200,
                "isValid" => true,
            ];



        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function edit_vehicle(Request $request)
    {


        try {
            $data = AitsVehicleModel::find($request->id);


            $this->vehicle_insert_logs($data);
            AitsVehicleModel::where('id', $request->id)->update($request->except(['id']));

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }

    public function vehicle_insert_logs($data)
    {


        AitsVehicleModel::create([
            'is_transact' => 0,
            'brand' => $data->brand,
            'model' => $data->model,
            'plate_number' => $data->plate_number,
            'start_date' => $data->start_date,
            'expiry_date' => $data->expiry_date,
            'orig_id' => $data->orig_id,
            'date_created' => Carbon::now(),
            'edit_user_id' => Auth::user()->id,
            'user_id' => $data->user_id,

        ]);
    }




}
