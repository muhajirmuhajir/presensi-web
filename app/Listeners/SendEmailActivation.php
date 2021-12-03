<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Mail\AccountActivationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailActivation
{

    public function handle($event)
    {
        $user = $event->user;

        $link = $this->createLinkActivation($user);

        Mail::to($user)->send(new AccountActivationEmail($link));

    }

    public function createLinkActivation($user)
    {
        $token = Str::random(20);
        $user->update([
            'activation_expired_at' => now()->addDay(),
            'activation_token' => $token
        ]);

        return URL::signedRoute('account.activate', $token);
        // return url()->route('account.activate', $token );
    }
}
