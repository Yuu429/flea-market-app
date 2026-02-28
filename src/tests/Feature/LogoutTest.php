<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_logout()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/login');
    }
}
