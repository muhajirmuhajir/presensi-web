<?php

namespace App\Models;

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

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

}
