<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $baseUrl = 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/';
        $files = [
            'Armani+Mens+Clock.jpg',
            'HDD+Hard+Disk.jpg',
            'iLoveIMG+d.jpg',
            'Leather+Shoes+Product+Photo.jpg',
            'Living+Room+Laptop.jpg',
            'Music+Mic+4632231.jpg',
            'Purse+fashion+pocket.jpg',
            'Tumbler+souvenir.jpg',
            'Waitress+with+Coffee+Grinder.jpg',
            '外出メイクアップセット.jpg',
        ];

        foreach ($files as $file) {
            $url = $baseUrl . $file;

            $image = Http::get($url)->body();

            Storage::disk('public')->put('img_url/' . $file, $image);
        }

        $product = [
            'user_id' => 7,
            'name' => '腕時計',
            'price'=> 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'img_url' => 'img_url/Armani+Mens+Clock.jpg',
            'condition' => 'good',
            'is_sold' => 1,
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 7,
            'name' => 'HDD',
            'price'=> 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'img_url' => 'img_url/HDD+Hard+Disk.jpg',
            'condition' => 'excellent',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 2,
            'name' => '玉ねぎ３束',
            'price'=> 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'img_url' => 'img_url/iLoveIMG+d.jpg',
            'condition' => 'fair',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 3,
            'name' => '革靴',
            'price'=> 4000,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'img_url' => 'img_url/Leather+Shoes+Product+Photo.jpg',
            'condition' => 'poor',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 1,
            'name' => 'ノートPC',
            'price'=> 8000,
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'img_url' => 'img_url/Living+Room+Laptop.jpg',
            'condition' => 'good',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 4,
            'name' => 'マイク',
            'price'=> 8000,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'img_url' => 'img_url/Music+Mic+4632231.jpg',
            'condition' => 'excellent',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 4,
            'name' => 'ショルダーバッグ',
            'price'=> 3500,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'img_url' => 'img_url/Purse+fashion+pocket.jpg',
            'condition' => 'fair',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 5,
            'name' => 'タンブラー',
            'price'=> 500,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'img_url' => 'img_url/Tumbler+souvenir.jpg',
            'condition' => 'poor',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 6,
            'name' => 'コーヒーミル',
            'price'=> 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'img_url' => 'img_url/Waitress+with+Coffee+Grinder.jpg',
            'condition' => 'good',
        ];
        DB::table('products')->insert($product);
        $product = [
            'user_id' => 2,
            'name' => 'メイクセット',
            'price'=> 2500,
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'img_url' => 'img_url/外出メイクアップセット.jpg',
            'condition' => 'excellent',
        ];
        DB::table('products')->insert($product);
    }
}
