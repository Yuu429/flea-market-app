<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Mockery;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase_completed()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'is_sold' => false,
        ]);

        $purchase = Purchase::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'stripe_session_id' => 'dummy_session',
            'amount' => 1000,
        ]);

        Product::where('id', $product->id)->update([
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'stripe_session_id' => 'dummy_session',
            'amount' => 1000,
        ]);
    }

    public function test_sold_display()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $anotherUser = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $anotherUser->id,
            'is_sold' => false,
            'name' => 'Sold Product',
            'img_url' => 'dummy.png',
        ]);

        $mockSession = (object)[
            'id' => 'sess_123',
            'metadata' => (object)['product_id' => $product->id],
            'amount_total' => 1000,
        ];

        Mockery::mock('alias:Stripe\Checkout\Session')->shouldReceive('retrieve')->with('sess_123')->andReturn($mockSession);

        $response = $this->get('/success?session_id=sess_123');

        $response->assertRedirect('/');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => 1000,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold Product');
        $response->assertSee('SOLD');
    }

    public function test_profile_addition()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => '商品B',
        ]);
        Purchase::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'stripe_session_id' => 'cs_test_456',
            'amount' => 2000,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertSee('商品B');
    }
}
