<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductImagesSeeder extends Seeder
{
    public function run()
    {
        // Real thrift store images from Unsplash
        $productImages = [
            1 => ['https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop'], // Vintage denim jacket
            2 => ['https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=400&h=400&fit=crop'], // Floral summer dress
            3 => ['https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop'], // Leather ankle boots
            4 => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop'], // Vintage band t-shirt
            5 => ['https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=400&h=400&fit=crop'], // Designer handbag
            6 => ['https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400&h=400&fit=crop'], // Wool sweater
        ];

        foreach ($productImages as $productId => $images) {
            $product = Product::find($productId);
            if ($product) {
                $product->images = json_encode($images);
                $product->save();
                echo "Updated product {$productId}: {$product->name}\n";
            }
        }

        echo "All product images updated successfully!\n";
    }
}
