<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function records()
    {
        return $this->hasMany(PresensiRecord::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function fullName()
    {
        return $this->join('courses as c', 'c.id', 'presensis.course_id')
        ->join('kelas as k', 'k.id', 'c.kelas_id')
        ->where('c.id', $this->course_id)
        ->select(DB::raw("CONCAT(k.name, ' - ', c.name ) as name"))->first()->name;
    }
}
