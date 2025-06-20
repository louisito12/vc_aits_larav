<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PmsFiles;
use App\Models\Pms_Details;
use Illuminate\Http\Request;
use App\Models\AitsRequestCloser;
use Illuminate\Support\Facades\Auth;

class PmsvalidationController extends Controller
{






    public function pms_alert()
    {

        try {

            $data = PmsFiles::with('get_pms_details')->where('status', 1)->get();
            $data_arr = [];

            foreach ($data as $datas) {
                $date1 = $datas->pms_date;
                // $date2 = Carbon::now()->format('Y-m-d H:i:s.u');
                $date2 = Carbon::now()->format('Y-m-d H:i:s.u');
                $result = compare_dates($date1, $date2);
                if ($result == -1) {
                    if (!in_array($datas->id, $data_arr)) {
                        $data_arr[] = $datas->id;
                    }
                }
            }

            if (count($data_arr) == 0) {
                return response()->json([
                    'msg' => 'No PMS',
                    'status' => 200,
                    "isValid" => true,
                    "data" => $data,
                    "count" => 0,
                ]);
            }

            $data_pms = PmsFiles::with('get_pms_details')->whereIn('id', $data_arr)->get();
            return response()->json([
                'msg' => 'Successfully provided',
                'status' => 200,
                "isValid" => true,
                "data" => $data_pms,
                "count" => count($data_arr),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }


    public function save_cancellation_request($date)
    {

        AitsRequestCloser::where('status', 1)->update([
            'status' => 0
        ]);

        $date_time = Carbon::parse($date)->format('Y-m-d H:i:s.v');


        AitsRequestCloser::create([
            'date_start' => Carbon::now(),
            'date_end' => $date_time,
            'date_created' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'table_name' => 'aits_shuttle_requests'
        ]);
    }

    public function get_close_schedule()
    {
        $data = AitsRequestCloser::where('status', 1)->first();


        $data->close_date = date_coverters_transit($data->date_end);

        return $data;
    }
    public function save_open_req()
    {

        AitsRequestCloser::where('status', 1)->update([
            'status' => 0
        ]);

    }
}
