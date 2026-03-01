<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_submit_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', ['product' => $product->id]), [
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);
    }

    public function test_not_login_cannot_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('comments.store', ['product' => $product->id]), [
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', [
            'comment' => 'テストコメント',
        ]);
    }

    public function test_comment_validation()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', ['product' => $product->id]), [
            'product_id' => $product->id,
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_validation_error_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post(route('comments.store', ['product' => $product->id]), [
            'product_id' => $product->id,
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors('comment');
        $this->assertDatabaseCount('comments', 0);
    }
}
