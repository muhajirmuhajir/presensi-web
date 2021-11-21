<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PengumumanTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_list_pengumuman()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.student')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)->get('/api/pengumuman');

        $response->assertStatus(200);
    }
}
