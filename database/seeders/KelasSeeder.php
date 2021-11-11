<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(app()->isLocal()){
            DB::table('kelas')->insert([
                [
                    'name' => 'Al Jahiz',
                ],
                [
                    'name' => 'Al Farizi'
                ],
                [
                    'name' => 'Al Battani'
                ],
                [
                    'name' => 'Al Ghazali'
                ]
            ]);
        }
    }
}
