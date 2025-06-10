<?php

namespace App\Jobs;

use App\Mail\RequestMail;
use Carbon\Carbon;
use App\Mail\PmsMailer;
use App\Models\AitsNotif;
use App\Models\Pms_Details;
use Illuminate\Bus\Queueable;
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


            $records = Pms_Details::where('is_email', 1)
                ->where('status', 1)
                ->get();

            foreach ($records as $record) {
                $data = [
                    'pms_name' => $record->pms_name,
                    'pms_description' => $record->pms_description,
                    'date_start' => date_converter_date($record->date_start),
                    'schedule' => ucfirst($record->pms_date_types),
                ];

                Mail::to('louie.ojide@valuecarehealth.com')->send(new PmsMailer($data));
                $record->update(['is_email' => 0]);
            }


            $request = AitsNotif::where('aits_table', 'aits_request_room_models')
                ->where('notif', 0)
                ->where('status', 1)
                ->get();
            $data_req = [];

            foreach ($request as $req) {


                $aits_data = AitsRequestRoomModel::with(['get_event_data', 'get_room_data', 'get_requestor', 'get_requestor_data'])->find($req->aits_id);
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
                    'process' => $status

                ];
                Mail::to('louie.ojide@valuecarehealth.com')->send(new RequestMail($data_req));

                AitsNotif::where('id', $req->id)->update([
                    'notif' => 1,
                ]);

            }







            sleep(5);


        }
    }
}
