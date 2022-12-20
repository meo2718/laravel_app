<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'パソコン',
                'sort_order' => 1,
            ],
            [
                'name' => 'PCパーツ',
                'sort_order' => 2,
            ],
            [
                'name' => 'PCアクセサリー',
                'sort_order' => 3,
            ],
            ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => 'ノートPC',
                'sort_order' => 1,
                'primary_category_id' => 1
            ],
            [
                'name' => 'デスクトップPC',
                'sort_order' => 2,
                'primary_category_id' => 1
            ],
            [
                'name' => 'モバイルPC',
                'sort_order' => 3,
                'primary_category_id' => 1
            ],
            [
                'name' => '内蔵ドライブ・ストレージ',
                'sort_order' => 4,
                'primary_category_id' => 2
            ],
            [
                'name' => 'CPU',
                'sort_order' => 5,
                'primary_category_id' => 2
            ],
            [
                'name' => '増設メモリ',
                'sort_order' => 6,
                'primary_category_id' => 2
            ],
            ]);
    }
}
