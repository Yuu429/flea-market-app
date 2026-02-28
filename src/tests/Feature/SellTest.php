<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sell_product()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $productDate = [
            'name' => 'テスト商品',
            'price' => 8888,
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明です',
            'img_url' => UploadedFile::fake()->create('product.png', 100),
            'condition' => 'good',
            'categories' => [$category1->id, $category2->id],
        ];

        $response = $this->post('/sell/store', $productDate);
        $response->assertStatus(302);

        $product = Product::first();

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'price' => 8888,
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明です',
            'condition' => 'good',
        ]);

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category1->id,
        ]);

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category2->id,
        ]);

        Storage::disk('public')->assertExists($product->img_url);
    }
}
