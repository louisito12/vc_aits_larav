<?php

namespace App\Http\Controllers;

use DateTime;
use Validator;
use Carbon\Carbon;
use App\Models\Pms_Details;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class Pms_Maintenance_Controller extends Controller
{



    public function pms_function()
    {




        // $nextYearStart = $currentDate->copy()->addYear()->startOfYear();

        // if ($lastMaintenanceDate->lt($nextYearStart)) {
        //     echo "Maintenance is due for next year. Proceeding to next year.\n";
        //     // Proceed to next year
        // } else {
        //     echo "Maintenance for next year is not due yet.\n";
        //     // Alert: Maintenance not due
        // }



        // $nextMonthStart = $currentDate->copy()->addMonthNoOverflow()->startOfMonth();

        // if ($lastMaintenanceDate->lt($nextMonthStart)) {
        //     echo "Maintenance is due for next month. Proceeding to next month.\n";
        //     // Proceed to next month
        // } else {
        //     echo "Maintenance for next month is not due yet.\n";
        //     // Alert: Maintenance not due
        // }




        // $lastMaintenanceDate = Carbon::parse('2025-06-03');
        // $currentDate = Carbon::now();

        // $quarters = [
        //     1 => '01-01',
        //     2 => '04-01',
        //     3 => '07-01',
        //     4 => '10-01'
        // ];

        // $currentQuarter = ceil($currentDate->month / 3);
        // $nextQuarter = $currentQuarter % 4 + 1;
        // $nextQuarterStart = Carbon::createFromFormat('Y-m-d', $currentDate->year . '-' . $quarters[$nextQuarter]);

        // if ($lastMaintenanceDate->lt($nextQuarterStart)) {
        //     echo "Maintenance is due for Q{$nextQuarter}. Proceeding to Q{$nextQuarter}.\n";
        //     // Proceed to Q{$nextQuarter}
        // } else {
        //     echo "Maintenance for Q{$nextQuarter} is not due yet.\n";
        //     // Alert: Maintenance not due
        // }



        // $nextMaintenanceDate = $lastMaintenanceDate->copy()->addMonths(6);

        // if ($currentDate->lt($nextMaintenanceDate)) {
        //     echo "Maintenance is due in 6 months. Proceeding to next maintenance.\n";
        //     // Proceed to next maintenance
        // } else {
        //     echo "Maintenance in 6 months is not due yet.\n";
        //     // Alert: Maintenance not due
        // }








    }

    public function pms_page()
    {
        return view('pms_page.pms_sample');
    }

    public function save_pms_request(Request $request)
    {

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'pms_name' => [
                        'required',
                    ],
                    'pms_description' => ['required'],
                    'pms_date_types' => ['required'],
                    'date_start' => ['required'],
                ],
            );

            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $request->merge([
                'user_id' => Auth::user()->id,
                'date_created' => Carbon::now(),
            ]);


            Pms_Details::create($request->all());
            return response()->json([
                'msg' => 'Successfully Inserted PMS',
                'status' => 200,
                "isValid" => true,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }


    public function get_pms_data()
    {

        $data = Pms_Details::where('status', 1)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '
                    <center>
                 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center> ';
            })
            ->addColumn('date_start', function ($data) {
                return Carbon::parse($data->date_start)->format('M j, Y');

            })
            ->rawColumns(['action', 'status', 'admin_action'])
            ->make(true);

    }

    public function get_pms_details($id)
    {



        try {

            $data = Pms_Details::find($id);
            $data->date_start = Carbon::parse($data->date_start)->format('Y-m-d');
            return response()->json([
                'msg' => 'Successfully Provided',
                'data' => $data,
                'status' => 200,
                "isValid" => true,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }
}
