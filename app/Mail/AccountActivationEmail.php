<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $link;
    public $user;

    public function __construct($link, $user)
    {
        $this->link = $link;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = $this->link;
        $user = $this->user;
        return $this->subject('Aktivasi Akun')->view('mail.account_activation',compact('link', 'user'));
    }
}
