<?php

namespace Tests\Feature\Kelas;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateKelasTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_screen_can_be_rendered()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.bk')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)->get('/kelas');

        $response->assertSeeText('List Kelas');

        $response->assertStatus(200);
    }

    public function test_create_screen_can_be_rendered()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.bk')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)->get('/kelas/create');

        $response->assertSeeText('Buat Kelas');

        $response->assertStatus(200);
    }

    public function test_kelas_can_be_created()
    {
        $role = Role::firstOrCreate(['name' => config('enums.roles.bk')], []);
        $user = User::factory()->create()->assignRole($role);

        $response = $this->actingAs($user)
            ->post('/kelas', [
                'name' => 'kelas_name'
            ]);

        $response->assertRedirect('/kelas');
    }
}
