<?php

namespace App\Jobs;

use App\Models\PmsFiles;
use Carbon\Carbon;
use App\Mail\PmsMailer;
use App\Mail\RequestMail;
use App\Models\AitsNotif;
use App\Models\Pms_Details;
use App\Models\AitsDelivery;
use Illuminate\Bus\Queueable;
use App\Models\AitsShuttleRequest;
use App\Models\AitsRequestRoomModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TransactJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        while (true) {

            $pms_data = PmsFiles::where('status', 1)
                ->whereDate('pms_date', '<', Carbon::now()->toDateString())
                ->where('notif', 0)
                ->get();
            foreach ($pms_data as $pms_datas) {
                $records = Pms_Details::where('status', 1)
                    ->where('pms_status', 'Approved')
                    ->where('id', $pms_datas->pms_id)
                    ->where('is_email', 1)
                    ->first();
                if ($records) {

                    $data = [
                        'pms_name' => $records->pms_name,
                        'pms_description' => $records->pms_description,
                        'date_start' => date_converter_date($records->date_start),
                        'schedule' => ucfirst($records->pms_date_types),
                    ];

                    Mail::to('louie.ojide@valuecarehealth.com')->send(new PmsMailer($data));

                    PmsFiles::where('id', $pms_datas->id)->update(
                        ['notif' => 1]
                    );
                }


            }






            //Room request Emailer

            $request = AitsNotif::where('aits_table', 'aits_request_room_models')
                ->where('notif', 0)
                ->where('status', 1)
                ->get();
            $data_req = [];

            foreach ($request as $req) {

                $aits_data = AitsRequestRoomModel::with(['get_event_data', 'get_room_data', 'get_requestor', 'get_requestor_data'])->find($req->aits_id);


                if ($aits_data) {
                    $number = $aits_data->request_no;
                    $request_number = sprintf('%03d', $number);
                    $req_number = Carbon::parse($aits_data->date_created)->format('Y-m-d') . '-' . $request_number;
                    $date_from = date_converter($aits_data->date_from);
                    $date_to = date_converter($aits_data->date_to);
                    $status = "";
                    if ($req->aits_process == "Request") {
                        $status = 'For Approval';
                    }

                    if ($req->aits_process == "Approved") {
                        $status = 'The Request is Approved';
                    }
                    if ($req->aits_process == "Disapproved") {
                        $status = 'the Request is Disapproved';
                    }


                    $data_req = [
                        'request_no' => $req_number,
                        'requestor' => $aits_data->get_requestor_data->firstname . ' ' . $aits_data->get_requestor_data->lastname,
                        'room_name' => $aits_data->get_room_data->room_name,
                        'event_name' => $aits_data->get_event_data->event,
                        'schedule_from' => $date_from,
                        'schedule_to' => $date_to,
                        'process' => $status,
                        "trans_process" => 1,

                    ];
                    Mail::to('louie.ojide@valuecarehealth.com')->send(new RequestMail($data_req));

                    AitsNotif::where('id', $req->id)->update([
                        'notif' => 1,
                    ]);
                }
            }




            // aits_shuttle_requests
            $transit = AitsNotif::where('aits_table', 'aits_shuttle_requests')
                ->where('notif', 0)
                ->where('status', 1)
                ->get();

            $transit_data = [];

            foreach ($transit as $transits) {



                $transit_data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data'])
                    ->where('id', $transits->aits_id)->first();
                if ($transit_data) {
                    $number = $transit_data->request_no;
                    $request_number = sprintf('%03d', $number);
                    $transit_req_no = Carbon::parse($transit_data->date_created)->format('Y-m-d') . '-' . $request_number;

                    $status = "";
                    if ($transits->aits_process == "Request") {
                        $status = 'For Approval';
                    }

                    if ($transits->aits_process == "Approve") {
                        $status = 'Request is Approved';
                    }

                    if ($transits->aits_process == "Disapprove") {
                        $status = 'Request is Disapproved';
                    }

                    $transit_data = [
                        'requestor' => $transit_data['get_requestor_data']['firstname'] . ' ' . $transit_data['get_requestor_data']['lastname'],
                        'destination' => $transit_data['destination'],
                        'request_number' => $transit_req_no,
                        'appointment_date' => date_converter($transit_data->appointment_date),
                        'date_requested' => date_converter($transit_data->date_created),
                        'remarks' => $transit_data->remarks,
                        'client_name' => $transit_data->client_name,
                        'status' => $status,
                        "trans_process" => 2,
                    ];

                    Mail::to('louie.ojide@valuecarehealth.com')->send(new RequestMail($transit_data));
                    AitsNotif::where('id', $transits->id)->update([
                        'notif' => 1,
                    ]);
                }

            }


            //logistic request

            $request_logistic = AitsNotif::where('aits_table', 'aits_deliveries')
                ->where('notif', 0)
                ->where('status', 1)
                ->get();


            $logistic_data = [];

            foreach ($request_logistic as $email_logistic) {
                $data_log = AitsDelivery::with(['get_area_request', 'get_requestor', 'get_delivery_type', 'get_requestor_fullname'])->where('id', $email_logistic->aits_id)->first();

                if ($data_log) {
                    $number = $data_log->request_no ?: 0;
                    $request_number = sprintf('%03d', $number);
                    $req_number = Carbon::parse($email_logistic->date_created)->format('Y-m-d') . '-' . $request_number;
                    $procedure = $data_log->procedures;

                    if ($procedure == 1) {
                        $stat = 'For Delivery';
                    }
                    if ($procedure == 2) {
                        $stat = 'For Collection';
                    }
                    if ($procedure == 3) {
                        $stat = 'For Pick Up';
                    }

                    $subject = 'Notification for Logisitic Request' . ' ' . $stat . ' Request#' . ' ' . $req_number;

                    $process = "";
                    if ($email_logistic->aits_process == 'Delivered messenger') {
                        $process = $stat . ' ' . 'is completed';
                    }
                    if ($email_logistic->aits_process == 'Request') {
                        $process = 'Request is for Assigning';
                    }

                    if ($email_logistic->aits_process == 'Reschedule messenger') {
                        $process = $stat . ' ' . 'is rescheduled';
                    }
                    $logistic_data = [
                        'requestor' => $data_log['get_requestor_fullname']['firstname'] . ' ' . $data_log['get_requestor_fullname']['lastname'],
                        'request_number' => $req_number,
                        'type' => $data_log['get_delivery_type']['del_type'],
                        'request_for' => $stat,
                        'date_requested' => date_converter($email_logistic->date_created),
                        'area' => $data_log['get_area_request']['area'],
                        'company_name' => $data_log->company_name,
                        'address' => $data_log->complete_address,
                        "trans_process" => 3,
                        'process' => $process,
                        "subject" => $subject,
                    ];


                    Mail::to('louie.ojide@valuecarehealth.com')->send(new RequestMail($logistic_data));
                    AitsNotif::where('id', $email_logistic->id)->update([
                        'notif' => 1,
                    ]);



                }

            }




            //follow up aits logistics
            sleep(5);

        }
    }
}
