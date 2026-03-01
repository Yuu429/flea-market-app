<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            'name' => 'ファッション',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => '家電',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'インテリア',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'レディース',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'メンズ',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'コスメ',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => '本',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'ゲーム',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'スポーツ',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'キッチン',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'ハンドメイド',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'アクセサリー',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'おもちゃ',
        ];
        DB::table('categories')->insert($category);
        $category = [
            'name' => 'べびー・キッズ',
        ];
        DB::table('categories')->insert($category);
    }
}
