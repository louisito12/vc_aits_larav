<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use App\Models\UserProfile;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AitsRoomModel;
use App\Models\AitsEventModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\AitsRequestRoomModel;

class Aits_Request_Room_Controller extends Controller
{




    public function request_room_view()
    {

        $room = AitsRoomModel::where('status', 1)->get();
        $event = AitsEventModel::where('status', 1)->get();


        return view('aits_pages.aits_room_request', compact(['room', 'event']));

    }



    public function aits_save_room_request(Request $request)
    {

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'room_id' => [
                        'required',
                    ],
                    'event_id' => ['required'],
                    'date_to' => ['required'],
                    'date_from' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            if ($request->event_id == "remarks") {
                if ($request->remarks == "") {
                    return response()->json([
                        'msg' => 'Purpose is required!',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }


            $dateFrom = $formatted = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A');
            $dateTo = $formatted = Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A');
            if ($dateFrom > $dateTo) {
                return response()->json([
                    'msg' => 'The To date must be later than from date !',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }
            $from_date = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A');
            $to_date = Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A');

            $validation = $this->request_room_validation($from_date, $to_date, $request->room_id);
            if ($validation != 0) {
                return response()->json([
                    'msg' => 'The room is scheduled on that time and date frame !',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }



            $request->merge([
                'status' => 1,
                'year' => Carbon::now()->year,
                'request_no' => $this->request_no(),
                'request_status' => "Pending",
                'request_by' => Auth::user()->id,
                'date_created' => Carbon::now(),
                'is_transact' => 1,
                'date_from' => Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A'),
                'date_to' => Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A'),

            ]);


            $insert = $request->all();
            if ($request->event_id == "remarks") {
                $insert = $request->except(['event_id']);
            }



            $data = AitsRequestRoomModel::insert([
                $insert
            ]);

            return response()->json([
                'msg' => 'Successfully Inserted Request Room',
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



    public function get_request_data()
    {

        //for requestor only


        try {
            $data = AitsRequestRoomModel::with(['get_event_data', 'get_room_data', 'get_requestor'])
                ->where('status', 1)
                ->where('request_by', Auth::user()->id)->get();



            return $this->room_request_datatable($data);

        } catch (\Exception $e) {

            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'data' => [],
                'status' => 402,
                "isValid" => false,
            ]);

        }


    }

    public function request_no()
    {
        $request_no = 1;

        $recent_request = AitsRequestRoomModel::
            where('is_transact', 1)
            ->where('year', Carbon::now()->year)
            ->orderBy('request_no', 'Desc')
            ->first();

        if ($recent_request) {
            $request_no = (int) $recent_request->request_no + 1;
        }

        return $request_no;



    }


    public function request_room_validation($from_date, $to_date, $room_id)
    {

        $fromDate = Carbon::parse($from_date)->format('Y-m-d H:i:s');
        $toDate = Carbon::parse($to_date)->format('Y-m-d H:i:s');

        $query = "
        SELECT COUNT(*) AS overlapping_count
        FROM aits_request_room_models    WHERE
        ((date_from BETWEEN  '$fromDate' AND '$toDate')
        OR (date_to BETWEEN  '$fromDate' AND '$toDate')
        OR ('$fromDate' BETWEEN date_from AND date_to)
        OR ('$toDate' BETWEEN date_from AND date_to) )
        AND request_status ='Approved'
        AND room_id = $room_id;";

        $data = DB::connection('sqlsrv')->select($query, []);


        $count = 0;

        if ($data) {
            $count = $data[0]->overlapping_count;
        }


        return $count;



    }


    public function room_request_datatable($data)
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
            ->addColumn('room', function ($data) {
                return $data['get_room_data']['room_name'];

            })
            ->addColumn('event', function ($data) {
                return $data['get_event_data'] ? $data['get_event_data']['event'] : $data['remarks'];

            })
            ->addColumn('department', function ($data) {
                $profile = get_user_profile($data->request_by);
                return DepartmentModel::find($profile->deparment_id)->description;

            })
            ->addColumn('date_from', function ($data) {
                return date_converter($data->date_from);

            })
            ->addColumn('date_to', function ($data) {
                return date_converter($data->date_to);

            })
            ->addColumn('date_created', function ($data) {
                return date_converter($data->date_created);

            })
            ->addColumn('status', function ($data) {
                return $this->status_html($data->request_status);
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
            ->addColumn('request_no', function ($data) {
                $number = $data->request_no;
                $request_number = sprintf('%03d', $number);

                return $data->year . '-' . $request_number;

            })
            ->rawColumns(['action', 'status', 'admin_action'])
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


    public function table_logs($request)
    {


        try {
            AitsRequestRoomModel::insert([$request]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'data' => [],
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }


    public function retrieve_room_request($id)
    {

        try {
            $data = AitsRequestRoomModel::with(['get_event_data', 'get_room_data', 'get_requestor', 'get_requestor_data', 'get_department', 'get_approved_data'])->find($id);
            $data->date_from = date_coverters($data->date_from);
            $data->date_to = date_coverters($data->date_to);

            $data->approve_date = date_converter($data->dateapprove_date_created);

            return [

                'msg' => 'Succesfully Provided',
                'data' => $data,
                'status' => 200,
                "isValid" => true,
            ];

        } catch (\Exception $e) {
            return [
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'data' => [],
                'status' => 402,
                "isValid" => false,
            ];
        }
    }

    public function update_request_room(Request $request)
    {

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'room_id' => [
                        'required',
                    ],
                    'event_id' => ['required'],
                    'date_to' => ['required'],
                    'date_from' => ['required'],
                ],
            );

            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            if ($request->event_id == "remarks") {
                if ($request->remarks == "") {
                    return response()->json([
                        'msg' => 'Purpose is required!',
                        'status' => 402,
                        "isValid" => false,
                    ]);
                }
            }

            $dateFrom = $formatted = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A');
            $dateTo = $formatted = Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A');
            if ($request->date_from > $request->date_to) {
                return response()->json([
                    'msg' => 'The To date must be later than from date !',
                    'status' => 402,
                    "isValid" => false,
                ]);

            }
            $from_date = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A');
            $to_date = Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A');



            $validation = $this->request_room_validation($from_date, $to_date, $request->room_id);
            if ($validation != 0) {
                return response()->json([
                    'msg' => 'The room is scheduled on that time and date frame !',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            $data = AitsRequestRoomModel::where('id', $request->id)->first();
            $data->status = 2;
            $data->date_created = Carbon::now();
            $data->orig_id = $request->id;
            $data->edited_by = Auth::user()->id;
            $data->is_transact = 0;





            $logData = $data->toArray();
            unset($logData['id']);
            unset($logData['updated_at']);


            $this->table_logs($logData);

            $request->merge([
                'date_from' => $formatted = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A'),
                'date_to' => $formatted = Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A'),
            ]);

            $data_update = AitsRequestRoomModel::where('id', $request->id)->update($request->except(['id']));







        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function delete_request($id)
    {
        try {
            AitsRequestRoomModel::where('id', $id)->update(['status' => 0]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }
}





//   $errorMessages = $validator->errors()->all();
// Create a validator instance
// $validator = Validator::make($request->all(), $rules);
// Check if validation fails
// if ($validator->fails()) {
//     // Retrieve all error messages as an array of strings
//     $errorMessages = $validator->errors()->all();

//     // Return the error messages
//     return response()->json([
//         'errors' => $errorMessages,
//     ], 422);
// }
//date_conversion here
// $formatted = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A');
// $date_val = Carbon::createFromFormat('Y-m-d h:i A', $formatted)->format('Y-m-d\TH:i');
//    $today = Carbon::today()->format('Y-m-d');
// $roomRequests = AitsRequestRoomModel::whereRaw("LEFT([date_from], 10) = ?", [$today])
//     ->get();
//   $dateFrom = $formatted = Carbon::parse($request->date_from, 'Asia/Manila')->format('Y-m-d h:i A');
//             $dateTo = $formatted = Carbon::parse($request->date_to, 'Asia/Manila')->format('Y-m-d h:i A');
//             if ($dateFrom <= $dateTo) {
//                 echo 0;
//             } else {
//                 echo 5;
//             }
// SELECT *
// FROM aits_request_room_models
// WHERE LEFT(date_from, 10) BETWEEN '2025-06-01' AND '2025-06-31';