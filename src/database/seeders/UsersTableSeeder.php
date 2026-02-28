<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => '山田克己',
            'email' => 'sample111@aaa.com',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($user);
        $user = [
            'name' => '岡田俊允',
            'email' => 'sample222@bbb.com',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($user);
        $user = [
            'name' => '永田ののか',
            'email' => 'sample333@ccc.com',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($user);
        $user = [
            'name' => 'アンドリュー・ヨシエ',
            'email' => 'sample444@ddd.com',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($user);
        $user = [
            'name' => '花山薫',
            'email' => 'sample555@eee.com',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($user);
        $user = [
            'name' => '藤原文太',
            'email' => 'sample666@fff.com',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($user);
        $user = [
            'name' => 'ユーザー',
            'email' => 'user@example.com',
            'password' => '$2y$10$wg1o6Bo5oqUIHqtQB8TmhugVjTXwpIIr4HRHekivufY40laDfZVRC',
            'postal_code' => '999-1234',
            'address' => '東京都渋谷区1-1-1'
        ];
        DB::table('users')->insert($user);
    }
}
