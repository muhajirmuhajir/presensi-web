<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Kelas;
use App\Supports\Fcm;
use Illuminate\Support\Str;
use App\Models\PresensiRecord;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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

        $kelas = Kelas::where('id', function ($q) use ($presensi){
            return $q->select('kelas_id')
            ->from('courses')
            ->where('id', $presensi->course_id)
            ->first();
        })->first();

        if($kelas){
            $topic = Str::slug($kelas->name);

            $fcm = new Fcm();
            $fcm->withTopic($topic);
            $fcm->withNotification('Presensi Baru', $kelas->name . ' telah menerbitkan presensi baru');
            $fcm->sendMessage();
        }

    }
}
