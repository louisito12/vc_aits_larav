<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\AitsNotif;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\AitsShuttleType;
use App\Models\DepartmentModel;
use App\Models\AitsVehicleModel;
use Yajra\DataTables\DataTables;
use App\Models\AitsRequestCloser;
use GuzzleHttp\Psr7\UploadedFile;
use App\Models\AitsShuttleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class Aits_Transit_Controller extends Controller
{


    public function transit_request_view()
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





        return view('aits_pages.aits_transit_request_view', compact('vehicle', 'type', 'manager'));
    }

    public function aits_save_shuttle_request(Request $request)
    {
        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'departure_date' => ['required'],
                    'appointment_date' => ['required'],
                    'pick_up_date' => ['required'],
                    'client_name' => ['required'],
                    'type' => ['required'],
                    // 'manager_id' => ['required'],
                    'manager_text' => ['required'],
                    'passenger_number' => ['required'],
                    'destination' => ['required'],
                    'remarks' => ['required'],
                    'ecv' => ['required'],
                ],
            );


            $array_monday = [1];// 6;
            $array_wed_th = [2, 3, 4];//5;
            $friday_arr = [5];   //4;
            $date = Carbon::parse($request->pick_up_date);
            $dayNumber = $date->dayOfWeekIso;

            if (in_array($dayNumber, $array_monday)) {
                $limit_req = 6;
            }

            if (in_array($dayNumber, $array_wed_th)) {
                $limit_req = 4;
            }

            if (in_array($dayNumber, $friday_arr)) {
                $limit_req = 3;
            }

            $pick_up_date_format = Carbon::parse($request->pick_up_date)->format('Y-m-d');
            $req_validation_count = AitsShuttleRequest::where('is_transact', 1)
                ->whereDate('pick_up_date', $pick_up_date_format)
                ->whereNot('request_status', 'Cancelled')->count();

            if ($limit_req <= $req_validation_count) {
                return response()->json([
                    'msg' => 'Systems is alrready fully request on that day',
                    'status' => 402,
                    "isValid" => false,
                ]);
    
            } 




            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            if ($request->type == "remarks") {
                if ($request->purpose == "") {
                    return response()->json([
                        'msg' => 'Other Purpose is required!',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }


            $appointment_date = $formatted = Carbon::parse($request->appointment_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $departure = $formatted = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $date_pick_up = $formatted = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $validation_date = $this->date_validations($date_pick_up, $departure, $appointment_date);
            if ($validation_date['stat'] == 1) {
                return response()->json([
                    'msg' => $validation_date['msg'],
                    'status' => 402,
                    "isValid" => false,
                ]);
            }



            // $from_date = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d h:i A');
            // $to_date = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d h:i A');


            // $validation = $this->date_validation($from_date, $to_date);
            // if ($validation != 0) {
            //     return response()->json([
            //         'msg' => 'The service shuttle for that time is no longer available !',
            //         'status' => 402,
            //         "isValid" => false,
            //     ]);
            // }

            $closer_request = AitsRequestCloser::
                where('date_end', '>', Carbon::now())
                ->where('status', 1)
                // ->where('date_from', '<', Carbon::now())
                ->first();

            if ($closer_request) {
                $now = Carbon::now();
                $date_from = $formatted = Carbon::parse($closer_request->date_from, 'Asia/Manila')->format('Y-m-d H:i:s.u');
                $date_end = $formatted = Carbon::parse($closer_request->date_end, 'Asia/Manila')->format('Y-m-d H:i:s.u');
                if ($now > $date_from) {
                    return response()->json([
                        'msg' => 'The current system is close for request for vehicle service',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                } else {
                    // if ($now > $date_end) {
                    //     // AitsRequestCloser::where('status', 1)->update(['status' => 0]);
                    // }
                }

            }

            $dept_id = get_person_fname(Auth::user()->id);

            $request->merge([
                'status' => 1,
                'is_transact' => 1,
                'user_id' => Auth::user()->id,
                'date_created' => Carbon::now(),
                'departure_date' => Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s'),
                'appointment_date' => Carbon::parse($request->appointment_date, 'Asia/Manila')->format('Y-m-d H:i:s'),
                'pick_up_date' => Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s'),
                'request_status' => 'Pending',
                'request_no' => $this->request_no(),
                'dept_id' => $dept_id['deparment_id'],

            ]);


            if ($request->type == "remarks") {
                $insert = $request->except(['type']);
            }

            $data = AitsShuttleRequest::create($request->except(['file']));
            $this->uploade_file_transit($data->id, "AitsShuttleRequest", 'aits_shuttle_file', $request->file('file'));


            AitsNotif::create([
                'aits_table' => "aits_shuttle_requests",
                'aits_id' => $data->id,
                'aits_process' => 'Request',
                'send_to_user_id' => 'admin',
                'date_created' => Carbon::now(),
            ]);

            $latestRecord = AitsShuttleRequest::orderByDesc('id')->first();
            $latest_id = $latestRecord ? $latestRecord->id : null;


            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Request Shuttle Module',
                'description' => 'Request Shuttle Service',
                'table_name' => 'aits_shuttle_requests',
                'transact_id' => $latest_id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];
            insert_audit($object);




            return [
                'msg' => 'Succesfully Inserted',
                'data' => $data,
                'status' => 200,
                "isValid" => true,
            ];

            // http://127.0.0.1:8000/aits_shuttle_file/2025/20250519140305_4315.pdf0
            // $this->uploade_file_transit(1, 'louie', $request->file('file'));

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function tester_date()
    {


        // $from_date = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');

    }


    public function date_validations($pick_date, $departure_date, $appointment_date)
    {
        $val = 0;
        $message = '';
        //vehicle condtions departure,pick upd, abd appointend date

        if ($pick_date == $departure_date) {
            $val = 1;
            $message = 'Pick up date and Departure date must not be equal';
        }

        if ($pick_date == $appointment_date) {
            $val = 1;
            $message = 'Pick up date and Appointment Date must not be equal';
        }

        if ($departure_date == $appointment_date) {
            $val = 1;
            $message = 'Departure Date Must Not be equal to Appointment Date';
        }
        if ($departure_date > $appointment_date) {
            $val = 1;
            $message = 'The departure date is not be later than appointment date';
        }

        if ($departure_date > $pick_date) {
            $val = 1;
            $message = 'The departure date is not be later than pick up date';
        }


        if ($appointment_date > $pick_date) {
            $val = 1;
            $message = 'The appointment date is not be later than pick up date';
        }



        return ['stat' => $val, 'msg' => $message];


    }



    public function uploade_file_transit($id, $table_name, $folder_name, $files): void
    {
        foreach ($files as $item) {
            $ext = $item->getClientOriginalExtension();
            $fname = $item->getClientOriginalName();
            $year = Carbon::now()->year;
            $format_name = now()->format('YmdHis') . '_' . mt_rand('1111', '9999');
            AitsFileModel::create([
                "table_name" => $table_name,
                "attachment_id" => $id,
                "orig_file" => $fname,
                "file_name" => $format_name . '.' . $ext,
                "folder_name" => $folder_name,
                "year" => Carbon::now()->year,
                "status" => 1,
                "file_link" => url('/'),
                "date_created" => Carbon::now()
            ]);

            if ($folder_name == 'driver_file') {
                $item->move('driver_file/' . $year . '/', $format_name . '.' . $ext);

            } else {
                $item->move('aits_shuttle_file/' . $year . '/', $format_name . '.' . $ext);
            }
        }


    }



    public function get_shuttel_request_data()
    {

        $data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data', 'get_car_data', 'get_driver_data'])
            ->where('user_id', Auth::user()->id)->get();

        return $this->transit_data_table($data);


    }

    public function transit_data_table($data)
    {
        return DataTables::of($data)
            ->addColumn('action', function ($data) {

                if ($data->status == 0 || $data->request_status != 'Pending') {
                    return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-dark btn-sm btn_show_data  spec_input"><i class="bi bi-eye-fill"></i></button> 
                       </center> ';
                }

                return '
                    <center>
                    <button title="View" type="button" data-id=' . $data->id . ' class="btn btn-dark btn-sm btn_show_data  spec_input"><i class="bi bi-eye-fill"></i></button> 
                    <button title="Edit" type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button title="Cancel" type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center>
               
                    ';
            })
            ->addColumn('departure_date', function ($data) {

                return date_converter($data->departure_date);
            })
            ->addColumn('driver_action', function ($data) {
                // $upload_validation = 
    
                //       $data_file = AitsFileModel::where('table_name', 'AitsShuttleRequest')
                //     ->where('status', 1)
                //     ->where('attachment_id', $data->id)
                //     ->first();
                // $link = $data_file->file_link;
                // $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                // $url = dynamic_file($path, $link);
                // return '
    
                //    <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>
    
                //         ';
    
                $action = '<li><a class="dropdown-item btn_upload"  data-id="' . $data->id . '" href="javascript:void(0);">Upload</a></li>';
                if ($data->driver_remarks) {
                    $action = '';
                }
                return '
                    <div  class="btn-group dropstart input_spec my-1">
                        <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                           ' . $action . '
                            <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                        </ul>
                    </div>
                ';

            })
            ->addColumn('request_no', function ($data) {
                $number = $data->request_no;
                $request_number = sprintf('%03d', $number);
                return Carbon::parse($data->date_created)->format('Y-m-d') . '-' . $request_number;

            })
            ->addColumn('appointment_date', function ($data) {

                return date_converter($data->appointment_date);
            })

            ->addColumn('pick_up_date', function ($data) {

                return date_converter($data->pick_up_date);
            })
            ->addColumn('date_created', function ($data) {

                return date_converter($data->date_created);
            })

            ->addColumn('type', function ($data) {

                return $data['get_event_data'] ? $data['get_event_data']['type'] : $data->purpose;
            })

            ->addColumn('status_html', function ($data) {
                if ($data->status == 0) {
                    return '<h5> <span class="badge rounded-pill bg-danger">Cancelled</span></h5>';
                }

                return $this->status_html($data->request_status);
            })
            ->addColumn('purpose', function ($data) {

                $purpose_event = "";
                if ($data->type == "remarks") {
                    $purpose_event = $data->purpose;
                } else {
                    $purpose_event = AitsShuttleType::find($data->type)->type;
                }


                return $purpose_event;
            })
            ->addColumn('reuqeusted_by', function ($data) {
                return $data['get_requestor_data']['firstname'] . ' ' . $data['get_requestor_data']['lastname'];
            })

            ->addColumn('reuqeusted_by', function ($data) {
                return $data['get_requestor_data']['firstname'] . ' ' . $data['get_requestor_data']['lastname'];
            })

            ->addColumn('action_file', function ($data) {

                $data_file = AitsFileModel::where('table_name', 'AitsShuttleRequest')
                    ->where('status', 1)
                    ->where('attachment_id', $data->id)
                    ->first();
                $link = $data_file->file_link;
                $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                $url = dynamic_file($path, $link);
                return '
                
                   <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>
                
                        ';
            })
            ->addColumn('driver', function ($data) {
                $driver = '';
                if ($data['get_driver_data']) {
                    $driver = $data['get_driver_data']['fname'] . ' ' . $data['get_driver_data']['lname'];

                }

                return $driver;
                // get_car_data
                // get_driver_data
            })
            ->addColumn('vehicle', function ($data) {
                $vehicle = '';
                if ($data['get_car_data']) {
                    $vehicle = $data['get_car_data']['plate_number'];
                }
                return $vehicle;
            })
            ->addColumn('admin_action', function ($data) {
                $hidden = ($data->request_status != 'Pending' || $data->status == 0) ? 'hidden' : '';
                $cancell_hidden = ($data->request_status == 'Cancelled') ? 'hidden' : '';
                return '
                    <div  class="btn-group dropstart input_spec my-1">
                        <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="1" data-id="' . $data->id . '" href="javascript:void(0);">Approve</a></li>
                            <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="2" data-id="' . $data->id . '" href="javascript:void(0);">Disapprove</a></li>
                            <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="3" data-id="' . $data->id . '" href="javascript:void(0);">Special Approval</a></li>
                             <li><a class="dropdown-item btn_delete" ' . $cancell_hidden . '  data-id="' . $data->id . '" href="javascript:void(0);">Cancel Request</a></li>
                            <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                        </ul>
                    </div>
                ';
            })
            ->addColumn('department', function ($data) {
                return DepartmentModel::find($data->dept_id)->description;

            })
            ->rawColumns(['action', 'status_html', 'action_file', 'admin_action', 'driver_action'])
            ->make(true);
    }


    public function status_html($status)
    {
        if ($status == "Pending") {
            $stat = '<span class="badge rounded-pill bg-warning">Pending</span>';
        } else if ($status == "Approved") {
            $stat = '<span class="badge rounded-pill bg-success">Approved</span>';

        } else if ($status == "Disapproved") {
            $stat = '<span class="badge rounded-pill bg-danger">Disapproved</span>  ';

        } else if ($status == "Cancelled") {
            $stat = '<span class="badge rounded-pill bg-danger">Cancelled</span> ';
        } else {
            $stat = '<span class="badge rounded-pill bg-danger">Error</span> ';
        }


        return '<center><h5>' . $stat . '</h5></center>';
    }

    public function retrieve_shuttle_request($id)
    {

        try {

            $driver_file = '';
            $data = AitsShuttleRequest::
                with(['get_event_data', 'get_requestor', 'get_requestor_data', 'get_approver_data', 'get_car_data', 'get_driver_data', 'get_app_remarks'])
                ->find($id);


            $notif = AitsNotif::where('aits_id', $id)
                ->where('aits_table', 'aits_shuttle_requests')
                ->where('aits_process', 'Approve')
                ->where('is_driver', 1)
                ->first();

            $data_file = AitsFileModel::where('table_name', 'driver_file')
                ->where('status', 1)
                ->where('attachment_id', $id)
                ->first();
            if ($data_file) {
                $link = $data_file->file_link;
                $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                $url = dynamic_file($path, $link);
                $driver_file = '<a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>';
            }

            $driver_remarks = $notif ? $notif->remarks : '';

            $number = $data->request_no;
            $request_number = sprintf('%03d', $number);
            $req_no = Carbon::parse($data->date_created)->format('Y-m-d') . '-' . $request_number;
            $data->departure_date = date_coverters_transit($data->departure_date);
            $data->appointment_date = date_coverters_transit($data->appointment_date);
            $data->pick_up_date = date_coverters_transit($data->pick_up_date);
            $data->date_approved = date_converter($data->date_approved);
            $data->request_number = $req_no;
            $data->driver_app_remarks = $driver_remarks;
            $data->driver_file = $driver_file;

            if ($data->type == null) {
                $data->type == "remarks";
            }

            return [
                'msg' => 'Succesfully Provided',
                'data' => $data,
                'status' => 200,
                "isValid" => true,
            ];


        } catch (\Exception $e) {
            return response()->json([
                'msg' => $e,
                'status' => 402,
                'isValid' => false,
            ]);
        }
    }



    public function date_validation($date_from, $date_to)
    {

        $fromDate = Carbon::parse($date_from)->format('Y-m-d H:i:s');
        $toDate = Carbon::parse($date_to)->format('Y-m-d H:i:s');
        $query = "
        SELECT COUNT(*) AS overlapping_count
        FROM aits_shuttle_requests    WHERE
        ((pick_up_date BETWEEN  '$fromDate' AND '$toDate')
        OR (departure_date BETWEEN  '$fromDate' AND '$toDate')
        OR ('$fromDate' BETWEEN pick_up_date AND departure_date)
        OR ('$toDate' BETWEEN pick_up_date AND departure_date) )
        AND request_status='Approved';";

        $data = DB::connection('sqlsrv')->select($query, []);


        $count = 0;

        if ($data) {
            $count = $data[0]->overlapping_count;
        }


        return $count;



    }

    public function delete_shuttle_request($id, $remarks)
    {
        try {

            $data = AitsShuttleRequest::where('id', $id)->first();
            $is_approve = 0;

            if ($data->request_status == 'Approved') {
                $is_approve = 1;
            }


            AitsShuttleRequest::where('id', $id)->update(['request_status' => 'Cancelled', 'is_app_cancelled' => $is_approve]);




            $object = [
                'attachment_id' => $id,
                'remarks' => $remarks,
                'procedures' => 'Cancell Shuttle Request',
                'table_name' => 'aits_shuttle_requests',
                'users_id' => Auth::user()->id,
                'status' => 1,
                'ate_created' => Carbon::now(),

            ];
            process_remarks($object);




            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Request Shuttle Module',
                'description' => 'Delete Shuttle Request',
                'table_name' => 'aits_shuttle_requests',
                'transact_id' => $id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];
            insert_audit($object);


            AitsNotif::create([
                'aits_table' => "aits_shuttle_requests",
                'aits_id' => $id,
                'aits_process' => 'Cancell_request',
                'cancelled_by' => Auth::user()->id,
                'date_created' => Carbon::now(),
                'remarks' => $remarks,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => $e,
                'isValid' => false,
                'status' => 402,
            ]);
        }

    }

    public function update_shuttle_request(Request $request)
    {

        try {
            // AitsShuttleRequest::get();
            $validated = Validator::make(
                $request->all(),
                [
                    'departure_date' => [
                        'required',
                    ],
                    'appointment_date' => ['required'],
                    'pick_up_date' => ['required'],
                    'client_name' => ['required'],
                    'type' => ['required'],
                    'manager_text' => ['required'],
                    // 'manager_id' => ['required'],
                    'passenger_number' => ['required'],
                    'destination' => ['required'],
                    'remarks' => ['required'],
                    'ecv' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }



            if ($request->type == "remarks") {
                if ($request->purpose == "") {
                    return response()->json([
                        'msg' => 'Other Purpose is required!',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }




            $appointment_date = $formatted = Carbon::parse($request->appointment_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $departure = $formatted = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $date_pick_up = $formatted = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $validation_date = $this->date_validations($date_pick_up, $departure, $appointment_date);
            if ($validation_date['stat'] == 1) {
                return response()->json([
                    'msg' => $validation_date['msg'],
                    'status' => 402,
                    "isValid" => false,
                ]);
            }





            $closer_request = AitsRequestCloser::
                where('date_end', '>', Carbon::now())
                ->where('status', 1)
                ->first();

            $closer_request = AitsRequestCloser::
                where('date_end', '>', Carbon::now())
                ->where('status', 1)
                // ->where('date_from', '<', Carbon::now())
                ->first();

            if ($closer_request) {
                $now = Carbon::now();
                $date_from = $formatted = Carbon::parse($closer_request->date_from, 'Asia/Manila')->format('Y-m-d H:i:s.u');
                $date_end = $formatted = Carbon::parse($closer_request->date_end, 'Asia/Manila')->format('Y-m-d H:i:s.u');
                if ($now > $date_from) {
                    return response()->json([
                        'msg' => 'The current system is close for request for vehicle service',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                } else {
                    // if ($now > $date_end) {
                    //     AitsRequestCloser::where('status', 1)->update(['status' => 0]);
                    // }
                }

            }


            $request->merge([
                'departure_date' => Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s'),
                'appointment_date' => Carbon::parse($request->appointment_date, 'Asia/Manila')->format('Y-m-d H:i:s'),
                'pick_up_date' => Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s'),

            ]);
            $data_logs = AitsShuttleRequest::where('id', $request->id)->first();

            AitsShuttleRequest::create(
                [
                    'is_transact' => 0,
                    'departure_date' => $data_logs->departure_date,
                    'appointment_date' => $data_logs->appointment_date,
                    'pick_up_date' => $data_logs->pick_up_date,
                    'client_name' => $data_logs->client_name,
                    'manager_id' => $data_logs->manager_id,
                    'passenger_number' => $data_logs->passenger_number,
                    'status' => 0,
                    'date_created' => Carbon::now(),
                    'purpose' => $data_logs->purpose,
                    'destination' => $data_logs->destination,
                    'remarks' => $data_logs->remarks,
                    'orig_id' => $data_logs->id,
                    'edited_by' => Auth::user()->id,
                    'ecv' => $request->ecv,
                ]
            );


            $data = AitsShuttleRequest::where('id', $request->id)->update($request->except(['id', 'ob_form']));

            if ($request->file('ob_form')) {
                AitsFileModel::where('table_name', 'AitsShuttleRequest')->where('attachment_id', $request->id)->update(['status' => 0]);
                $this->uploade_file_transit($request->id, "AitsShuttleRequest", 'aits_shuttle_file', $request->file('ob_form'));
            }

            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'Request Shuttle Module',
                'description' => 'Edit Request Shuttle',
                'table_name' => 'aits_shuttle_requests',
                'transact_id' => $request->id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];

            insert_audit($object);


            return [
                'msg' => 'Succesfully Inserted',
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


    public function request_no()
    {
        $request_no = 1;

        $recent_request = AitsShuttleRequest::where('is_transact', 1)
            ->whereDate('date_created', Carbon::today()->toDateString())
            ->orderBy('request_no', 'desc')
            ->first();


        if ($recent_request) {
            $request_no = (int) $recent_request->request_no + 1;
        }

        return $request_no;

    }





}




// $dateFrom = $formatted = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s');
// $dateTo = $formatted = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s');
// if ($dateFrom > $dateTo) {
//     return response()->json([
//         'msg' => 'The pick up date must not be later than Departure date!',
//         'status' => 402,
//         "isValid" => false,
//     ]);
// }

// $from_date = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d h:i A');
// $to_date = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d h:i A');

// $validation = $this->date_validation($from_date, $to_date);
// if ($validation != 0) {
//     return response()->json([
//         'msg' => 'The service shuttle for that time is no longer available !',
//         'status' => 402,
//         "isValid" => false,
//     ]);
// }

