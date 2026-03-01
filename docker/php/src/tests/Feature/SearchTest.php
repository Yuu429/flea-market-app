<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Like;
use App\Models\Purchase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_partial_match_search()
    {
        $user = User::factory()->create();

        $appleProduct = Product::factory()->create([
            'name' => 'リンゴのコップ',
        ]);
        $bananaProduct = Product::factory()->create([
            'name' => 'バナナのコップ',
        ]);

        $response = $this->actingAs($user)->get('/?keyword=リンゴ');

        $response->assertStatus(200);
        $response->assertSee('リンゴのコップ');
        $response->assertDontSee('バナナのコップ');
    }

    public function test_maintain_search_state()
    {
        $user = User::factory()->create();

        $appleProduct = Product::factory()->create([
            'name' => 'リンゴのコップ',
        ]);
        $bananaProduct = Product::factory()->create([
            'name' => 'バナナのコップ',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $appleProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/?keyword=リンゴ&mylist=1');

        $response->assertStatus(200);
        $response->assertSee('リンゴのコップ');
        $response->assertDontSee('バナナのコップ');
    }
}
