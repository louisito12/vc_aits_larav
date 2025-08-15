<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PmsMailer extends Mailable
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
        $this->subject('This notification is for PMS ' . $this->record['pms_name'])
            ->view('emails.testmail')
            ->markdown('emails.email', ['mail_data' => $this->record]);
      

        // ->markdown('emails.test_mail', ['mail_data' => $this->record]);
    }
}