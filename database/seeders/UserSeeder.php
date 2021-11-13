<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            $teacher = Role::firstOrCreate(['name' => config('enums.roles.teacher')], []);
            $bk = Role::firstOrCreate(['name' => config('enums.roles.bk')],[]);
            $student = Role::firstOrCreate(['name' => config('enums.roles.student')],[]);
            $super_admin = Role::firstOrCreate(['name' => config('enums.roles.super_admin')],[]);

            // teacher
            User::factory()->create(['name' => 'Teacher one', 'email' => 'guru1@email.com'])->assignRole($teacher);
            User::factory()->create(['name' => 'Teacher two', 'email' => 'guru2@email.com'])->assignRole($teacher);

            // bk
            User::factory()->create(['name' => 'Bk one', 'email' => 'bk1@email.com'])->assignRole($bk);
            User::factory()->create(['name' => 'Bk two', 'email' => 'bk2@email.com'])->assignRole($bk);

            // student
            $kelas_ids = Kelas::pluck('id');
            foreach ($kelas_ids as $id) {
                User::factory(10)->create(['kelas_id' => $id])->each(function($user)use ($student){
                    $user->assignRole($student);
                });
            }

            User::factory()->create(['name' => 'Super Admin', 'email' => 'superadmin@email.com'])->assignRole($super_admin);
        }
    }
}
