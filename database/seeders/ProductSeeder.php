<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $users = User::all();

        if ($users->isEmpty()) {
            // Create a default seller if no users exist
            $seller = User::create([
                'name' => 'ThriftPlatform Admin',
                'email' => 'admin@thriftplatform.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);
            $users = collect([$seller]);
        }

        $products = [
            [
                'name' => 'Vintage Denim Jacket',
                'description' => 'Classic vintage denim jacket in excellent condition. Perfect for layering and adding a retro touch to any outfit.',
                'price' => 45.00,
                'original_price' => 89.00,
                'size' => 'M',
                'brand' => 'Levi\'s',
                'condition' => 'excellent',
                'is_featured' => true,
                'images' => ['/placeholder.svg?height=400&width=400&query=vintage+denim+jacket']
            ],
            [
                'name' => 'Floral Summer Dress',
                'description' => 'Beautiful floral print summer dress, lightweight and comfortable. Perfect for warm weather.',
                'price' => 32.00,
                'original_price' => 65.00,
                'size' => 'S',
                'brand' => 'Zara',
                'condition' => 'very_good',
                'is_featured' => true,
                'images' => ['/placeholder.svg?height=400&width=400&query=floral+summer+dress']
            ],
            [
                'name' => 'Leather Ankle Boots',
                'description' => 'Genuine leather ankle boots with minimal wear. Comfortable and stylish for everyday wear.',
                'price' => 55.00,
                'original_price' => 120.00,
                'size' => '8',
                'brand' => 'Dr. Martens',
                'condition' => 'good',
                'images' => ['/placeholder.svg?height=400&width=400&query=leather+ankle+boots']
            ],
            [
                'name' => 'Vintage Band T-Shirt',
                'description' => 'Authentic vintage band t-shirt from the 90s. Soft cotton with original graphics.',
                'price' => 28.00,
                'size' => 'L',
                'brand' => 'Vintage',
                'condition' => 'very_good',
                'images' => ['/placeholder.svg?height=400&width=400&query=vintage+band+tshirt']
            ],
            [
                'name' => 'Designer Handbag',
                'description' => 'Pre-owned designer handbag in excellent condition. Comes with authenticity certificate.',
                'price' => 180.00,
                'original_price' => 450.00,
                'brand' => 'Coach',
                'condition' => 'excellent',
                'is_featured' => true,
                'images' => ['/placeholder.svg?height=400&width=400&query=designer+handbag']
            ],
            [
                'name' => 'Wool Sweater',
                'description' => 'Cozy wool sweater perfect for cold weather. Classic design that never goes out of style.',
                'price' => 38.00,
                'original_price' => 75.00,
                'size' => 'M',
                'brand' => 'J.Crew',
                'condition' => 'excellent',
                'images' => ['/placeholder.svg?height=400&width=400&query=wool+sweater']
            ]
        ];

        foreach ($products as $index => $productData) {
            $category = $categories->random();
            $seller = $users->random();

            Product::create(array_merge($productData, [
                'category_id' => $category->id,
                'seller_id' => $seller->id
            ]));
        }
    }
}