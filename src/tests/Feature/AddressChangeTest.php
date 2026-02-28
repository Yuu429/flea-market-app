<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Tests\TestCase;

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_address_change_display()
    {
        $user = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '旧住所',
        ]);

        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('111-1111');
        $response->assertSee('旧住所');
        $response->assertSee('変更する');

        $response = $this->get("/purchase/address/{$user->id}/product/{$product->id}");
        $response->assertStatus(200);

        $this->patch("/purchase/{$product->id}", [
            'postal_code' => '222-2222',
            'address' => '新住所',
        ]);

        $response = $this->get("/purchase/{$product->id}");

        $response->assertSee('222-2222');
        $response->assertSee('新住所');
    }

    public function test_purchased_product_has_shipping_address()
    {
        $user = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '住所',
        ]);

        $product = Product::factory()->create();

        $this->actingAs($user);

        $session = new \stdClass();
        $session->id = 'sess_test_123';
        $session->amount_total = 8336;
        $session->metadata = new \stdClass();
        $session->metadata->product_id = $product->id;

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $session->metadata->product_id,
            'stripe_session_id' => $session->id,
            'amount' => $session->amount_total,
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'stripe_session_id' => 'sess_test_123',
            'amount' => 8336,
        ]);

        $this->assertDatabaseHas('users', [
            'postal_code' => '111-1111',
            'address' => '住所',
        ]);
    }
}
