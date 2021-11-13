<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PresensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => 1,
            'topic' => 'topic',
            'open_date' => now(),
            'close_date' => now()->addHour()
        ];
    }
}
