<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Mockery;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_products()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_sold_products()
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

    public function test_hidden_user_products()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $myProduct = Product::factory()->create([
            'user_id' => $user->id,
            'name' => 'My Product',
        ]);

        $otherProduct = Product::factory()->create([
            'name' => 'Other Product'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Other Product');

        $response->assertDontSee('My Product');
    }
}
