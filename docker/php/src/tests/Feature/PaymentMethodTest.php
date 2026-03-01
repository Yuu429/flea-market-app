<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_selected_payment_method()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->withSession([
            'payment_method' => 'card',
        ])->get(route('product.purchase', [
            'item_id' => $product->id,
        ]));

        $response->assertStatus(200);

        $response->assertSee('カード払い');
    }
}
