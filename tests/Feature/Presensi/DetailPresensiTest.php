<?php

namespace Tests\Feature\Presensi;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Course;
use App\Models\Presensi;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetailPresensiTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_presensi_screen_can_be_rendered()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.teacher')], []);
        $user = User::factory()->create()->assignRole($role);
        $kelas = Kelas::factory()->create();
        $course = Course::factory()->create(['teacher_id' => $user->id, 'kelas_id' => $kelas->id]);

        $response = $this->actingAs($user, 'web')
            ->post('presensi', [
                'course_id' => $course->id,
                'topic' => 'topic',
                'question' => 'question',
                'open_date' => now(),
                'close_date' => now()->addHour(1)
            ]);

        $presensi = Presensi::factory()->create(['course_id' => $course->id]);
        $response = $this->actingAs($user)
            ->get('/presensi/'. $presensi->id);

        $response->assertStatus(200);
    }

}
