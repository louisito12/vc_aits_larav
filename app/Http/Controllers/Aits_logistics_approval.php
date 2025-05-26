<?php

namespace App\Http\Controllers;

use App\Models\AitsDelivery;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\DepartmentModel;
use Yajra\DataTables\DataTables;

class Aits_logistics_approval extends Controller
{


    public function get_logistics_request()
    {

        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->where('is_transact', 1)
            ->orderBy('procedures', 'asc')
            ->get();
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
                if ($data->status == 0) {
                    return ' <h5> <span class="badge rounded-pill bg-danger">Cancelled</span></h5>';
                }
                $aits_deliver = new Aits_Delivery_Controller();
                return $aits_deliver->status_html($data->request_status, $data->procedures);

            })
            
            ->addColumn('view_file_request', function ($data) {
                $data_file = AitsFileModel::where('table_name', 'AitsDelivery')
                    ->where('procedure', $data->procedures)
                    ->where('status', 1)
                    ->where('attachment_id', $data->id)
                    ->first();
                if (!$data_file) {
                    return '';
                }

                $path = $data_file->folder_name . '/' . $data_file->year . '/' . $data_file->file_name;
                $url = dynamic_file($path);
                return ' <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>';

            })
            ->rawColumns(['action', 'view_file_request', 'req_status'])
            ->make(true);

    }

}
