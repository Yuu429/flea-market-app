<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tests\TestCase;

class ProfileChangeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_profile_change()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'name' => '初期ユーザー',
            'profile_image' => 'old_image.png',
            'postal_code' => '111-1111',
            'address' => '旧住所',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertSee('value="初期ユーザー"', false);
        $response->assertSee('value="111-1111"', false);
        $response->assertSee('value="旧住所"', false);
        $response->assertSee('value="old_image.png"', false);

        $newImage = UploadedFile::fake()->create('new_image.png', 100);

        $updateDate = [
            'name' => '更新ユーザー',
            'postal_code' => '222-2222',
            'address' => '新住所',
            'profile_image' => $newImage,
        ];

        $responseUpdate = $this->post('/mypage', $updateDate);

        $responseUpdate->assertStatus(200);

        $user->refresh();
        $this->assertEquals('更新ユーザー', $user->name);
        $this->assertEquals('222-2222', $user->postal_code);
        $this->assertEquals('新住所', $user->address);
        Storage::disk('public')->assertExists($user->profile_image);

        $responseProfile = $this->get('/mypage/profile');
        $responseProfile->assertStatus(200);
        $responseProfile->assertSee('更新ユーザー');
        $responseProfile->assertSee('222-2222');
        $responseProfile->assertSee('新住所');
    }
}
