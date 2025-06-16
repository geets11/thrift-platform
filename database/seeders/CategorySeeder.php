<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => "Women's Clothing",
                'description' => 'Stylish pre-loved clothing for women',
                'image' => '/placeholder.svg?height=300&width=300&query=womens+clothing'
            ],
            [
                'name' => "Men's Clothing",
                'description' => 'Quality second-hand clothing for men',
                'image' => '/placeholder.svg?height=300&width=300&query=mens+clothing'
            ],
            [
                'name' => 'Shoes',
                'description' => 'Pre-owned shoes in great condition',
                'image' => '/placeholder.svg?height=300&width=300&query=vintage+shoes'
            ],
            [
                'name' => 'Accessories',
                'description' => 'Fashion accessories and small items',
                'image' => '/placeholder.svg?height=300&width=300&query=fashion+accessories'
            ],
            [
                'name' => 'Bags & Purses',
                'description' => 'Pre-loved bags, purses, and handbags',
                'image' => '/placeholder.svg?height=300&width=300&query=vintage+bags'
            ],
            [
                'name' => 'Jewelry',
                'description' => 'Beautiful vintage and modern jewelry',
                'image' => '/placeholder.svg?height=300&width=300&query=vintage+jewelry'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}