<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class DebugController extends Controller
{
    public function check()
    {
        try {
            $total_products = Product::count();
            $total_categories = Category::count();
            $active_categories = Category::where('is_active', true)->count();
            
            $products = Product::with(['category', 'seller'])->latest()->limit(5)->get();
            
            return response()->json([
                'status' => 'connected',
                'total_products' => $total_products,
                'total_categories' => $total_categories,
                'active_categories' => $active_categories,
                'sample_products' => $products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'category' => $p->category ? $p->category->name : null,
                ]),
                'database_path' => config('database.connections.sqlite.database'),
                'database_exists' => file_exists(config('database.connections.sqlite.database')),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
