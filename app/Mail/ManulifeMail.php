<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManulifeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function build()
    {
        // return $this->subject('Reimbursement Request for Policy Number ' . $this->record['policy_number'] . '|' . 'Transaction Code ' . $this->record['transact_code'])
        // $this->subject('This notification is for PMS ' . $this->record['pms_name'])
        //     ->view('emails.testmail')
        //     ->markdown('emails.email', ['mail_data' => $this->record]);


        $this->subject('Your LOA approval has been canceled, Transact Code' . $this->record['loa_id'])
            ->view('emails.testmail')
            ->markdown('emails.manulife_mail', ['mail_data' => $this->record]);





    }
}