<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Tests\TestCase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_obtaining_user_information()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile_test.png',
        ]);

        $product1 = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品1',
            'img_url' => 'sell_product_1.jpeg',
        ]);

        $product2 = Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品2',
            'img_url' => 'sell_product_2.jpeg',
        ]);

        $seller = User::factory()->create();
        $purchaseProduct = Product::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入商品1',
            'img_url' => 'purchase_product_1.jpeg',
        ]);
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $purchaseProduct->id,
            'stripe_session_id' => 'sess_test_001',
            'amount' => 5000,
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');
        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('profile_test.png');

        $responseSell = $this->get('/mypage?page=sell');
        $responseSell->assertStatus(200);

        $responseSell->assertSee('sell_product_1.jpeg');
        $responseSell->assertSee('出品商品1');
        $responseSell->assertSee('sell_product_2.jpeg');
        $responseSell->assertSee('出品商品2');

        $responseSell->assertDontSee($purchaseProduct->name);

        $responseBuy = $this->get('/mypage?page=buy');
        $responseBuy->assertStatus(200);

        $responseBuy->assertSee('purchase_product_1.jpeg');
        $responseBuy->assertSee('購入商品1');

        $responseBuy->assertDontSee($product1->name);
        $responseBuy->assertDontSee($product2->name);
    }
}
