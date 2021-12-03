<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    public const STATUS_REGISTERED = 1;
    public const STATUS_ACTIVATED = 2;
    public const STATUS_SUSPENDED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kelas_id',
        'image_url',
        'identity_number',
        'phone_number',
        'opening_status',
        'activation_token',
        'activation_expired_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getStatus(): string
    {
        switch ($this->opening_status) {
            case self::STATUS_REGISTERED:
                return 'Aktivasi';
            case self::STATUS_ACTIVATED:
                return 'Aktif';
            case self::STATUS_SUSPENDED:
                return 'Ditangguhkan';
            default:
                return $this->opening_status;
        }
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function class()
    {
        return $this->kelas();
    }
}
