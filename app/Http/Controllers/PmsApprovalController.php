<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pms_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PmsApprovalController extends Controller
{
    public function pms_approval_view()
    {
        return view('pms_page.pms_approval');
    }

    public function get_pms_approval()
    {
        $data = Pms_Details::with(['get_noted_by'])
            ->where('status', 1)
            ->where('pms_status', 'Pending')
            ->get();

        $pms_controller = new Pms_Maintenance_Controller();
        return $pms_controller->pms_datatable($data);

    }

    public function approved_pms($id, $val, $remarks)
    {

        try {

            $stat = 'Approved';
            if ($val == 2) {
                $stat = 'Disapproved';
            }

            $data = Pms_Details::where('id', $id)->update([
                'pms_status' => $stat,
                'approved_by' => Auth::user()->id,
                'approve_remarks' => $remarks,
                'approve_date' => Carbon::now(),
            ]);



            $object = [
                'user_id' => Auth::user()->id,
                'page' => 'PMS Approval',
                'description' => $stat . ' PMS status',
                'table_name' => 'Pms_Details',
                'transact_id' => $id,
                'status' => 1,
                'date_created' => Carbon::now(),
            ];
            insert_audit($object);

            return response()->json([
                'msg' => 'Successfully Provided',
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
}
