<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresensiRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PRESENT = 'present';
    public const STATUS_ABSENT = 'absent';

    public const STATUS_ARRAY = [
        self::STATUS_PRESENT,
        self::STATUS_ABSENT,
        self::STATUS_PENDING,
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }


    public static function getListPresensiByUserId($user_id)
    {
        return self::join('presensis as p', 'p.id', 'presensi_records.presensi_id')
            ->join('courses as c', 'c.id', 'p.course_id')
            ->join('users as u', 'u.id', 'c.teacher_id')
            ->join('kelas as k', 'k.id', 'c.kelas_id')
            ->where('presensi_records.student_id', $user_id)
            ->select(
                'presensi_records.id as id',
                DB::raw("CONCAT(c.name, ' - ', k.name) as name"),
                'p.topic as topic',
                'presensi_records.status as status',
                'u.name as teacher_name'
            )->get();
    }

    public static function getDetailPresensiByUserId($user_id, $id)
    {
        return self::join('presensis as p', 'p.id', 'presensi_records.presensi_id')
        ->join('courses as c', 'c.id', 'p.course_id')
        ->join('users as u', 'u.id', 'c.teacher_id')
        ->join('kelas as k', 'k.id', 'c.kelas_id')
        ->where('presensi_records.student_id', $user_id)
        ->where('presensi_records.id', $id)
        ->select(
            'presensi_records.id as id',
            DB::raw("CONCAT(c.name, ' - ', k.name) as name"),
            'p.topic as topic',
            'presensi_records.status as status',
            'u.name as teacher_name',
            'p.question as question',
            'presensi_records.answer as answer',
        )->firstOrFail();
    }

}
