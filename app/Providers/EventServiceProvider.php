<?php

namespace App\Providers;

use App\Events\PengumumanCreatedEvent;
use App\Events\PresensiCreatedEvent;
use App\Events\UserCreateEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\CreatePresensiRecord;
use App\Listeners\SendEmailActivation;
use App\Listeners\SendEmailVerificationNotification;
use App\Listeners\SendPengumumanEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PresensiCreatedEvent::class => [
            CreatePresensiRecord::class
        ],
        UserCreateEvent::class => [
            SendEmailActivation::class
        ],
        PengumumanCreatedEvent::class => [
            SendPengumumanEmail::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
