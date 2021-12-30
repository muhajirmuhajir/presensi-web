<?php

namespace App\Jobs;

use App\Mail\PengumumanEmail;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendPengumumanNotification implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $pengumuman;

    public function __construct($user, $pengumuman)
    {
        $this->user = $user;
        $this->pengumuman = $pengumuman;
    }

    public function handle()
    {
        Mail::to($this->user)->send(new PengumumanEmail($this->user, $this->pengumuman));
    }
}
