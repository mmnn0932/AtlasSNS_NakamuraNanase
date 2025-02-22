<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //初期ユーザーのデータ
        DB::table('users')->insert([
            'username' => 'Atlas太郎',
            'email' => 'atlas-taro@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
