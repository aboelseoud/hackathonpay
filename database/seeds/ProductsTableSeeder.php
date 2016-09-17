<?php

use Illuminate\Database\Seeder;

use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Candy',
            'price' => 1,
            'description' => str_random(100),
        ]);

        Product::create([
            'name' => 'Cigarettes',
            'price' => 10,
            'description' => str_random(100),
        ]);

        Product::create([
            'name' => 'Toy',
            'price' => 15,
            'description' => str_random(100),
        ]);

        Product::create([
            'name' => 'Burger',
            'price' => 5,
            'description' => str_random(100),
        ]);

        Product::create([
            'name' => 'Book',
            'price' => 14,
            'description' => str_random(100),
        ]);

        Product::create([
            'name' => 'Chips',
            'price' => 1,
            'description' => str_random(100),
        ]);
    }
}
