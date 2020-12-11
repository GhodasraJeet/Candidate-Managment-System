<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetLink extends Mailable
{
    use Queueable, SerializesModels;
    public $email=null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thanks For Registration')->view('welcome',['email'=>$this->email]);
    }
}
