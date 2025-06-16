<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        // Sample image URLs for different product types
        $sampleImages = [
            'women_clothing' => [
                'products/women_dress_1.jpg',
                'products/women_top_1.jpg',
                'products/women_jacket_1.jpg',
            ],
            'men_clothing' => [
                'products/men_shirt_1.jpg',
                'products/men_jacket_1.jpg',
                'products/men_pants_1.jpg',
            ],
            'accessories' => [
                'products/bag_1.jpg',
                'products/jewelry_1.jpg',
                'products/watch_1.jpg',
            ],
            'shoes' => [
                'products/shoes_1.jpg',
                'products/boots_1.jpg',
                'products/sneakers_1.jpg',
            ]
        ];

        $products = Product::all();

        foreach ($products as $product) {
            // Determine category type
            $categoryName = strtolower($product->category->name ?? 'accessories');
            
            if (str_contains($categoryName, 'women')) {
                $imageType = 'women_clothing';
            } elseif (str_contains($categoryName, 'men')) {
                $imageType = 'men_clothing';
            } elseif (str_contains($categoryName, 'shoe')) {
                $imageType = 'shoes';
            } else {
                $imageType = 'accessories';
            }

            // Assign random images from the category
            $availableImages = $sampleImages[$imageType];
            $productImages = array_slice($availableImages, 0, rand(1, 3));

            $product->images = json_encode($productImages);
            $product->save();
        }
    }
}
