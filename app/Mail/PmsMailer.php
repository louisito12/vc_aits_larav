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
        $this->subject('test emailer please disregard IT Team :D')
            ->view('emails.testmail')
            ->markdown('emails.email');

        // ->markdown('emails.test_mail', ['mail_data' => $this->record]);
    }
}