<?php

namespace App\Http\Controllers;

use App\Models\PmsScheduleType;
use DateTime;
use Validator;
use Carbon\Carbon;
use App\Mail\PmsMailer;
use App\Models\PmsFiles;
use App\Models\AitsNotif;
use App\Models\UserModel;
use App\Models\Pms_Details;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\AitsShuttleRequest;
use Illuminate\Support\Facades\DB;
use App\Models\AitsRequestRoomModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        // $start_date = '2025-02-01';
        // echo next_date_pms($start_date, 'monthly') . '===>';  
        // echo next_date_pms($start_date, 'yearly') . '====>';    
        // echo next_date_pms($start_date, 'quarterly') . '====>'; 
        // Mail::to('ictsysdev@valuecarehealth.com')->send(new PmsMailer([]));
        // $dateString = '2025-07-09 00:00:00.000';
        // $formattedDate = Carbon::createFromFormat('Y-m-d H:i:s.u', $dateString)->format('Y-m-d');
        // echo $formattedDate; // Outputs: 2025-07-09

        $schedule = PmsScheduleType::where('status', 1)->get();
        return view('pms_page.pms_management', compact('schedule'));


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
                    'is_email' => ['required'],
                    'conducted_by' => ['required'],
                    'noted_by' => ['required'],

                ],

            );

            // echo count($request->send_to);
            // return;

            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            if ($request->is_email == 1) {
                if ($request->send_to == "" || $request->cc_to == "") {
                    return response()->json([
                        'msg' => 'Send to and CC to is required',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }
            $request->merge([
                'user_id' => Auth::user()->id,
                'date_created' => Carbon::now(),
                'send_to' => implode(',', $request->send_to),
                'cc_to' => implode(',', $request->cc_to)
            ]);

            $pms = Pms_Details::create($request->all());
            $pms_id = $pms->id;
            $start_date = next_date_pms($request->date_start, $request->pms_date_types);
            $this->insert_pms_alert($pms_id, $request->date_start);

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
        $data = Pms_Details::with(['get_noted_by'])->where('status', 1)->get();
        return $this->pms_datatable($data);

    }



    public function pms_datatable($data)
    {
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $pms_button = '';
                $pms_file = PmsFiles::where('pms_id', $data->id)->where('status', 1)->first();
                if ($data->pms_status == 'Approved') {
                    if ($pms_file) {
                        $date1 = $pms_file->pms_date;
                        $date2 = Carbon::now()->format('Y-m-d H:i:s.u');
                        $result = compare_dates($date1, $date2);
                        if ($result == -1) {
                            $pms_button = ' <button type="button" data-id=' . $data->id . ' class="btn btn-success btn-sm btn_pms spec_input"> <i  class="fa-solid fa-screwdriver-wrench"></i></button>';
                        }
                    }
                }
                return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>'
                    . $pms_button .
                    ' </center> ';
            })
            ->addColumn('date_start', function ($data) {
                return Carbon::parse($data->date_start)->format('M j, Y');

            })

            ->addColumn('approval_action', function ($data) {
                $hidden = $data->pms_status != 'Pending' ? 'hidden' : '';

                return '
                        <div  class="btn-group dropstart input_spec my-1">
                            <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="1" data-id="' . $data->id . '" href="javascript:void(0);">Approve</a></li>
                                <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="2" data-id="' . $data->id . '" href="javascript:void(0);">Disapprove</a></li>
                                
                            </ul>
                        </div>';

            })
            ->addColumn('pms_status', function ($data) {
                $stat = '';
                $pms_file = PmsFiles::where('pms_id', $data->id)->where('status', 1)->first();
                if ($pms_file) {
                    $date1 = $pms_file->pms_date;
                    $date2 = Carbon::now()->format('Y-m-d H:i:s.u');
                    $result = compare_dates($date1, $date2);
                    if ($data->pms_status == 'Approved') {
                        if ($result == -1) {
                            $stat = '<h6><span class="badge rounded-pill bg-danger">Need For PMS !</span></h6>';
                        }

                    }

                }
                return $stat;

            })
            ->addColumn('noted_by', function ($data) {
                return $data['get_noted_by']['firstname'] . ' ' . $data['get_noted_by']['lastname'];
            })
            ->addColumn('pms_status_badge', function ($data) {
                return $this->pms_status($data->pms_status);
            })
            ->rawColumns(['action', 'status', 'admin_action', 'pms_status', 'pms_status_badge', 'approval_action'])
            ->make(true);



    }


    public function pms_status($status)
    {

        if ($status == "Pending") {
            $stat = '<span class="badge rounded-pill bg-warning">Pending</span>';
        } else if ($status == "Approved") {
            $stat = '<span class="badge rounded-pill bg-success">Approved</span>';

        } else if ($status == "Disapproved") {
            $stat = '<span class="badge rounded-pill bg-danger">Disapproved</span>  ';

        } else {
            $stat = '<span class="badge rounded-pill bg-danger">Error</span> ';
        }

        return '<h5>' . $stat . '</h5>';



    }
    public function get_pms_sched_table($year)
    {

        $data = Pms_Details::where('status', 1)
            ->whereYear('date_start', '<=', $year)
            ->get();
        $rows = [];

        // foreach ($data as $pms) {
        //     $row = [];
        //     $row[] = htmlspecialchars($pms->pms_name);
        //     $row[] = ucfirst($pms->pms_date_types);
        //     $start = Carbon::parse($pms->date_start);
        //     $schedule = strtolower($pms->pms_date_types);
        //     for ($m = 1; $m <= 12; $m++) {
        //         $highlight = false;
        //         if ($schedule == 'monthly') {
        //             if ($start->year < $year || ($start->year == $year && $start->month <= $m)) {
        //                 $highlight = true;
        //             }
        //         } elseif ($schedule == 'quarterly') {
        //             $quarterMonths = [];
        //             $firstMonth = $start->month;
        //             for ($i = 0; $i < 4; $i++) {
        //                 $month = (($firstMonth - 1) + ($i * 3)) % 12 + 1;
        //                 $quarterYear = $start->year + intval(($firstMonth - 1 + $i * 3) / 12);
        //                 if ($quarterYear == $year) {
        //                     $quarterMonths[] = $month;
        //                 }
        //             }
        //             if (in_array($m, $quarterMonths)) {
        //                 $highlight = true;
        //             }
        //         } elseif ($schedule == 'annual') {
        //             if ($start->month == $m) {
        //                 $highlight = true;
        //             }
        //         }
        //         $row[] = $highlight
        //             ? '<td style="background:#6f6f6f !important;color:#6f6f6f "></td>'
        //             : '<td></td>';
        //     }

        //     $rows[] = $row;
        // }




        // foreach ($data as $pms) {
        //     $row = [];
        //     $row[] = htmlspecialchars($pms->pms_name);
        //     $row[] = ucfirst($pms->pms_date_types);
        //     $start = Carbon::parse($pms->date_start);
        //     $schedule = strtolower($pms->pms_date_types);

        //     for ($m = 1; $m <= 12; $m++) {
        //         $highlight = false;

        //         switch ($schedule) {
        //             case 'monthly':
        //                 if ($start->year < $year || ($start->year == $year && $start->month <= $m)) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'quarterly':
        //                 $quarterMonths = [];
        //                 $firstMonth = $start->month;
        //                 for ($i = 0; $i < 4; $i++) {
        //                     $month = (($firstMonth - 1) + ($i * 3)) % 12 + 1;
        //                     $quarterYear = $start->year + intval(($firstMonth - 1 + $i * 3) / 12);
        //                     if ($quarterYear == $year) {
        //                         $quarterMonths[] = $month;
        //                     }
        //                 }
        //                 if (in_array($m, $quarterMonths)) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'annual':
        //                 if ($start->month == $m) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'semi-annual':
        //                 if ($start->month == $m || $start->month == ($m - 6 + 12) % 12) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'tri-annual':
        //                 if (in_array($m, [$start->month, ($start->month + 4) % 12, ($start->month + 8) % 12])) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'bi-monthly':
        //                 if (
        //                     in_array($m, [
        //                         $start->month,
        //                         ($start->month + 2) % 12,
        //                         ($start->month + 4) % 12,
        //                         ($start->month + 6) % 12,
        //                         ($start->month + 8) % 12,
        //                         ($start->month + 10) % 12
        //                     ])
        //                 ) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'semi-monthly':
        //                 if ($m == $start->month) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'weekly':
        //                 $weeks = Carbon::parse($start)->week();
        //                 $currentWeek = Carbon::now()->week();
        //                 if ($weeks == $currentWeek) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             case 'daily':
        //                 if ($start->year == $year && $start->month == $m) {
        //                     $highlight = true;
        //                 }
        //                 break;

        //             default:
        //                 break;
        //         }


        //         $row[] = $highlight
        //             ? '<td style="background:#6f6f6f !important;color:#6f6f6f "></td>'
        //             : '<td></td>';
        //     }

        //     $rows[] = $row;
        // }

        foreach ($data as $pms) {
            $row = [];
            $row[] = htmlspecialchars($pms->pms_name);
            $row[] = ucfirst($pms->pms_date_types);
            $start = Carbon::parse($pms->date_start);
            $schedule = strtolower($pms->pms_date_types);

            for ($m = 1; $m <= 12; $m++) {
                $highlight = false;


                if ($schedule == 'monthly') {
                    if ($start->year < $year || ($start->year == $year && $start->month <= $m)) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'quarterly') {
                    $quarterMonths = [];
                    $firstMonth = $start->month;
                    for ($i = 0; $i < 4; $i++) {
                        $month = (($firstMonth - 1) + ($i * 3)) % 12 + 1;
                        $quarterYear = $start->year + intval(($firstMonth - 1 + $i * 3) / 12);
                        if ($quarterYear == $year) {
                            $quarterMonths[] = $month;
                        }
                    }
                    if (in_array($m, $quarterMonths)) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'annual') {
                    if ($start->month == $m) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'semi-annual') {
                    if ($start->month == $m || $start->month == ($m - 6 + 12) % 12) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'tri-annual') {
                    if (in_array($m, [$start->month, ($start->month + 4) % 12, ($start->month + 8) % 12])) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'bi-monthly') {
                    if (in_array($m, [$start->month, ($start->month + 2) % 12, ($start->month + 4) % 12, ($start->month + 6) % 12, ($start->month + 8) % 12, ($start->month + 10) % 12])) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'semi-monthly') {
                    if ($m == $start->month || $start->month <= $m) {

                        $highlight = true;
                    }
                }

                // Handle weekly schedule
                elseif ($schedule == 'weekly') {
                    // $weeks = Carbon::parse($start)->week();
                    // $currentWeek = Carbon::now()->week();
                    // if ($weeks == $currentWeek) {
                    //     $highlight = true;
                    // }
                    $weeks = Carbon::parse($start)->week();
                    $currentWeek = Carbon::now()->week();
                    if (($start->year == $year && $start->month <= $m) || $start->year < $year) {
                        $highlight = true;
                    }
                } elseif ($schedule == 'daily') {
                    // // if ($start->year == $year && $start->month == $m) {}
                    // $highlight = true;

                    if (($start->year == $year && $start->month <= $m) || $start->year < $year) {
                        $highlight = true;
                    }

                }


                $row[] = $highlight
                    ? '<td style="background:#6f6f6f !important;color:#6f6f6f "></td>'
                    : '<td></td>';
            }

            $rows[] = $row;
        }


        $tbody_html = '';
        foreach ($rows as $row) {
            $tbody_html .= '<tr>';
            $tbody_html .= '<td>' . $row[0] . '</td>'; // PMS Name
            $tbody_html .= '<td>' . $row[1] . '</td>'; // Schedule
            for ($i = 2; $i < count($row); $i++) {
                $tbody_html .= $row[$i];
            }
            $tbody_html .= '</tr>';
        }

        return response()->json([
            'tbody_html' => $tbody_html,
            'status' => 200,
            'msg' => 'Successfully Provided',
            'isValid' => true,
        ]);
    }



    public function get_pms_details($id)
    {
        try {
            $data = Pms_Details::with(['get_noted_by'])->find($id);
            $data->date_start = Carbon::parse($data->date_start)->format('Y-m-d');
            $data->send_to = explode(',', $data->send_to);
            $data->cc_to = explode(',', $data->cc_to);


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



    public function get_noted_by(Request $request)
    {
        $data = UserProfile::on('main_user')
            ->select('tbl_personal_datas.user_id', 'tbl_personal_datas.firstname', 'tbl_personal_datas.lastname')
            ->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'LIKE', '%' . $request->searchTerm . '%')
            ->leftJoin(DB::raw('users'), 'tbl_personal_datas.user_id', '=', 'users.id')
            ->where('users.isactive', 1)
            ->limit(400)
            ->OrderBy('firstname', 'asc')
            ->get();
        $data_new = [];
        foreach ($data as $dt) {
            $data_new[] = array("id" => $dt->user_id, "text" => $dt->firstname . ' ' . $dt->lastname);
        }
        return $data_new;
    }



    public function pms_edit_details(Request $request)
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
                    'conducted_by' => ['required'],
                    'noted_by' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            if ($request->is_email == 1) {
                if ($request->send_to == "" || $request->cc_to == "") {
                    return response()->json([
                        'msg' => 'Send to and CC to is required',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }


            $request->merge([
                'send_to' => implode(',', $request->send_to),
                'cc_to' => implode(',', $request->cc_to)
            ]);


            Pms_Details::where('id', $request->id)->update($request->except(['id']));
            $start_date = next_date_pms($request->date_start, $request->pms_date_types);
            $this->insert_pms_alert($request->id, $request->date_start);

            return response()->json([
                'msg' => 'Successfully Updated PMS',
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

    public function delete_pms_request($id)
    {
        try {

            Pms_Details::where('id', $id)->update([
                'status' => 0,
            ]);

            PmsFiles::where('pms_id', $id)->update(['status' => 0]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }






    public function insert_pms_alert($pms_id, $start_date)
    {
        try {

            $update_pms = PmsFiles::where('pms_id', $pms_id)->update(['status' => 2]);

            PmsFiles::create([
                'pms_id' => $pms_id,
                'pms_date' => $start_date,
                'status' => 1,
                'date_created' => Carbon::now(),
            ]);




        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }




    }




    public function add_pms_remarks(Request $request)
    {
        try {

            foreach ($request->file('file') as $item) {
                $ext = $item->getClientOriginalExtension();
                $fname = $item->getClientOriginalName();
                $year = Carbon::now()->year;
                $format_name = now()->format('YmdHis') . '_' . mt_rand('1111', '9999');
                PmsFiles::where('pms_id', $request->pms_id)->whereNull('uploader_id')->where('status', 1)->update([
                    "remarks" => $request->remarks,
                    "orig" => $fname,
                    "file_name" => $format_name . '.' . $ext,
                    "folder" => "pms_files",
                    "year" => Carbon::now()->year,
                    "link" => url('/'),
                    "status" => 3,
                    "date_uploaded" => Carbon::now(),
                    'uploader_id' => Auth::user()->id,
                ]);
                $item->move('pms_files/' . $year . '/', $format_name . '.' . $ext);
            }

            $pms_file = PmsFiles::whereNotNull('uploader_id')->where('status', 3)->orderByDesc('id')->first();
            $pms_details = Pms_Details::find($pms_file->pms_id);
            $dateString = $pms_file->pms_date;
            $date_start = Carbon::createFromFormat('Y-m-d H:i:s.u', $dateString)->format('Y-m-d');
            $start_date = next_date_pms($date_start, $pms_details->pms_date_types);
            $this->insert_pms_alert($pms_file->pms_id, $start_date);



        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }





    // public function pms_uploade_remarks($pms_id, $files, $remarks, $next_date)
    // {
    //     foreach ($files as $item) {
    //         $ext = $item->getClientOriginalExtension();
    //         $fname = $item->getClientOriginalName();
    //         $year = Carbon::now()->year;
    //         $format_name = now()->format('YmdHis') . '_' . mt_rand('1111', '9999');
    //         PmsFiles::where('pms_id', $pms_id)->update([
    //             "remarks" => $remarks,
    //             "orig" => $fname,
    //             "file_name" => $format_name . '.' . $ext,
    //             "folder" => "pms_files",
    //             "year" => Carbon::now()->year,
    //             "link" => url('/'),
    //             "status" => 3,
    //             "pms_date" => $next_date,
    //             "date_uploaded" => Carbon::now(),
    //             'uploader_id' => Auth::user()->id,
    //         ]);

    //         $item->move('pms_files/' . $year . '/', $format_name . '.' . $ext);
    //     }
    // }



    //     public function test_dates()
    // {
    //     $date1 = Pms_Details::first()->date_start;
    //     $date2 = Carbon::now()->format('Y-m-d H:i:s.u');
    //     $result = compare_dates($date1, $date2);

    //     if ($result === 1) {
    //         // date_1 mas advance ng oras to
    //         echo "$date1 is later.";
    //     } elseif ($result === -1) {
    //         //mas lamang yung ngayon
    //         echo "$date2 is later.";
    //     }
    // }

}
