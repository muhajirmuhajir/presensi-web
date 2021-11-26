<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'kelas_id',
        'name'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function students()
    {
        return $this->hasManyThrough(User::class, Kelas::class, 'id', 'kelas_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function fullName()
    {
        return self::join('kelas as k', 'k.id', 'courses.kelas_id')
            ->where('courses.id', $this->id)
            ->select(DB::raw("CONCAT(k.name, ' - ', courses.name ) as name"))->first()->name;
    }
}
