<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(app()->isLocal()){
            DB::table('courses')->insert(
                [
                    [
                        'teacher_id' => 1,
                        'kelas_id' => 1,
                        'name' => 'Matematika'
                    ],
                    [
                        'teacher_id' => 2,
                        'kelas_id' => 1,
                        'name' => 'Biologi'
                    ],
                    [
                        'teacher_id' => 1,
                        'kelas_id' => 2,
                        'name' => 'Matematika'
                    ]
                ]
            );
        }
    }
}
