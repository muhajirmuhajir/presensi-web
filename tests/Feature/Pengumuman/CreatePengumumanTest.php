<?php

namespace Tests\Feature\Pengumuman;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePengumumanTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_pengumuman_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pengumuman');

        $response->assertStatus(200);
    }

    public function test_create_pengumuman_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pengumuman/create');

        $response->assertStatus(200);
    }

    public function test_store_pengumuman()
    {
        $user = User::factory()->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->post('/pengumuman', [
            'title' => 'title',
            'body' => 'body',
            'thumbnail' => $file
        ]);

        $response->assertRedirect('/pengumuman');
    }
}
