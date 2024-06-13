<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductaAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_attributes')->insert([
            [
                'product_id' => 1,
                'attribute_name'=> 'color',
                'attribute_value'=> 'red',
            ],
            [
                'product_id' => 1,
                'attribute_name'=> 'size',
                'attribute_value'=> 'xl'
            ],
            [
                'product_id' => 2,
                'attribute_name'=> 'color',
                'attribute_value'=> 'green'
            ],
            [
                'product_id' => 3,
                'attribute_name'=> 'size',
                'attribute_value'=> 'm'
            ],
            [
                'product_id' => 4,
                'attribute_name'=> 'size',
                'attribute_value'=> 'xxl'
            ],
            [
                'product_id' => 5,
                'attribute_name'=> 'color',
                'attribute_value'=> 'white'
            ],
            [
                'product_id' => 5,
                'attribute_name'=> 'size',
                'attribute_value'=> 'xxl'
            ],
        ]);
    }
}
