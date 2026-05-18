<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        // Fetch all active categories
        $categories = Category::where('is_active', true)->get();
        
        // Build the products query with filters
        $query = Product::query();
        
        // Filter by search
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Filter by size
        if ($request->has('size') && $request->size) {
            $query->where('size', $request->size);
        }
        
        // Filter by price
        if ($request->has('price_max') && $request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }
        
        // Apply sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12);
        
        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show($product)
    {
        // For now, return a simple view
        // Later you can add product fetching logic here
        return view('shop.show', [
            'product' => (object) [
                'id' => 1,
                'name' => 'Sample Product',
                'price' => 29.99,
                'description' => 'This is a sample product description.',
            ]
        ]);
    }
}
