<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\AitsArea;
use Illuminate\Http\Request;
use App\Models\AitsMessenger;
use Yajra\DataTables\DataTables;
use App\Models\AitsMessengersArea;
use Illuminate\Support\Facades\Auth;

class AitsAssignAreaController extends Controller
{
    //

    public function aits_assign_area()
    {
        $area = AitsArea::where('status', 1)->get();
        $messenger = AitsMessenger::where('status', 1)->get();
        return view('aits_pages_SA.aits_assign_area', compact('area', 'messenger'));
    }

    public function aits_area_user_data()
    {


        $data = AitsMessengersArea::with(['get_area', 'get_user_profile', 'get_user_data'])->where('status', 1)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $roles = htmlspecialchars($data->role);
                return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center> ';
            })
            ->addColumn('messenger', function ($data) {

                return $data->get_user_profile['firstname'] . ' ' . $data->get_user_profile['lastname'];
            })
            ->addColumn('area_list', function ($data) {

                return $data->get_area['area'];
            })
            ->rawColumns(['action'])

            ->make(true);

    }

    public function aits_save_area_messenger(Request $request)
    {
        try {


            $validated = Validator::make(
                $request->all(),
                [
                    'messenger_id' => ['required'],
                    'area_id' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $validation = AitsMessengersArea::where($request->all())->where('status', 1)->first();
            if ($validation) {
                return response()->json([
                    'msg' => 'The area and Messenger is Assign at the same time',
                    'status' => 402,
                    "isValid" => false,
                ]);

            }
            $request->merge([
                'status' => 1,
                'user_id' => Auth::user()->id,
                'date_created' => Carbon::now()
            ]);
            $datas = AitsMessengersArea::create($request->all());
            return response()->json([
                'msg' => 'Successfully Added',
                'status' => 200,
                "isValid" => true,
                'data' => $datas,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }


    public function aits_show_area_messenger($id)
    {

        try {
            $data = AitsMessengersArea::with(['get_area', 'get_user_profile', 'get_user_data'])->where('id', $id)->first();
            return response()->json([
                'msg' => 'Data is Successfully Provided',
                'status' => 200,
                "isValid" => true,
                "data" => $data,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function aits_mess_area_edit(Request $request)
    {
        try {


            $validated = Validator::make(
                $request->all(),
                [
                    'messenger_id' => ['required'],
                    'area_id' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $validation = AitsMessengersArea::where($request->except(['id']))
                ->where('status', 1)
                ->whereNot('id', $request->id)
                ->first();
            if ($validation) {
                return response()->json([
                    'msg' => 'The area and Messenger is Assign at the same time',
                    'status' => 402,
                    "isValid" => false,
                ]);

            }
            $request->merge([
                'status' => 1,
                'user_id' => Auth::user()->id,
                'date_created' => Carbon::now()
            ]);
            $datas = AitsMessengersArea::where('id', $request->id)->update($request->except(['id']));
            return response()->json([
                'msg' => 'Successfully Updated',
                'status' => 200,
                "isValid" => true,
                'data' => $datas,
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error Please Contact ICT department' . '<br>' . $e->getMessage(),
                'status' => 402,
                'isValid' => false,
            ]);
        }

    }

    public function aits_mess_area_delete($id)
    {


        try {
            $validation = AitsMessengersArea::where('id', $id)->update([
                'status' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }
}
