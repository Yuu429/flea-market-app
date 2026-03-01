<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_email_verification()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_transition_authentication_url()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('認証はこちらから');
        $response->assertSee(route('verification.verify', [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]));
    }

    public function test_authentication_complete_redirect_profile()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $response = $this->actingAs($user)->withSession(['url.intended' => '/mypage/profile'])->get($verificationUrl);

        $response->assertRedirect('/mypage/profile');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
