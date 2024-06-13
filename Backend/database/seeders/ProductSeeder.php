<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => ' Ray-Ban',
                'description' => 'Latest model Ray-Ban with advanced features',
                'price' => '100',
                'image' => 'prod1.jpg',
                'created_at' => now(),
            ],
            [
                'name' => ' Gucci',
                'description' => 'Latest model Gucci with advanced features',
                'price' => '100',
                'image' => 'prod1.jpg',
                'created_at' => now(),
            ],
            [
                'name' => ' Harry Potter',
                'description' => 'The first of the doorstoppers, marks the point where the series really takes off',
                'price' => '100',
                'image' => 'book1.jpg',
                'created_at' => now(),
            ],
            [
                'name' => ' Versace',
                'description' => 'A best-selling Versace is Store',
                'price' => '100',
                'image' => 'prod1.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Oakley',
                'description' => 'Comfortable Oakley available in various sizes',
                'price' => '100',
                'image' => 'prod1.jpg',
                'created_at' => now(),
            ],
        ]);
    }
}
