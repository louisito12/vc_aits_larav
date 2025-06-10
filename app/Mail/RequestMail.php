<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestMail extends Mailable
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
        $this->subject('This notification is for AITS Room Request No #' . $this->record['request_no'])
            ->view('emails.testmail')
            ->markdown('emails.aits_email', ['mail_data' => $this->record]);

        // ->markdown('emails.test_mail', ['mail_data' => $this->record]);
    }
}