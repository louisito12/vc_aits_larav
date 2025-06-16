<?php

namespace App\Http\Controllers;

use App\Models\AitsMessenger;
use Validator;
use Carbon\Carbon;
use App\Models\UserModel;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{

    public function user_manage_view()
    {

        return view("aits_pages.aits_usermanage");
    }

    // $ticket = DB::connection('ict_ticketing')
    // ->table('ref_departments') 
    // ->where('id', 1001)
    // ->first();




    public function register_user(Request $request)
    {

        $validator = Validator::make(
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
                'contact_no' => ['required'],
                'roles' => ['required', 'array', 'min:1'],
            ],
        );


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $user = UserModel::where('username', $request->username)->where('isactive', 1)->first();

        if ($user) {

            return redirect()->back()
                ->withErrors(['username' => 'This user is already existing.'])
                ->withInput();
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
        if (in_array(4, $request->input('roles'))) {

            AitsMessenger::insert([
                'fname' => $request->firstname,
                'mname' => $request->middlename,
                'lname' => $request->lastname,
                'cen_user_id' => $last_id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ]);
        }

        $roles = $request->input('roles');
        $this->role_update($last_id, $roles);
        return redirect()->back()->with('registration_success', 'Registration complete! Please login.');



    }

    public function retrieve_department()
    {


        return $ticket = DB::connection('ict_ticketing')
            ->table('ref_departments')
            ->where('id', 1001)
            ->first();
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




    public function retrieve_user($id)
    {



    }



    public function update_user(Request $request)
    {




    }






}
