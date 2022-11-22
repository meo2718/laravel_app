<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//クエリビルダ
use Illuminate\Support\Facades\DB;
//暗号化
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('qwer1234'),
            'created_at' => '2022/11/22 23:30:30'
        ]);
    }
}
