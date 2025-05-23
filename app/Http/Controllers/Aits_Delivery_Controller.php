<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use Validator;
use Carbon\Carbon;
use App\Models\AitsArea;
use App\Models\UserModel;
use App\Models\AitsDelivery;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\AitsDeliveryType;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class Aits_Delivery_Controller extends Controller
{



    public function show_data()
    {

        return UserModel::with(['get_user_data'])->limit(5)->get();

    }


    public function aits_delivery_view()
    {
        $type = AitsDeliveryType::where('status', 1)->get();
        $area = AitsArea::where('status', 1)->get();
        return view('aits_pages.aits_logistics_delivery', compact(['type', 'area']));
    }




    public function aits_save_delivery(Request $request)
    {

        try {

            $validated = Validator::make(
                $request->all(),
                [
                    'name_receiver' => [
                        'required',
                    ],
                    'company_name' => ['required'],
                    'contact_receiver' => ['required'],
                    'delivery_type_id' => ['required'],
                    'area_id' => ['required'],
                    'count_documents' => ['required'],
                    'complete_address' => ['required'],
                    'delivery_remarks' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }


            $request->merge([
                'is_transact' => 1,
                'date_created' => Carbon::now(),
                'request_no' => $this->request_no(),
                'status' => 1,
                'user_id' => Auth::user()->id,
                'request_status' => 'Pending',

            ]);


            $data = AitsDelivery::create($request->except(['file']));


            $this->uploade_file_transit($data->id, 'AitsDelivery', $request->file('file'), 1);
            // public function uploade_file_transit($id, $table_name, $files, $delivery)
            return response()->json([
                'msg' => 'Successfully Inserted Request Room',
                'status' => 200,
                'data' => $data,
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




    public function uploade_file_transit($id, $table_name, $files, $delivery)
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
                "folder_name" => 'aits_delivery_file',
                "year" => Carbon::now()->year,
                "status" => 1,
                "date_created" => Carbon::now(),
                'procedure' => $delivery,
            ]);


            $item->move('aits_delivery_file/' . $year . '/', $format_name . '.' . $ext);
        }

    }



    public function request_no()
    {
        $request_no = 1;
        $recent_request = AitsDelivery::where('is_transact', 1)
            ->whereDate('date_created', Carbon::today()->toDateString())
            ->orderBy('request_no', 'desc')
            ->first();

        if ($recent_request) {
            $request_no = (int) $recent_request->request_no + 1;
        }
        return $request_no;

    }

    public function show_delivery_request()
    {

        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->where('status', 1)->where('user_id', Auth::user()->id)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {

                return '
                    <center>
                    <button type="button" data-id=' . $data->id . ' class="btn btn-dark btn-sm btn_show_data  spec_input"><i class="bi bi-eye-fill"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-primary btn-sm btn_edit spec_input"><i class="bi bi-pencil"></i></button> 
                    <button type="button" data-id=' . $data->id . ' class="btn btn-danger btn-sm btn_delete spec_input"><i class="bi bi-trash"></i></button>
                    </center> ';

            })
            ->addColumn('request_no', function ($data) {
                return request_number($data->request_no, $data->date_created);
            })
            ->addColumn('date_created', function ($data) {
                return date_converter($data->date_created);

            })
            ->addColumn('department', function ($data) {
                return DepartmentModel::find($data->get_requestor_fullname->deparment_id)->description;

            })
            ->addColumn('delivery_type', function ($data) {
                return $data['get_delivery_type']['del_type'];

            })
            ->addColumn('requestor', function ($data) {
                return $data['get_requestor_fullname']['firstname'] . ' ' . $data['get_requestor_fullname']['lastname'];

            })
            ->addColumn('req_status', function ($data) {
                return $this->status_html($data->request_status);

            })
            ->addColumn('view_file_request', function ($data) {
                $data_file = AitsFileModel::where('table_name', 'AitsDelivery')
                    ->where('procedure', 1)
                    ->where('status', 1)
                    ->where('attachment_id', $data->id)
                    ->first();
                $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                $url = dynamic_file($path);
                return ' <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>';

            })
            ->rawColumns(['action', 'view_file_request', 'req_status'])
            ->make(true);

    }

    public function get_delivery_data($id)
    {
        try {
            $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->find($id);
            $data->req_name = $data['get_requestor_fullname']['firstname'] . ' ' . $data['get_requestor_fullname']['lastname'];
            return response()->json([
                'msg' => 'Successfully Inserted Request Room',
                'status' => 200,
                'data' => $data,
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



    public function status_html($status)
    {

        if ($status == "Pending") {
            $stat = '<span class="badge rounded-pill bg-warning">Pending</span>';
        } else if ($status == "Delivered") {
            $stat = '   <span class="badge rounded-pill bg-success">Delivered</span>';

        } else if ($status == "Disapproved") {
            $stat = ' <span class="badge rounded-pill bg-danger">Disapproved</span> ';

        } else {
            $stat = '<span class="badge rounded-pill bg-danger">Error</span>';
        }
        return '<center><h5>' . $stat . '</h5></center>';
    }

    public function delete_delivery_request($id)
    {
        $data = AitsDelivery::where('id', $id)->update(['status' => 0]);

    }

    public function edit_delivery_request(Request $request)
    {

        try {

            $validated = Validator::make(
                $request->all(),
                [
                    'name_receiver' => [
                        'required',
                    ],
                    'company_name' => ['required'],
                    'contact_receiver' => ['required'],
                    'delivery_type_id' => ['required'],
                    'area_id' => ['required'],
                    'count_documents' => ['required'],
                    'complete_address' => ['required'],
                    'delivery_remarks' => ['required'],
                ],
            );


            if ($validated->fails()) {
                return response()->json([
                    'msg' => 'All fields are required!',
                    'status' => 402,
                    "isValid" => false,
                ]);
            }

            $old_data = AitsDelivery::find($request->id);


            $logs = AitsDelivery::create([
                'orig_id' => $request->id,
                'edited_by' => Auth::user()->id,
                'company_name' => $old_data->company_name,
                'name_receiver' => $old_data->name_receiver,
                'delivery_type_id' => $old_data->delivery_type_id,
                'area_id' => $old_data->area_id,
                'count_documents' => $old_data->count_documents,
                'complete_address' => $old_data->complete_address,
                'delivery_remarks' => $old_data->delivery_remarks,
                'date_created' => Carbon::now(),
                'status' => 0,
                'is_transact' => 0,
            ]);






            if ($request->file('file')) {
                $this->uploade_file_transit($request->id, 'AitsDelivery', $request->file('file'), 1);
            }

            AitsDelivery::where('id', $request->id)->update($request->except(['id', 'file']));

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }

}
