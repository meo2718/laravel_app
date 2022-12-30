<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Stock;

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
            UserSeeder::class,
        ]);
        //外部キー制約があるのでcallメソッドの外に置かないとエラーになる
        Product::factory(100)->create();
        Stock::factory(100)->create();
    }
}
