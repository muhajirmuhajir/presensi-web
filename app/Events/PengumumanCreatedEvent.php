<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengumumanCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pengumuman;

    public function __construct($pengumuman)
    {
        $this->pengumuman = $pengumuman;
    }

}
