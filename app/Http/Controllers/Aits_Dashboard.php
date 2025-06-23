<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AitsDelivery;
use Illuminate\Http\Request;
use App\Models\AitsFileModel;
use App\Models\DepartmentModel;
use Yajra\DataTables\DataTables;
use App\Models\AitsShuttleRequest;
use Illuminate\Support\Facades\DB;
use App\Models\AitsRequestRoomModel;
use Illuminate\Support\Facades\Auth;

class Aits_Dashboard extends Controller
{
    public function room_request_dash($params)
    {

        // $roles = DB::table('aits_role_access')
        //     ->where('user_id', Auth::user()->id)
        //     ->where('status', 1)
        //     ->pluck('role_id')
        //     ->toArray();
        $roles = roles_array(Auth::user()->id);

        $data = AitsRequestRoomModel::
            where('is_transact', 1)
            ->where('status', 1);
        if (!in_array(2, $roles)) {
            $data->where('request_by', Auth::user()->id);
        }
        if ($params == 1) {
            $data->where('request_status', 'Pending');
        }
        if ($params == 2 || $params == 3) {
            // $date_ex = '=';
            // if ($params == 3) {
            //     $date_ex = '<';
            // }
            // return Carbon::now()->toDateString();
            $date_ex = $params == 3 ? '<' : '=';
            $data->whereDate('date_to', $date_ex, Carbon::now()->toDateString())
                ->where('request_status', 'Approved');
        }



        $data = $data->get();
        $controller = new Aits_Request_Room_Controller();
        return $controller->room_request_datatable($data);



    }

    public function transit_request_dash($params)
    {

        $roles = roles_array(Auth::user()->id);

        $data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data'])
            // ->where('user_id', Auth::user()->id)->get();
            ->where('is_transact', 1)
            ->where('status', 1);
        if (!in_array(2, $roles)) {
            $data->where('user_id', Auth::user()->id);
        }
        if ($params == 1) {
            $data->where('request_status', 'Pending');
        }
        if ($params == 2 || $params == 3) {
            $date_ex = $params == 3 ? '<' : '=';
            $data->whereDate('appointment_date', $date_ex, Carbon::now()->toDateString())
                ->where('request_status', 'Approved');
        }

        $data = $data->get();

        $controller = new Aits_Transit_Controller();
        return $controller->transit_data_table($data);




    }



    public function aits_dashboard_counts()
    {
        try {

            // $room_request = "
            //     SELECT SUM(CASE WHEN request_status = 'Approved' THEN 1 ELSE 0 END) AS approved_count,
            //     SUM(CASE WHEN request_status = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
            //     COUNT(*) AS total_requests
            //     FROM aits_request_room_models
            //     WHERE request_status IN ('Approved', 'Pending') AND (is_transact=1 AND status=1)
            //     GROUP BY request_status";
            // $shuttle_request = "SELECT SUM(CASE WHEN request_status = 'Approved' THEN 1 ELSE 0 END) AS approved_count,
            // SUM(CASE WHEN request_status = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
            // COUNT(*) AS total_requests FROM aits_shuttle_requests
            // WHERE is_transact = 1 AND status = 1";
            // $shuttle_request = "
            //         SELECT
            //         SUM(CASE WHEN request_status = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
            //         SUM(CASE WHEN request_status = 'Approved' AND appointment_date = CONVERT(VARCHAR, GETDATE(), 23) THEN 1 ELSE 0 END) AS ongoing_count,
            //         SUM(CASE WHEN request_status = 'Approved' AND appointment_date < CAST(GETDATE() AS DATE) THEN 1 ELSE 0 END) AS completed_count
            //         FROM aits_shuttle_requests WHERE (is_transact = 1 AND status = 1) $shuttle_request_id";




            $room_request = "";
            $shuttle_request_id = "";
            $roles = DB::table('aits_role_access')
                ->where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->pluck('role_id')
                ->toArray();
            $user_id = Auth::user()->id;

            if (!in_array(2, $roles)) {
                // $data->where('request_by', Auth::user()->id);
                $room_request = " AND request_by =$user_id";
                $shuttle_request_id = " AND user_id =$user_id";
            }


            $room_request = "SELECT SUM(CASE WHEN request_status = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
            SUM(CASE WHEN request_status = 'Approved' AND CONVERT(VARCHAR(10), date_to, 23) = CONVERT(VARCHAR(10), GETDATE(), 23) THEN 1 ELSE 0 END) AS ongoing_count,
            SUM(CASE WHEN request_status = 'Approved' AND date_to < CAST(GETDATE() AS DATE) THEN 1 ELSE 0 END) AS completed_count
            FROM aits_request_room_models  WHERE (is_transact = 1 AND status = 1) $room_request";


            $shuttle_request = "
            SELECT SUM(CASE WHEN request_status = 'Pending' THEN 1 ELSE 0 END) AS pending_count,
            SUM(CASE WHEN request_status = 'Approved' AND CONVERT(VARCHAR(10), appointment_date, 23) = CONVERT(VARCHAR(10), GETDATE(), 23) THEN 1 ELSE 0 END) AS ongoing_count,
            SUM(CASE WHEN request_status = 'Approved' AND appointment_date  < CAST(GETDATE() AS DATE) THEN 1 ELSE 0 END) AS completed_count
            FROM aits_shuttle_requests WHERE (is_transact = 1  AND status = 1) $shuttle_request_id";


            $logistics_query = "
              SELECT CASE WHEN procedures = 1 THEN 'For Delivery'
              WHEN procedures = 2 THEN 'For Collection' WHEN procedures = 3 THEN 'For Pick Up' 
              END AS procedure_status,SUM(CASE WHEN request_status = 'Pending' AND messenger_id IS NULL THEN 1 ELSE 0 END) AS pending_counts,
	          SUM (CASE WHEN request_status !='Delivered' AND messenger_id IS NOT NULL THEN 1 ELSE 0 END) On_going,
	          SUM(CASE WHEN request_status ='Delivered' THEN 1 ELSE 0 END) Approved FROM aits_deliveries WHERE (is_transact = 1  AND status = 1) $shuttle_request_id GROUP BY procedures ";




            $room_counts = DB::connection('sqlsrv')->select($room_request, )[0];

            $vehicle_counts = DB::connection('sqlsrv')->select($shuttle_request, [
            ])[0];

            $logistics_count = DB::connection('sqlsrv')->select(
                $logistics_query,
                []
            );



            return response()->json([
                'room_request' => $room_counts,
                'vehicle_request' => $vehicle_counts,
                'logistics_request' => $logistics_count,
            ]);



        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }

    }

    public function aits_dashboard_counts_messenger()
    {

        try {

            $user_id = Auth::user()->id;
            $logistics_query = "
              SELECT CASE WHEN procedures = 1 THEN 'For Delivery'
              WHEN procedures = 2 THEN 'For Collection' WHEN procedures = 3 THEN 'For Pick Up' 
              END AS procedure_status,SUM(CASE WHEN request_status = 'Pending' AND messenger_id IS NULL THEN 1 ELSE 0 END) AS pending_counts,
	          SUM (CASE WHEN request_status !='Delivered' AND messenger_id=$user_id THEN 1 ELSE 0 END) On_going,
	          SUM(CASE WHEN request_status ='Delivered' AND messenger_id=$user_id THEN 1 ELSE 0 END) Approved FROM aits_deliveries WHERE (is_transact = 1  AND status = 1)   GROUP BY procedures ";


            $logistics_count = DB::connection('sqlsrv')->select(
                $logistics_query,
                []
            );

            //  var for_delivery = "For Delivery";
            //         // var index = -1;
            //         var for_collection = "For Collection"
            //         // var collection_index = -1;
            //         var for_pick_up = "For Pick Up";
            //         // var pick_up_index = -1;

            // $logistics_count = [
            //     [
            //         'procedure_status' => 'For Delivery',
            //         'pending_counts' => 1,
            //         'On_going' => 2,
            //         'Approved' => 4,

            //     ],

            // [
            //     'procedure_status' => 'For Collection',
            //     'pending_counts' => 1,
            //     'On_going' => 2,
            //     'Approved' => 4,

            // ],

            //     [
            //         'procedure_status' => 'For Pick Up',
            //         'pending_counts' => 1,
            //         'On_going' => 2,
            //         'Approved' => 4,

            //     ],
            // ];



            return response()->json([
                'logistics_request_messenger' => $logistics_count,
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Error, Please Contact ICT department.' . '<br>' . $e->getMessage(),
                'status' => 402,
                "isValid" => false,
            ]);
        }
    }

    public function aits_dashboard_logistics($params, $procedure)
    {


        $roles = roles_array(Auth::user()->id);

        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])
            ->where('procedures', $procedure)
            ->where('status', 1);

        if ($params == 1) {
            $data->where('request_status', 'Pending')->whereNull('messenger_id');
        }

        if ($params == 2) {
            $data->whereNotNull('messenger_id')->whereNot('request_status', 'Delivered');
        }
        if ($params == 3) {
            $data->where('request_status', 'Delivered');
        }

        if (!in_array(2, $roles)) {
            $data->where('user_id', Auth::user()->id);
        }

        $data = $data->get();




        $db_tbl = $this->logistics_datatable($data, $procedure);
        return $db_tbl;



    }


    public function aits_dashboard_logistics_mess($params, $procedure)
    {


        $roles = roles_array(Auth::user()->id);

        $data = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])
            ->where('procedures', $procedure)
            ->where('status', 1);

        if ($params == 1) {
            $data->where('request_status', 'Pending')->whereNull('messenger_id');
        }

        if ($params == 2) {
            $data->where('messenger_id', Auth::user()->id)->whereNot('request_status', 'Delivered');
        }
        if ($params == 3) {
            $data->where('request_status', 'Delivered')->where('messenger_id', Auth::user()->id);
        }

        // if (!in_array(2, $roles)) {
        //     $data->where('user_id', Auth::user()->id);
        // }

        $data = $data->get();




        $db_tbl = $this->logistics_datatable($data, $procedure);
        return $db_tbl;

    }


    public function logistics_datatable($data, $procedure)
    {




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

            ->addColumn('req_status', function ($data) use ($procedure) {
                if ($data->status == 0) {
                    return ' <h5> <span class="badge rounded-pill bg-danger">Cancelled</span></h5>';
                }


                $status_html = new Aits_Delivery_Controller();
                return $status_html->status_html($data->request_status, $procedure, $data->id);

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
                $link = $data_file->file_link;
                $url = dynamic_file($path, $link);
                return ' <a href="' . $url . '" target="_blank" class="">' . htmlspecialchars($data_file->orig_file) . '</a>';

            })
            ->rawColumns(['action', 'view_file_request', 'req_status'])
            ->make(true);

    }
}
