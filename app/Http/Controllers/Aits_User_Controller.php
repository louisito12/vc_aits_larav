<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Carbon\Carbon;
use Validator;
use App\Models\UserModel;
use App\Models\AitsRoleList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Aits_User_Controller extends Controller
{
    //


    public function aits_usermanagement()
    {
        $gender = DB::connection('ict_ticketing')->table('ref_gender')->get();
        $citizen = DB::connection('ict_ticketing')->table('ref_citizenship')->get();
        $civil = DB::connection('ict_ticketing')->table('ref_civil_status')->get();
        $department = DB::connection('ict_ticketing')->table('ref_departments')->get();
        $suffix = DB::connection('ict_ticketing')->table('ref_suffix')->get();

        $role = AitsRoleList::where('status', 1)->get();


        return view('aits_pages_SA.usermanage', compact('gender', 'citizen', 'civil', 'department', 'role', 'suffix'));
    }


    public function show_users(Request $request)
    {

        $columns = ['fullname', 'username', 'department'];
        $column_index = $request->input('order.0.column', 0);
        $order_direction = $request->input('order.0.dir', 'asc');
        $column_name = isset($columns[$column_index]) ? $columns[$column_index] : 'fullname';
        $order_direction = in_array(strtolower($order_direction), ['asc', 'desc']) ? strtoupper($order_direction) : 'ASC';
        $search = $request->input('search.value');
        $offset = $request->input('start', 0);
        $limit = $request->input('length', 10);


        //query
        // $sql_counts = "  SELECT COUNT(*) AS counts FROM users LEFT JOIN tbl_personal_datas ON users.id = tbl_personal_datas.user_id WHERE users.id NOT IN(654,535) AND users.isactive=1";
        // $data_counts = DB::connection('main_user')->select($sql_counts);
        // $total = $data_counts[0]->counts;



        $sql_counts = "SELECT COUNT(*) AS counts
               FROM aits_users.dbo.users AS users
               LEFT JOIN aits_users.dbo.tbl_personal_datas AS tbl_personal_datas ON users.id = tbl_personal_datas.user_id
               LEFT JOIN cenuser_db.dbo.ref_departments AS department ON tbl_personal_datas.deparment_id = department.id
               WHERE users.id NOT IN(654,535) AND users.isactive=1 AND tbl_personal_datas.is_users=1";

        if ($search) {
            $sql_counts .= " AND (CONCAT(tbl_personal_datas.firstname, ' ', tbl_personal_datas.lastname) LIKE ? 
                       OR users.username LIKE ? OR department.description LIKE ?)";
        }

        $data_counts = DB::connection('main_user')->select($sql_counts, [
            '%' . $search . '%',
            '%' . $search . '%',
            '%' . $search . '%',
        ]);

        $total = $data_counts[0]->counts;


        $query = "SELECT users.id AS User_id,
            CONCAT(tbl_personal_datas.firstname, ' ', tbl_personal_datas.lastname) AS fullname,
            users.username,department.description AS department
            FROM aits_users.dbo.users AS users
            LEFT JOIN aits_users.dbo.tbl_personal_datas AS tbl_personal_datas ON users.id = tbl_personal_datas.user_id
            LEFT JOIN cenuser_db.dbo.ref_departments AS department ON tbl_personal_datas.deparment_id = department.id WHERE
            (users.id NOT IN(654,535) AND users.isactive=1 AND tbl_personal_datas.is_users=1)";

        if ($search) {
            $query .= " AND (CONCAT(tbl_personal_datas.firstname, ' ', tbl_personal_datas.lastname) LIKE ? 
            OR users.username LIKE ? OR department.description LIKE ?)";
        }


        $query .= " ORDER BY $column_name $order_direction";
        $query .= " OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
        $data = DB::connection('main_user')->select($query, [
            '%' . $search . '%',
            '%' . $search . '%',
            '%' . $search . '%',
        ]);





        $data_val = [];
        foreach ($data as $datas) {
            $datas->action = '
             <center>
            <button type="button" data-id="' . $datas->User_id . '" class="btn btn-primary btn-sm btn_edit spec_input">
                <i class="bi bi-pencil"></i>
            </button>
            <button type="button" data-id="' . $datas->User_id . '" class="btn btn-danger btn-sm btn_delete spec_input">
                <i class="bi bi-trash"></i>
            </button>
                 </center> ';

            $data_val[] = $datas;
        }

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data_val,
        ]);

    }


    public function aits_save_user(Request $request)
    {
        // return $request->all();

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'citizenship_id' => ['required'],
                    'birthdate' => ['required'],
                    'civil_status_id' => ['required'],
                    'department_id' => ['required'],
                    'firstname' => ['required'],
                    'gender_id' => ['required'],
                    'lastname' => ['required'],
                    'middlename' => ['required'],
                    'password' => ['required'],
                    'suffix_id' => ['required'],
                    'user_email' => ['required'],
                    'user_title' => ['required'],
                    'username' => ['required'],
                    // 'contact_no' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $users_validation = UserModel::where(
                'username',
                $request->username
            )->first();
            if ($users_validation) {
                return response()->json([
                    'msg' => 'The username that you entered is already in used',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            $profile = 'male_blank.jpg';
            if ($request->gender_id == '1002') {
                $profile = 'female_blank.png';
            }

            $last_id = UserModel::insertGetId([
                'username' => $request->username,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'contact_no' => $request->contact_no,
                'isactive' => 1,
                'isdelete' => 0,
                'profile_pic_path' => $profile,
                'user_email' => $request->user_email,
                'created_at' => Carbon::now(),

            ]);

            $this->role_update($last_id, $request->roles_arr);

            $insert_profile = UserProfile::create([
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffix_id' => $request->suffix_id,
                'birthdate' => $request->birthdate,
                'gender_id' => $request->gender_id,
                'deparment_id' => $request->department_id,
                'civil_status_id' => $request->civil_status_id,
                'user_title' => $request->user_title,
                'user_id' => $last_id,
                'created_at' => Carbon::now(),
                'citizenship_id' => $request->citizenship_id,

            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function aits_edit_user(Request $request)
    {

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'citizenship_id' => ['required'],
                    'birthdate' => ['required'],
                    'civil_status_id' => ['required'],
                    'department_id' => ['required'],
                    'firstname' => ['required'],
                    'gender_id' => ['required'],
                    'lastname' => ['required'],
                    'middlename' => ['required'],
                    // 'password' => ['required'],
                    'suffix_id' => ['required'],
                    'user_email' => ['required'],
                    'user_title' => ['required'],
                    'username' => ['required'],
                    // 'contact_no' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            $users_validation = UserModel::where(
                'username',
                $request->username
            )->whereNot('id', $request->id)->first();


            if ($users_validation) {
                return response()->json([
                    'msg' => 'The username that you entered is already in used',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $profile = 'male_blank.jpg';
            if ($request->gender_id == '1002') {
                $profile = 'female_blank.png';
            }


            $last_id = UserModel::where('id', $request->id)->update([
                'username' => $request->username,
                // 'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'contact_no' => $request->contact_no,
                'isactive' => 1,
                'isdelete' => 0,
                'profile_pic_path' => $profile,
                'user_email' => $request->user_email,
                'updated_at' => Carbon::now(),

            ]);

            $this->role_update($request->id, $request->update_roles);


            $insert_profile = UserProfile::where('user_id', $request->id)->update([
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'suffix_id' => $request->suffix_id,
                'birthdate' => $request->birthdate,
                'gender_id' => $request->gender_id,
                'deparment_id' => $request->department_id,
                'civil_status_id' => $request->civil_status_id,
                'user_title' => $request->user_title,
                'updated_at' => Carbon::now(),
                'citizenship_id' => $request->citizenship_id,

            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function get_user_info($id)
    {
        try {

            $data = UserModel::with(['get_user_data'])->find($id);

            $roles = DB::table('aits_role_access')
                ->where('user_id', $data->id)
                ->where('status', 1)
                ->pluck('role_id');
            $data->role = $roles;
            return response()->json([

                'msg' => 'successfully provided',
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

    public function users_delete($id)
    {
        try {


            UserModel::where('id', $id)->update(['isactive' => 0]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }


    public function role_update($user_id, $roles)
    {
        $roles_acces = DB::table('aits_role_access')->where('user_id', $user_id)->update([
            'status' => 0
        ]);

        foreach ($roles as $role) {
            DB::table('aits_role_access')->insert([
                'user_id' => $user_id,
                'role_id' => $role,
                'status' => 1,
                'date_created' => Carbon::now(),
            ]);
        }



    }
}








// citizen     {
// id: "1001",
// description: "Filipino",

// civil  
// id: "1000",
// description: "Not Applicable",

//gender


// ref_position_level
// id,desc














//citizen,civilstatus,gender,[ref_position_level],suffix,
//create project for users tbl_personal_data