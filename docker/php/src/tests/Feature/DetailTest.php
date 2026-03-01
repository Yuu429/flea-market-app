<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Comment;
use Tests\TestCase;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_detail_display()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト用の商品説明',
            'condition' => 'good',
            'img_url' => 'test-image.jpg',
        ]);

        $category1 = Category::factory()->create([
            'name' => '家電',
        ]);
        $category2 = Category::factory()->create([
            'name' => 'インテリア',
        ]);
        $product->categories()->attach([$category1->id, $category2->id]);

        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $commentUser = User::factory()->create([
            'name' => 'コメントユーザー',
        ]);
        Comment::factory()->create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);

        $response = $this->actingAs($user)->get('/item/'.$product->id);

        $response->assertStatus(200);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('5,000');
        $response->assertSee('テスト用の商品説明');
        $response->assertSee('良好');
        $response->assertSee('1');
        $response->assertSee('1');
        $response->assertSee('コメントユーザー');
        $response->assertSee('テストコメント');
        $response->assertSee('test-image.jpg');
        $response->assertSee('家電');
        $response->assertSee('インテリア');
    }

    public function test_categories_display()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'マルチカテゴリ商品',
        ]);

        $cat1 = Category::factory()->create([
            'name' => '家電',
        ]);
        $cat2 = Category::factory()->create([
            'name' => 'インテリア',
        ]);
        $product->categories()->attach([
            $cat1->id,
            $cat2->id,
        ]);

        $response = $this->actingAs($user)->get('/item/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee('家電');
        $response->assertSee('インテリア');
    }
}
