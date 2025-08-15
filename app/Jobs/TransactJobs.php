<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Mail\PmsMailer;
use App\Models\PmsFiles;
use App\Mail\RequestMail;
use App\Models\AitsNotif;
use App\Mail\ManulifeMail;
use App\Models\Pms_Details;
use App\Models\AitsDelivery;
use Illuminate\Bus\Queueable;
use App\Models\AitsRequestCloser;
use App\Models\AitsShuttleRequest;
use Illuminate\Support\Facades\DB;
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

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120; // 2 minutes

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
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
                ->where('notif', 0)
                ->get();
            foreach ($pms_data as $pms_datas) {
                $records = Pms_Details::with(['get_noted_by'])->where('status', 1)
                    ->where('pms_status', 'Approved')
                    ->where('id', $pms_datas->pms_id)
                    ->where('is_email', 1)
                    ->first();
                $pms_start = $pms_datas->pms_date;
                if ($records) {
                    if ($records->pms_notif == 0) {
                        $data = [
                            'pms_name' => $records->pms_name,
                            'pms_description' => $records->pms_description,
                            'date_start' => date_converter_date($records->date_start),
                            'schedule' => ucfirst($records->pms_date_types),
                            'noted_by' => $records['get_noted_by']['firstname'] . ' ' . $records['get_noted_by']['lastname'],
                            'conducted_by' => $records['conducted_by'],
                        ];
                        Mail::to('louie.ojide@valuecarehealth.com')->send(new PmsMailer($data));
                        Pms_Details::where('id', $pms_datas->pms_id)->update(
                            ['pms_notif' => 1]
                        );
                    } else {
                        if ($pms_start < Carbon::now()) {
                            $data = [
                                'pms_name' => $records->pms_name,
                                'pms_description' => $records->pms_description,
                                'date_start' => date_converter_date($records->date_start),
                                'schedule' => ucfirst($records->pms_date_types),
                                'noted_by' => $records['get_noted_by']['firstname'] . ' ' . $records['get_noted_by']['lastname'],
                                'conducted_by' => $records['conducted_by'],
                            ];
                            Mail::to('louie.ojide@valuecarehealth.com')->send(new PmsMailer($data));
                            PmsFiles::where('id', $pms_datas->id)->update(
                                ['notif' => 1]
                            );
                        }
                    }


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
                    $is_cancel = 0;
                    $cancel_rem = "";
                    $cancel_by_name = "";
                    if ($req->aits_process == "Cancell_request") {
                        $status = "Request is Cancelled";
                        $is_cancel = 1;
                        $cancel_by = get_person_fname($req->cancelled_by);

                        $cancel_by_name = $cancel_by['firstname'] . ' ' . $cancel_by['lastname'];
                        $cancel_rem = $req->remarks;

                    }
                    $event_name = $aits_data->remarks;
                    if ($aits_data->get_event_data) {
                        $event_name = $aits_data->get_event_data->event;
                    }


                    $data_req = [
                        'request_no' => $req_number,
                        'requestor' => $aits_data->get_requestor_data->firstname . ' ' . $aits_data->get_requestor_data->lastname,
                        'room_name' => $aits_data->get_room_data->room_name,
                        'event_name' => $event_name,
                        'schedule_from' => $date_from,
                        'schedule_to' => $date_to,
                        'process' => $status,
                        "trans_process" => 1,
                        "is_cancel" => $is_cancel,
                        'cancel_by' => $cancel_by_name,
                        'cancel_remarks' => $cancel_rem,

                    ];
                    Mail::to(['johnpaultanion001@gmail.com', 'louisitoojide@gmail.com', 'louie.ojide@valuecarehealth.com'])->send(new RequestMail($data_req));

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
                $transit_data = AitsShuttleRequest::with(['get_event_data', 'get_requestor', 'get_requestor_data', 'get_car_data', 'get_driver_data'])
                    ->where('id', $transits->aits_id)->first();
                if ($transit_data) {
                    $number = $transit_data->request_no;
                    $request_number = sprintf('%03d', $number);
                    $transit_req_no = Carbon::parse($transit_data->date_created)->format('Y-m-d') . '-' . $request_number;

                    $status = "";
                    if ($transits->aits_process == "Request") {
                        $status = 'For Approval';
                    }

                    $driver = "";
                    $vehicle = "";
                    $app_remarks = "";
                    $is_approve = 0;
                    if ($transits->aits_process == "Approve") {
                        $status = 'Request is Approved';
                        $driver_data = get_person_fname($transit_data->driver_id);
                        $driver = $driver_data['firstname'] . ' ' . $driver_data['lastname'];
                        $vehicle = $transit_data['get_car_data']['plate_number'];
                        $is_approve = 1;
                        $app_remarks = $transits->remarks;
                    }

                    if ($transits->aits_process == "Disapprove") {
                        $status = 'Request is Disapproved';
                    }

                    // if ($transit->ats_process == "Approve_driver") {
                    //     $status = 'Email for Driver';
                    // }

                    $is_cancel = 0;
                    $cancel_rem = "";
                    $cancel_by_name = "";
                    if ($transits->aits_process == "Cancell_request") {
                        $status = "Request is Cancelled";
                        $is_cancel = 1;
                        $cancel_by = get_person_fname($transits->cancelled_by);
                        $cancel_by_name = $cancel_by['firstname'] . ' ' . $cancel_by['lastname'];
                        $cancel_rem = $transits->remarks;
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
                        "is_cancel" => $is_cancel,
                        'cancel_by' => $cancel_by_name,
                        'cancel_remarks' => $cancel_rem,
                        'driver' => $driver,
                        'vehicle' => $vehicle,
                        'is_approve' => $is_approve,
                        'app_remarks' => $app_remarks,
                    ];

                    Mail::to(['lousitoojide@gmail.com', 'louie.ojide@valuecarehealth.com'])->send(new RequestMail($transit_data));
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
                        $process = 'Request is for ' . $stat;
                    }

                    if ($email_logistic->aits_process == 'Reschedule messenger') {
                        $process = $stat . ' ' . 'is rescheduled';
                    }
                    $is_cancel = 0;
                    $cancel_rem = "";
                    $cancel_by_name = "";
                    if ($email_logistic->aits_process == "Cancell_request") {
                        $process = "Request is Cancelled";
                        $is_cancel = 1;
                        $cancel_by = get_person_fname($email_logistic->cancelled_by);

                        $cancel_by_name = $cancel_by['firstname'] . ' ' . $cancel_by['lastname'];
                        $cancel_rem = $email_logistic->remarks;
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
                        "is_cancel" => $is_cancel,
                        'cancel_by' => $cancel_by_name,
                        'cancel_remarks' => $cancel_rem,
                    ];


                    Mail::to(['lousitoojide@gmail.com', 'louie.ojide@valuecarehealth.com'])->send(new RequestMail($logistic_data));
                    AitsNotif::where('id', $email_logistic->id)->update([
                        'notif' => 1,
                    ]);



                }

            }







            $closer_data = AitsRequestCloser::where('status', 1)->first();

            if ($closer_data) {
                $date_end = $closer_data->date_end;
                $date_now = carbon::now()->format('Y-m-d H:i:s.v');
                $date_yes = Carbon::parse($date_end)->format('Y-m-d H:i:s.v');


                $closer_id = $closer_data->id;
                if ($closer_data->initial_notif == 0) {
                    $value = 1;
                    $message = 'Announcement that for Vehicle Request is Closed fo this time Frame.';
                    $emailer_data = [
                        'message' => $message,
                        'date_from' => date_converter($closer_data->date_from),
                        'date_to' => date_converter($closer_data->date_end),
                        "trans_process" => 10,
                        "is_cancel" => 0,

                    ];



                    AitsRequestCloser::where('id', $closer_id)->update([
                        'initial_notif' => 1,
                    ]);

                    Mail::to(['lousitoojide@gmail.com', 'louie.ojide@valuecarehealth.com'])->send(new RequestMail($emailer_data));

                }

                if ($closer_data->initial_notif == 1) {
                    if ($date_now > $date_yes) {
                        $message = 'Announcement that for Vehicle Reqeust is now Open For request.';
                        $value = 1;

                        $emailer_data = [
                            'message' => $message,
                            'date_from' => date_converter($closer_data->date_from),
                            'date_to' => date_converter($closer_data->date_end),
                            "trans_process" => 10,
                            "is_cancel" => 0,

                        ];

                        AitsRequestCloser::where('id', $closer_id)->update([
                            'status' => 0,
                            'notif' => 1,
                        ]);


                        Mail::to(['lousitoojide@gmail.com', 'louie.ojide@valuecarehealth.com'])->send(new RequestMail($emailer_data));



                    }




                }




            }





            // $closer_data = AitsRequestCloser::where('status', 1)->get();
            // foreach ($closer_data as $closer_datas) {
            //     //    "trans_process" => 10,
            //     $emailer_data = [
            //         'appointment_date' => date_converter($transit_data->appointment_date),
            //         'date_requested' => date_converter($transit_data->date_created),.
            //             "trans_process" => 10,
            //     ];
            // }



            $manulife_emailers = DB::connection('manulife_conn')
                ->table('loa_cancel_emailer')
                ->where('notif', 0)->get();

            foreach ($manulife_emailers as $manulife_emailer) {

                $availment_type = "";
                $send_to = ['louie.ojide@valuecarehealth.com'];
                $get_request_data = DB::connection('manulife_conn')
                    ->table('Manulife_Availment')
                    ->where('Transaction_Code', $manulife_emailer->loa_id)->first();
                $email_rec = 'no_email';
                if ($get_request_data) {
                    if ($get_request_data->member_email != null) {
                        // $send_to[] = $get_request_data->member_email;
                        $email_rec = $get_request_data->member_email;
                    }


                    $manulife_id = $get_request_data->HealthID;
                    $requestor_name = '';
                    $get_member_data = DB::connection('manulife_conn')
                        ->table('Member_data')
                        ->where(
                            'HealthID',
                            $manulife_id
                        )->first();

                    if ($get_member_data) {
                        $requestor_name = $get_member_data->InsuredFirstName . ' ' . $get_member_data->InsuredLastName;
                    }



                    if ($get_request_data->Availment_type == 'EIP') {
                        $availment_type = 'Elective - In Patient';
                    }
                    if ($get_request_data->Availment_type == 'OPS') {
                        $availment_type = 'Elective - Special Procedure';
                    }
                    if ($get_request_data->Availment_type == 'OP') {
                        $availment_type = 'Out Patient';
                    }
                    if ($get_request_data->Availment_type == 'ACU') {
                        $availment_type = 'Out Patient';
                    }

                    $mailer_obs = [
                        'loa_id' => $manulife_emailer->loa_id,
                        'type_request' => $availment_type,
                        'cancellation_date' => date_converter($manulife_emailer->date_created),
                        'reason_cancellation' => $manulife_emailer->remarks,
                        'requestor' => $requestor_name,
                        'emailer' => $email_rec,

                    ];

                    $mail_manulife = Mail::to(['louie.ojide@valuecarehealth.com'])->send(new ManulifeMail($mailer_obs));
                    if ($mail_manulife) {

                        $update = DB::connection('manulife_conn')
                            ->table('loa_cancel_emailer')
                            ->where('id', $manulife_emailer->id)->update([
                                    'notif' => 1,
                                ]);


                    }




                }

            }



            sleep(120);

        }
    }
}
