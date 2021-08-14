<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
                [
                    'name' => 'Car',
                    'description' => 'Cars, Car Parts, etc.',
                ],
                [
                    'name' => 'Electronics',
                    'description' => 'Computers, Headsets, TV, etc.',
                ],
                [
                    'name' => 'Furniture',
                    'description' => 'Table, Chairs, etc.',
                ],
                [
                    'name' => 'Food',
                    'description' => 'Chicken, Pork, etc.',
                ],
                [
                    'name' => 'Sports & Fitness',
                    'description' => 'BasketBall, Volleyball, etc.',
                ],
            ]
        );
    }
}
