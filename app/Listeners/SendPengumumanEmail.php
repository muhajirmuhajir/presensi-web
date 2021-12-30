<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendPengumumanNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;

class SendPengumumanEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $pengumuman = $event->pengumuman;
        $course_id = $pengumuman->course_id;

        if($course_id){
            $course =  Course::find($course_id);
            if(!$course){
                Log::error('course not found');
                return;
            }

            $users = User::where('kelas_id', $course->kelas_id)->get();

            $this->sendEmail($users, $pengumuman);

        }else{
            $users = User::whereHas('roles', function($q){
                $q->where('name', config('enums.roles.student'));
            })->get();

            $this->sendEmail($users, $pengumuman);
        }
    }

    public function sendEmail($users, $pengumuman)
    {
        $jobs = [];
        foreach ($users as $user) {
            $jobs[] = new SendPengumumanNotification($user, $pengumuman);
        }

        Bus::batch($jobs)->dispatch();
    }
}
