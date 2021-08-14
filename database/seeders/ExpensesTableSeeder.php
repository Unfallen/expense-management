<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expenses')->insert(
            [
                [
                    'name' => 'Computer',
                    'description' => 'Brand New Computer Set',
                    'price' => rand(1000, 10000),
                    'category_id' => 2,
                    'user_id' => 1,
                    'photo' => null,
                ],
                [
                    'name' => 'Car Lights',
                    'description' => 'T11 Headlights',
                    'price' => rand(1000, 10000),
                    'category_id' => 1,
                    'user_id' => 1,
                    'photo' => null,
                ],
                [
                    'name' => 'Chicken Joy',
                    'description' => 'Datsun will provide an appealing and sustainable motoring experience to optimistic up-and-coming customers in high-growth markets. Datsun combines Nissan Motor\'s 80 years of Japanese car-making expertise with the nearly century-old Datsun Brand DNA. Datsun vehicles will be Local Products ensured by a Global Brand, and starts sales in India, Indonesia, Russia and South Africa from 2014.',
                    'price' => rand(500, 2000),
                    'category_id' => 4,
                    'user_id' => 1,
                    'photo' => null,
                ],
                [
                    'name' => 'Ball',
                    'description' => 'Spalding Basketball',
                    'price' => rand(1000, 10000),
                    'category_id' => 5,
                    'user_id' => 1,
                    'photo' => null,
                ],
                [
                    'name' => 'Sofa Set',
                    'description' => 'Modern Sala Set',
                    'price' => rand(1000, 10000),
                    'category_id' => 3,
                    'user_id' => 1,
                    'photo' => null,
                ],
                [
                    'name' => 'Refuel',
                    'description' => 'Shell V-Power Gasoline',
                    'price' => rand(1000, 5000),
                    'category_id' => 1,
                    'user_id' => 1,
                    'photo' => null,
                ],
            ]
        );
    }
}
