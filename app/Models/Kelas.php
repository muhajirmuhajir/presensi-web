<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
