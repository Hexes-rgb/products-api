<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = Category::pluck('id')->toArray();

        $productNames = [
            'Wireless Mouse',
            'Mechanical Keyboard',
            'USB-C Cable',
            'Bluetooth Headphones',
            'Laptop Stand',
            'Cotton T-Shirt',
            'Denim Jeans',
            'Running Shoes',
            'Winter Jacket',
            'Baseball Cap',
            'Programming Book',
            'Science Fiction Novel',
            'Cookbook',
            'Travel Guide',
            'Biography',
            'Garden Tools Set',
            'LED Light Bulb',
            'Coffee Maker',
            'Bedding Set',
            'Wall Clock',
            'Yoga Mat',
            'Dumbbells Set',
            'Tennis Racket',
            'Camping Tent',
            'Bicycle Helmet',
            'Board Game',
            'LEGO Set',
            'Action Figure',
            'Puzzle 1000 pieces',
            'Playing Cards',
            'Organic Coffee',
            'Green Tea',
            'Chocolate Box',
            'Honey Jar',
            'Olive Oil',
            'Face Cream',
            'Shampoo',
            'Toothpaste',
            'Vitamin C',
            'Essential Oil Set',
        ];

        foreach ($productNames as $name) {
            Product::create([
                'name' => $name,
                'price' => $faker->randomFloat(2, 5, 999),
                'category_id' => $faker->randomElement($categoryIds),
                'in_stock' => $faker->boolean(80),
                'rating' => $faker->randomFloat(2, 0, 5),
            ]);
        }

        for ($i = 0; $i < 60; $i++) {
            Product::create([
                'name' => $faker->words(rand(2, 4), true),
                'price' => $faker->randomFloat(2, 5, 999),
                'category_id' => $faker->randomElement($categoryIds),
                'in_stock' => $faker->boolean(80),
                'rating' => $faker->randomFloat(2, 0, 5),
            ]);
        }
    }
}
