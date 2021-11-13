<?php

namespace Tests\Feature\Presensi;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Course;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePresensiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_presensi_screen_can_be_rendered()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.teacher')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)
            ->get('/presensi');

        $response->assertStatus(200);
    }

    public function test_create_presensi_screen_can_be_rendered()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.teacher')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)
            ->get('/presensi/create');

        $response->assertStatus(200);
    }

    public function test_presensi_can_create()
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

        $this->assertAuthenticated();

        $response->assertRedirect('/presensi');
    }
}
