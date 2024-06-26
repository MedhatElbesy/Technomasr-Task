<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => '2',
                'price' => '180.00',
                'created_at' => now(),
            ],
            [
                'order_id' => 2,
                'product_id' => 1,
                'quantity' => '2',
                'price' => '180.00',
                'created_at' => now(),
            ],
            [
                'order_id' => 3,
                'product_id' => 1,
                'quantity' => '2',
                'price' => '180.00',
                'created_at' => now(),
            ],
            [
                'order_id' => 4,
                'product_id' => 1,
                'quantity' => '2',
                'price' => '180.00',
                'created_at' => now(),
            ],
            [
                'order_id' => 5,
                'product_id' => 1,
                'quantity' => '2',
                'price' => '180.00',
                'created_at' => now(),
            ],
        ]);

    }
}
