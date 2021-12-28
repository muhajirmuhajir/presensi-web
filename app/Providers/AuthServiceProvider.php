<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Presensi;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('modif-pengumuman', function (User $user, Pengumuman $pengumuman) {
            return $user->id == $pengumuman->user_id;
        });

        Gate::define('modif-kelas', function (User $user){
            return $user->hasRole(config('enums.roles.bk'));
        });

        Gate::define('modif-course', function (User $user){
            return $user->hasRole(config('enums.roles.bk'));
        });

        Gate::define('modif-akun', function (User $user){
            return $user->hasRole(config('enums.roles.bk'));
        });

        Gate::define('create-presensi', function (User $user){
            return $user->hasRole(config('enums.roles.bk')) || $user->hasRole(config('enums.roles.teacher'));
        });

        Gate::define('show-presensi', function (User $user, Presensi $presensi){
            return $user->hasRole(config('enums.roles.bk')) ||$user->id == $presensi->course->teacher_id;
        });

        Gate::define('rekap-presensi', function (User $user, Presensi $presensi){
            return $user->hasRole(config('enums.roles.bk')) ||$user->id == $presensi->course->teacher_id;
        });

        Gate::define('modif-presensi', function (User $user, Presensi $presensi){
            return $user->id == $presensi->course->teacher_id;
        });
    }
}
