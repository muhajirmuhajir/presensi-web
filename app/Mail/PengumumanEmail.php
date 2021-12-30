<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengumumanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pengumuman;

    public function __construct($user, $pengumuman)
    {
        $this->user = $user;
        $this->pengumuman = $pengumuman;
    }

    public function build()
    {
        $user = $this->user;
        $pengumuman = $user->pengumuman;
        return $this->subject('Pengumuman Baru')->view('mail.pengumuman_notification', compact('user', 'pengumuman'));
    }
}
