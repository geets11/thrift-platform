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
        // Clear existing products to avoid constraint violations
        Product::truncate();

        // Create test users if they don't exist
        $seller = User::firstOrCreate(
            ['email' => 'seller@thriftplatform.com'],
            [
                'name' => 'ThriftPlatform Seller',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'seller'
            ]
        );

        $users = collect([$seller]);

        // Products organized by category
        $productsByCategory = [
            "Women's Clothing" => [
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
                    'name' => 'Wool Sweater',
                    'description' => 'Cozy wool sweater perfect for cold weather. Classic design that never goes out of style.',
                    'price' => 38.00,
                    'original_price' => 75.00,
                    'size' => 'M',
                    'brand' => 'J.Crew',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=wool+sweater']
                ],
                [
                    'name' => 'Black Leather Pants',
                    'description' => 'Stylish black leather pants in great condition. Perfect for both casual and formal occasions.',
                    'price' => 55.00,
                    'original_price' => 120.00,
                    'size' => 'M',
                    'brand' => 'Hugo Boss',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=black+leather+pants']
                ],
                [
                    'name' => 'Vintage Blazer',
                    'description' => 'Classic vintage blazer with timeless style. Perfect for professional and casual wear.',
                    'price' => 42.00,
                    'original_price' => 95.00,
                    'size' => 'S',
                    'brand' => 'Ralph Lauren',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=vintage+blazer']
                ]
            ],
            "Men's Clothing" => [
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
                    'name' => 'Vintage Band T-Shirt',
                    'description' => 'Authentic vintage band t-shirt from the 90s. Soft cotton with original graphics.',
                    'price' => 28.00,
                    'size' => 'L',
                    'brand' => 'Vintage',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=vintage+band+tshirt']
                ],
                [
                    'name' => 'Oxford Button-Up Shirt',
                    'description' => 'Crisp Oxford button-up shirt in classic style. Great for work or casual wear.',
                    'price' => 25.00,
                    'original_price' => 55.00,
                    'size' => 'L',
                    'brand' => 'Brooks Brothers',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=oxford+shirt']
                ],
                [
                    'name' => 'Chinos Pants',
                    'description' => 'Comfortable chinos in neutral color. Versatile for various occasions.',
                    'price' => 32.00,
                    'original_price' => 70.00,
                    'size' => '32',
                    'brand' => 'Banana Republic',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=chinos+pants']
                ]
            ],
            'Shoes' => [
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
                    'name' => 'Running Sneakers',
                    'description' => 'Comfortable running sneakers with cushioned sole. Lightly used, perfect condition.',
                    'price' => 48.00,
                    'original_price' => 110.00,
                    'size' => '9',
                    'brand' => 'Nike',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=running+sneakers']
                ],
                [
                    'name' => 'Vintage Loafers',
                    'description' => 'Classic vintage loafers in burgundy. Perfect for preppy style.',
                    'price' => 35.00,
                    'original_price' => 80.00,
                    'size' => '7',
                    'brand' => 'Gucci',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=vintage+loafers']
                ],
                [
                    'name' => 'Leather Oxford Shoes',
                    'description' => 'Formal leather oxford shoes. Perfect for business or special occasions.',
                    'price' => 60.00,
                    'original_price' => 150.00,
                    'size' => '10',
                    'brand' => 'Allen Edmonds',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=oxford+shoes']
                ]
            ],
            'Accessories' => [
                [
                    'name' => 'Silk Scarf',
                    'description' => 'Beautiful silk scarf with classic pattern. Perfect for adding elegance to any outfit.',
                    'price' => 18.00,
                    'original_price' => 45.00,
                    'brand' => 'Hermès',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=silk+scarf']
                ],
                [
                    'name' => 'Leather Belt',
                    'description' => 'Classic leather belt in black. Timeless accessory for any wardrobe.',
                    'price' => 22.00,
                    'original_price' => 55.00,
                    'brand' => 'Coach',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=leather+belt']
                ],
                [
                    'name' => 'Vintage Sunglasses',
                    'description' => 'Retro-style sunglasses with UV protection. Great for sunny days.',
                    'price' => 28.00,
                    'original_price' => 65.00,
                    'brand' => 'Ray-Ban',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=vintage+sunglasses']
                ],
                [
                    'name' => 'Wool Beanie',
                    'description' => 'Cozy wool beanie perfect for winter. Available in multiple colors.',
                    'price' => 15.00,
                    'original_price' => 35.00,
                    'brand' => 'The North Face',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=wool+beanie']
                ]
            ],
            'Bags & Purses' => [
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
                    'name' => 'Canvas Tote Bag',
                    'description' => 'Spacious canvas tote bag. Perfect for work, school, or shopping.',
                    'price' => 25.00,
                    'original_price' => 60.00,
                    'brand' => 'L.L.Bean',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=canvas+tote+bag']
                ],
                [
                    'name' => 'Leather Crossbody Bag',
                    'description' => 'Stylish leather crossbody bag with adjustable strap. Great for travel.',
                    'price' => 65.00,
                    'original_price' => 150.00,
                    'brand' => 'Fossil',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=leather+crossbody+bag']
                ],
                [
                    'name' => 'Vintage Leather Briefcase',
                    'description' => 'Professional vintage leather briefcase. Ideal for business professionals.',
                    'price' => 95.00,
                    'original_price' => 250.00,
                    'brand' => 'Samsonite',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=vintage+briefcase']
                ]
            ],
            'Jewelry' => [
                [
                    'name' => 'Gold Chain Necklace',
                    'description' => 'Elegant gold chain necklace. Perfect for everyday wear or special occasions.',
                    'price' => 45.00,
                    'original_price' => 120.00,
                    'brand' => 'Tiffany & Co.',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=gold+necklace']
                ],
                [
                    'name' => 'Vintage Pearl Earrings',
                    'description' => 'Classic pearl stud earrings. Timeless and elegant.',
                    'price' => 38.00,
                    'original_price' => 95.00,
                    'brand' => 'Vintage',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=pearl+earrings']
                ],
                [
                    'name' => 'Silver Ring',
                    'description' => 'Beautiful sterling silver ring with simple design. Size 7.',
                    'price' => 25.00,
                    'original_price' => 60.00,
                    'brand' => 'Pandora',
                    'condition' => 'very_good',
                    'images' => ['/placeholder.svg?height=400&width=400&query=silver+ring']
                ],
                [
                    'name' => 'Vintage Bracelet',
                    'description' => 'Ornate vintage bracelet with intricate details. Collector\'s item.',
                    'price' => 55.00,
                    'original_price' => 140.00,
                    'brand' => 'Cartier',
                    'condition' => 'excellent',
                    'images' => ['/placeholder.svg?height=400&width=400&query=vintage+bracelet']
                ]
            ]
        ];

        // Create products for each category
        foreach ($productsByCategory as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                foreach ($products as $productData) {
                    Product::create(array_merge($productData, [
                        'category_id' => $category->id,
                        'seller_id' => $users->random()->id,
                        'is_available' => true,
                        'status' => 'active'
                    ]));
                }
            }
        }
    }
}
