<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_like_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson("/item/{$product->id}/like");

        $response->assertStatus(200)->assertJson([
            'liked' => true,
            'likes_count' => 1,
        ]);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_icon_active()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->likes()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$product->id}");

        $response->assertSee('hart-logo_pink.png', false);
    }

    public function test_unlike_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->postJson("/item/{$product->id}/like");

        $response = $this->actingAs($user)->postJson("/item/{$product->id}/like");

        $response->assertJson([
            'liked' => false,
            'likes_count' => 0
        ]);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
