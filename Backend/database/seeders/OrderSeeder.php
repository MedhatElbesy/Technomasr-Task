<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'product_id'=> 1,
                'quantity' => 5,
                'created_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_id'=> 2,
                'quantity' => 5,
                'created_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_id'=> 3,
                'quantity' => 5,
                'created_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_id'=> 4,
                'quantity' => 5,
                'created_at' => now(),
            ],
            [
                'user_id' => 1,
                'product_id'=> 5,
                'quantity' => 5,
                'created_at' => now(),
            ],
        ]);
    }
}
