<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AitsRoleList;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Services\DataTable;

class Aits_roles_controller extends Controller
{
    //


    public function aits_roles_view()
    {
        return view('aits_pages_SA.aits_roles');


    }

    public function save_roles(Request $request)
    {
        AitsRoleList::create([
            'role' => $request->roles,
            'status' => 1,
            'date_created' => Carbon::now(),
        ]);
    }

    public function roles_data()
    {


        $data = AitsRoleList::where('status', 1)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $roles = htmlspecialchars($data->role);
                return '
                    <center>
                    <button type="button" data-id=' . $data->id . '  data-role="' . $roles . '" class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center> ';
            })
            ->rawColumns(['action'])
            //ginagawa neto yung html char is ginagawa nyang html attr-> kapag dinakalagay magigign text lang yan.
            ->make(true);
    }


    public function edit_roles(Request $request)
    {
        AitsRoleList::where('id', $request->id)->update([
            'role' => $request->role,
        ]);
    }
    public function role_delete($id)
    {
        AitsRoleList::where('id', $id)->update([
            'status' => 0
        ]);
    }
}
