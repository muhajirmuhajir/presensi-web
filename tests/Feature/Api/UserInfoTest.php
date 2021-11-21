<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kelas;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserInfoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_info()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.student')], []);
        $kelas = Kelas::factory()->create();

        $user = User::factory()->create(['kelas_id' => $kelas->id])->assignRole($role);

        $response = $this->actingAs($user)->get('/api/user/info');

        $response->assertStatus(200);
    }
}
