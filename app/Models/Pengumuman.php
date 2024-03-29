<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumuman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengumumans';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->user();
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
