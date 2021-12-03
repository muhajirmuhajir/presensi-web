<?php

namespace App\Supports;

use Illuminate\Support\Facades\Http;

class Fcm {
    private $headers;
    private $data = [];

    function __construct() {
        $this->headers = [
            'Authorization' => 'key='.config('firebase.server_key'),
            'Content-Type' => 'application/json',
        ];

        $this->data['priority'] = 'high';
    }

    public function withTopic(string $topic)
    {
        $this->data['to']=  '/topics/'.$topic;
        return $this;
    }

    public function withRegistrationIds(array $ids = [])
    {
        $this->data['registration_ids'] = $ids;
        return $this;
    }

    public function withNotification(string $title, string $body)
    {
        $this->data['notification']['title'] =  $title;
        $this->data['notification']['body'] = $body;
    }

    public function sendMessage()
    {
        return Http::withHeaders($this->headers)
        ->post(config('firebase.fcm_url'), $this->data);
    }


}
