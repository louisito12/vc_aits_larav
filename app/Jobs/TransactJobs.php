<?php

namespace App\Jobs;

use App\Models\Pms_Details;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PmsMailer;

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

                Mail::to('louisitoojide@gmail.com')->send(new PmsMailer($data));
                $record->update(['is_email' => 0]);
            }


            sleep(5);


        }
    }
}
