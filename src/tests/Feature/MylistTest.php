<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use App\Models\Purchase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_like_only_products()
    {
        $user = User::factory()->create();

        $likedProduct = Product::factory()->create(['name' => 'いいね商品']);
        $notLikedProduct = Product::factory()->create(['name' => '未いいね商品']);

        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/?mylist=1');

        $response->assertStatus(200);

        $response->assertSee('いいね商品');
        $response->assertDontSee('未いいね商品');
    }

    public function test_sold_preview()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'name' => '購入済み商品',
            'price' => 5000,
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $product->price,
        ]);

        $response = $this->actingAs($user)->get('/?mylist=1');

        $response->assertStatus(200);

        $response->assertSee('購入済み商品');
        $response->assertSee('SOLD');
    }

    public function test_uncertified_redirect()
    {
        $response = $this->get('/?mylist=1');

        $response->assertRedirect('/login');
    }
}
