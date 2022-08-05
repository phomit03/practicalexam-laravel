<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailFromAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $student;    //khai bao 1 bien de get du lieu tu Student

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env("MAIL_FROM_ADDRESS"))    //dia chi email se tra ve
            ->view('mails.mail')
            ->subject("Đay la thu gui mail");   //chủ đề
    }
}
