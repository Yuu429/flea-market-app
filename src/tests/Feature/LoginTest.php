<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect('/');
    }

    public function test_validation_errors()
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }

    public function test_unregistered_errors()
    {
        $response = $this->post('/login', [
            'email' => 'notexist@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
