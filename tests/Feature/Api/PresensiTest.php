<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresensiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_presensi()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.student')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)->get('/api/presensi');

        $response->assertStatus(200);
    }
}
