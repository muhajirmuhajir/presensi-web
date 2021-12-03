<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresensiRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public const STATUS_PENDING = 1;
    public const STATUS_PRESENT = 2;
    public const STATUS_PERMIT = 3;
    public const STATUS_SICK = 4;
    public const STATUS_ABSENT = 5;

    public const STATUS_ARRAY = [
        self::STATUS_PRESENT,
        self::STATUS_ABSENT,
        self::STATUS_PERMIT,
        self::STATUS_SICK,
        self::STATUS_PENDING,
    ];

    public static function parseStatus($id) : string
    {
        switch ($id) {
            case self::STATUS_PENDING:
                return 'Belum Presensi';
            case self::STATUS_PRESENT:
                return 'Hadir';
            case self::STATUS_ABSENT:
                return 'Alpa';
            case self::STATUS_PERMIT:
                return 'Izin';
            case self::STATUS_SICK:
                return 'Sakit';
            default:
                return $id;
        }
    }

    public function statusPresensi() : string
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'Belum Presensi';
            case self::STATUS_PRESENT:
                return 'Hadir';
            case self::STATUS_ABSENT:
                return 'Alpa';
            case self::STATUS_PERMIT:
                return 'Izin';
            case self::STATUS_SICK:
                return 'Sakit';
            default:
                return $this->status;
        }
    }

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
            ->where('close_date', '>', Carbon::now())
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
