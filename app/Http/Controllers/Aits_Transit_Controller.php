<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\AitsShuttleType;
use App\Models\AitsVehicleModel;
use Yajra\DataTables\DataTables;
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

        return view('aits_pages.aits_transit_request_view', compact('vehicle', 'type'));
    }

    public function aits_save_shuttle_request(Request $request)
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
                    'manager_id' => ['required'],
                    'passenger_number' => ['required'],
                    'destination' => ['required'],
                    'remarks' => ['required'],



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


            $dateFrom = $formatted = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $dateTo = $formatted = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            if ($dateFrom > $dateTo) {
                return response()->json([
                    'msg' => 'The pick up date must not be later than Departure date!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $from_date = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d h:i A');
            $to_date = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d h:i A');

            // $validation = $this->date_validation($from_date, $to_date);
            // if ($validation != 0) {
            //     return response()->json([
            //         'msg' => 'The service shuttle for that time is no longer available !',
            //         'status' => 402,
            //         "isValid" => false,
            //     ]);
            // }



            $request->merge([
                'status' => 1,
                'is_transact' => 1,
                'user_id' => Auth::user()->id,
                'date_created' => Carbon::now(),
                'departure_date' => Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d h:i A'),
                'appointment_date' => Carbon::parse($request->appointment_date, 'Asia/Manila')->format('Y-m-d h:i A'),
                'pick_up_date' => Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d h:i A'),
                'request_status' => 'Pending',
                'request_no' => $this->request_no(),
            ]);




            if ($request->type == "remarks") {
                $insert = $request->except(['type']);
            }



            $data = AitsShuttleRequest::create($request->except(['file']));
            $this->uploade_file_transit($data->id, "AitsShuttleRequest", 'aits_shuttle_file', $request->file('file'));


            return [

                'msg' => 'Succesfully Inserted',
                'data' => $data,
                'status' => 200,
                "isValid" => true,
            ];

            // http://127.0.0.1:8000/aits_shuttle_file/2025/20250519140305_4315.pdf



            // $this->uploade_file_transit(1, 'louie', $request->file('file'));

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }




    public function uploade_file_transit($id, $table_name, $folder_name, $files)
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
                "date_created" => Carbon::now()
            ]);


            $item->move('aits_shuttle_file/' . $year . '/', $format_name . '.' . $ext);
        }

    }



    public function get_shuttel_request_data()
    {

        $data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data'])
            ->where('status', 1)
            ->where('user_id', Auth::user()->id)->get();



        return $this->transit_data_table($data);



    }

    public function transit_data_table($data)
    {
        return DataTables::of($data)
            ->addColumn('action', function ($data) {

                return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-dark btn-sm btn_show_data  spec_input"><i class="bi bi-eye-fill"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center>
               
                    ';
            })
            ->addColumn('departure_date', function ($data) {

                return date_converter($data->departure_date);
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

            ->addColumn('status', function ($data) {

                return $this->status_html($data->request_status);
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
                $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                $url = dynamic_file($path);
                return '
                
                   <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>
                
                        ';
            })

            ->addColumn('admin_action', function ($data) {
                $hidden = $data->request_status != 'Pending' ? 'hidden' : '';

                return '
                    <div  class="btn-group dropstart input_spec my-1">
                        <button type="button" class="btn btn-outline-secondary  dropdown-toggle rounded-pill"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="1" data-id="' . $data->id . '" href="javascript:void(0);">Approve</a></li>
                            <li><a class="dropdown-item btn_approved" ' . $hidden . ' data-val="2" data-id="' . $data->id . '" href="javascript:void(0);">Disapprove</a></li>
                            <li><a class="dropdown-item btn_show_data" data-id="' . $data->id . '" href="javascript:void(0);">View</a></li>
                        </ul>
                    </div>
                ';
            })

            ->rawColumns(['action', 'status', 'action_file', 'admin_action'])
            ->make(true);
    }


    public function status_html($status)
    {

        if ($status == "Pending") {
            $stat = '
            <span class="badge rounded-pill bg-warning">Pending</span>
            ';
        } else if ($status == "Approved") {
            $stat = '
            <span class="badge rounded-pill bg-success">Approved</span>
';
        } else if ($status == "Disapproved") {
            $stat = '
            <span class="badge rounded-pill bg-danger">Disapproved</span>
            
            ';
        } else {
            $stat = '
            <span class="badge rounded-pill bg-danger">Error</span>
            
            ';
        }

        return '<center><h5>' . $stat . '</h5></center>';
    }

    public function retrieve_shuttle_request($id)
    {

        try {

            $data = AitsShuttleRequest::
                with(['get_event_data', 'get_requestor', 'get_requestor_data'])
                ->find($id);

            $number = $data->request_no;
            $request_number = sprintf('%03d', $number);
            $req_no = Carbon::parse($data->date_created)->format('Y-m-d') . '-' . $request_number;


            $data->departure_date = date_coverters_transit($data->departure_date);
            $data->appointment_date = date_coverters_transit($data->appointment_date);
            $data->pick_up_date = date_coverters_transit($data->pick_up_date);
            $data->request_number = $req_no;

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
        AND request_status='Approved';
        ";


        $data = DB::connection('sqlsrv')->select($query, []);


        $count = 0;

        if ($data) {
            $count = $data[0]->overlapping_count;
        }


        return $count;



    }

    public function delete_shuttle_request($id)
    {
        try {

            AitsShuttleRequest::where('id', $id)->update(['status' => 0]);

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
                    'manager_id' => ['required'],
                    'passenger_number' => ['required'],
                    'destination' => ['required'],
                    'remarks' => ['required'],



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


            $dateFrom = $formatted = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            $dateTo = $formatted = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d H:i:s.u');
            if ($dateFrom > $dateTo) {
                return response()->json([
                    'msg' => 'The pick up date must not be later than Departure date!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $from_date = Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d h:i A');
            $to_date = Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d h:i A');

            // $validation = $this->date_validation($from_date, $to_date);
            // if ($validation != 0) {
            //     return response()->json([
            //         'msg' => 'The service shuttle for that time is no longer available !',
            //         'status' => 402,
            //         "isValid" => false,
            //     ]);
            // }

            $request->merge([
                'departure_date' => Carbon::parse($request->departure_date, 'Asia/Manila')->format('Y-m-d h:i A'),
                'appointment_date' => Carbon::parse($request->appointment_date, 'Asia/Manila')->format('Y-m-d h:i A'),
                'pick_up_date' => Carbon::parse($request->pick_up_date, 'Asia/Manila')->format('Y-m-d h:i A'),

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



                ]
            );


            $data = AitsShuttleRequest::where('id', $request->id)->update($request->except(['id', 'ob_form']));

            if ($request->file('ob_form')) {
                AitsFileModel::where('table_name', 'AitsShuttleRequest')->where('attachment_id', $request->id)->update(['status' => 0]);

                $this->uploade_file_transit($request->id, "AitsShuttleRequest", 'aits_shuttle_file', $request->file('ob_form'));


            }


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


