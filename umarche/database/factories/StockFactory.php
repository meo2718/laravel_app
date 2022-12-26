<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //stockは外部キー制約でproduct_idをもっている、productfactoryで生成した内容と紐付ける
            //productfactoryから生成した順に登録される
            'product_id' => Product::factory(),
            'type' => $this->faker->numberBetween(1,2),
            'quantity' => $this->faker->randomNumber,
        ];
    }
}
