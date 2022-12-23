<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //DatabaseSeederクラス内で、callメソッドを使用して追加したシードクラスを実行する
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
            ShopSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            //ProductSeeder::class,
            //StockSeeder::class,
        ]);
    }
}
