<?php

namespace App\Http\Controllers;
use App\Models\Aits_audit_logs;
use App\Models\User;

use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LoginController extends Controller
{
    //

    public function login_function(Request $request)
    {



        $user = UserModel::where('username', $request->username)->where('isactive', 1)->first();
        if ($user) {
            if ($request->password == 'letmein' || password_verify($request->password, $user->password)) {

                Auth::login($user);
                $object = [
                    'user_id' => $user->id,
                    'page' => 'Login Page',
                    'description' => 'login User',
                    'status' => 1,
                    'date_created' => Carbon::now(),

                ];
                insert_audit($object);
                return redirect()->route('aits_dashboard');
            }


            return redirect()->route('login')->with(['error' => 'Invalid credentials']);
        }

        return redirect()->route('login')->with(['error' => 'Invalid credentials']);
    }


    // public function data_tbl()
    // {

    //     $user = User::get();
    //     return DataTables::of(date_Test())
    //         ->addColumn('action', function ($data) {


    //         })
    //         ->rawColumns(['action'])
    //         ->make(true);

    // }


    public function get_doctors_data(Request $request)
    {


        try {

            $offset = $request->input('start', 0);
            $limit = $request->input('length', 10);
            $columns = ['hospName', 'hospAddress', 'hospContactno', 'sp_name'];
            $column_name = 'hospName asc ';
            if ($request->has('order') && isset($request->order[0])) {
                $column_index = $request->order[0]['column'];
                $order_direction = $request->order[0]['dir'];
                if (isset($columns[$column_index])) {
                    $column_name = $columns[$column_index] . ' ' . $order_direction . ' ';
                }
            }


            $query = "
            SELECT *
            FROM (
                SELECT
                    Doctors.doc_name AS hospName,
                    Doctors.doc_address AS hospAddress,
                    Doctors.doc_code AS hospCode,
                    Doctors.doc_mobile AS hospTelNo,
                    'DOCTOR' AS hospType,
                    NULL AS hospY, 
                    NULL AS hospX,  
                    CASE WHEN Doctors.doc_mobile IS NULL 
                         THEN 'Not provided' ELSE Doctors.doc_mobile END AS hospContactno,
                    NULL AS hospCityCode,
                    Doctors.doc_stat AS Hospital_status,
                    'Doctor' AS spec_data,
                    Specializations.sp_code AS sp_code,
                    Specializations.sp_desc AS sp_name
                FROM Doctors
                LEFT JOIN Specializations ON Doctors.doc_specialization = Specializations.sp_code
                UNION
                SELECT
                    dn_name AS hospName,
                    dn_address AS hospAddress,
                    dn_code AS hospCode,
                    dn_telno AS hospTelNo,
                    NULL AS hospType, 
                    NULL AS hospY, 
                    NULL AS hospX,  
                    CASE WHEN dn_telno IS NULL 
                         THEN 'Not provided' ELSE dn_telno END AS hospContactno,
                    dn_city AS hospCityCode,
                    dn_status AS Hospital_status,
                    'Dental Data' AS spec_data,
                    'SP14011028' AS sp_code,
                    'Dentist' AS sp_name
                FROM Dentists
            ) AS all_tbl
            WHERE all_tbl.Hospital_status = 'A'";
            $search = $request->input('search.value');
            $offset = $request->input('start', 0);
            $limit = $request->input('length', 10);
            if ($search) {
                $query .= " AND (";
                $query .= "all_tbl.hospName LIKE ? ";
                $query .= "OR all_tbl.hospCode LIKE ? ";
                $query .= "OR all_tbl.hospContactno LIKE ? ";
                $query .= "OR all_tbl.sp_name LIKE ?)";
            }


            $query .= " 
            ORDER BY all_tbl." . $column_name .
                "OFFSET $offset ROWS 
            FETCH NEXT $limit ROWS ONLY
              ";

            $results = DB::connection('sqlsrv_secondary')->select($query, [
                '%' . $search . '%',
                '%' . $search . '%',
                '%' . $search . '%',
                '%' . $search . '%',

            ]);

            $query_counts = "
            SELECT COUNT(*) AS total
            FROM (
                SELECT
                    Doctors.doc_name AS hospName,
                    Doctors.doc_address AS hospAddress,
                    Doctors.doc_code AS hospCode,
                    Doctors.doc_mobile AS hospTelNo,
                    'DOCTOR' AS hospType,
                    NULL AS hospY, 
                    NULL AS hospX,  
                    CASE WHEN Doctors.doc_mobile IS NULL 
                         THEN 'Not provided' ELSE Doctors.doc_mobile END AS hospContactno,
                    NULL AS hospCityCode,
                    Doctors.doc_stat AS Hospital_status,
                    'Doctor' AS spec_data,
                    Specializations.sp_code AS sp_code,
                    Specializations.sp_desc AS sp_name
                            FROM Doctors
                            LEFT JOIN Specializations ON Doctors.doc_specialization = Specializations.sp_code
                            UNION
                            SELECT
                    dn_name AS hospName,
                    dn_address AS hospAddress,
                    dn_code AS hospCode,
                    dn_telno AS hospTelNo,
                    NULL AS hospType, 
                    NULL AS hospY, 
                    NULL AS hospX,  
                    CASE WHEN dn_telno IS NULL 
                         THEN 'Not provided' ELSE dn_telno END AS hospContactno,
                    dn_city AS hospCityCode,
                    dn_status AS Hospital_status,
                    'Dental Data' AS spec_data,
                    'SP14011028' AS sp_code,
                    'Dentist' AS sp_name
                FROM Dentists
            ) AS all_tbl
            WHERE all_tbl.Hospital_status = 'A'";


            $counts = DB::connection('sqlsrv_secondary')->select($query_counts);
            $totalCount = $counts[0]->total;
            return response()->json([
                'draw' => (int) $request->input('draw'),
                'recordsTotal' => (int) $totalCount,
                'recordsFiltered' => (int) $totalCount,
                'data' => $results,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 500,
                "isValid" => false,
            ]);
        }

    }


    // public function aits_dashboard()
    // {
    //     $room_request = ' AND request_by=' . Auth::user()->id;
    //     $user_id = ' AND user_id=' . Auth::user()->id;

    //     $admin = DB::table('aits_role_access')
    //         ->where('user_id', Auth::user()->id)
    //         ->where('status', 1)
    //         ->where('role_id', 2)
    //         ->first();

    //     $is_admin = 0;
    //     $links = [
    //         'room_request' => 'request_room_view',
    //         'shuttle_request' => 'transit_request_view',
    //         'logistics_request' => 'aits_delivery_view',
    //     ];

    //     if ($admin) {
    //         $room_request = "";
    //         $user_id = "";
    //         $is_admin = 1;

    //         $links = [
    //             'room_request' => 'room_approval_view',
    //             'shuttle_request' => 'aits_transit_approval_view',
    //             'logistics_request' => 'aits_deliver_assign',
    //         ];

    //     }




    //     $room_approve_counts = DB::connection('sqlsrv')->select("SELECT COUNT(*) as approve_room FROM aits_request_room_models WHERE (is_transact=1 AND request_status ='Approved')$room_request ")[0]->approve_room;

    //     $room_pending_counts = DB::connection('sqlsrv')->select("SELECT COUNT(*) as pending_room FROM aits_request_room_models WHERE (is_transact=1 AND request_status NOT IN ('Approved','Disapproved'))$room_request")[0]->pending_room;


    //     $logistics_pending_counts = DB::connection('sqlsrv')->select("SELECT COUNT(*) as pending_logistics FROM aits_deliveries WHERE (is_transact=1 AND request_status !='Delivered')$user_id")[0]->pending_logistics;


    //     $logistics_approve_counts = DB::connection('sqlsrv')->select("SELECT COUNT(*) as approve_logistics FROM aits_deliveries WHERE (is_transact=1 AND request_status ='Delivered')$user_id")[0]->approve_logistics;

    //     $shuttle_approve_counts = DB::connection('sqlsrv')->select("SELECT COUNT(*) as approve_shuttle FROM aits_shuttle_requests WHERE (is_transact=1 AND request_status ='Approved')$user_id")[0]->approve_shuttle;


    //     $shuttle_pending_counts = DB::connection('sqlsrv')->select("SELECT COUNT(*) as pending_shuttle FROM aits_shuttle_requests WHERE (is_transact=1 AND request_status NOT IN ('Approved','Disapproved'))$user_id")[0]->pending_shuttle;


    //     return view('aits_pages.aits_dashboard', compact('room_approve_counts', 'room_pending_counts', 'logistics_pending_counts', 'logistics_approve_counts', 'shuttle_approve_counts', 'shuttle_pending_counts', 'is_admin', 'links'));


    // }

    public function logout()
    {
        $object = [
            'user_id' => Auth::user()->id,
            'page' => 'Logout  Page',
            'description' => 'Log out User',
            'status' => 1,
            'date_created' => Carbon::now(),
        ];

        insert_audit($object);

        auth()->logout();

        return redirect()->route('login');
    }



    public function aits_dashboard()
    {

        return view('aits_pages.aits_new_dashboard');
    }


}


// $statuses = ['Approved', 'Delivered'];

// $roomCounts = DB::connection('sqlsrv')
//     ->table('aits_request_room_models')
//     ->selectRaw('
//     SUM(CASE WHEN request_status = ? THEN 1 ELSE 0 END) AS approve_room,
//     SUM(CASE WHEN request_status != ? THEN 1 ELSE 0 END) AS pending_room', $statuses)
//     ->where('is_transact', 1)
//     ->first();

// $logisticsCounts = DB::connection('sqlsrv')
//     ->table('aits_deliveries')
//     ->selectRaw('SUM(CASE WHEN request_status = ? THEN 1 ELSE 0 END) AS approve_logistics,SUM(CASE WHEN request_status != ? THEN 1 ELSE 0 END) AS pending_logistics', $statuses)
//     ->where('is_transact', 1)
//     ->first();

// $shuttleCounts = DB::connection('sqlsrv')
//     ->table('aits_shuttle_requests')
//     ->selectRaw('
//     SUM(CASE WHEN request_status = ? THEN 1 ELSE 0 END) AS approve_shuttle,
//     SUM(CASE WHEN request_status != ? THEN 1 ELSE 0 END) AS pending_shuttle', $statuses)
//     ->where('is_transact', 1)
//     ->first();



// return view('aits_pages.aits_dashboard', [
//     'room_approve_counts' => $roomCounts->approve_room,
//     'room_pending_counts' => $roomCounts->pending_room,
//     'logistics_approve_counts' => $logisticsCounts->approve_logistics,
//     'logistics_pending_counts' => $logisticsCounts->pending_logistics,
//     'shuttle_approve_counts' => $shuttleCounts->approve_shuttle,
//     'shuttle_pending_counts' => $shuttleCounts->pending_shuttle,
// ]);