<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(app()->isLocal()){
            User::factory()->create(['name' => 'Guru one', 'email' => 'guru1@email.com']);
            User::factory()->create(['name' => 'Guru two', 'email' => 'guru2@email.com']);
        }
    }
}
