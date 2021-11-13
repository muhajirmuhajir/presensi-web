<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\KelasSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(
            [
                PermissionSeeder::class,
                KelasSeeder::class,
                CourseSeeder::class,
                UserSeeder::class,
            ]
        );
    }
}
