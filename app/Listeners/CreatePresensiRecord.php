<?php

namespace App\Listeners;

use App\Models\PresensiRecord;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePresensiRecord
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
        $presensi = $event->presensi;

        $students = User::where('kelas_id', function ($q) use ($presensi){
            return $q->select('kelas_id')
            ->from('courses')
            ->where('id', $presensi->course_id)
            ->first();
        })->get();

        foreach ($students as $student){
            PresensiRecord::create(
                [
                    'presensi_id' => $presensi->id,
                    'student_id' => $student->id,
                    'status' => PresensiRecord::STATUS_PENDING
                ]
            );
        }

    }
}
