<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Display a listing of products for frontend
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'seller']);
        
        // Remove status filter temporarily to show all products
        // ->where('status', 'active');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->get('category') . '%');
            });
        }

        // Condition filter
        if ($request->filled('condition') && $request->get('condition') !== 'all') {
            $query->where('condition', $request->get('condition'));
        }

        // Price filters
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->get('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->get('price_max'));
        }

        $products = $query->latest()->paginate(12);
        
        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['category', 'seller']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show products by category
     */
    public function byCategory(Category $category)
    {
        $products = Product::with(['category', 'seller'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('products.category', compact('products', 'category'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::with(['category', 'seller'])
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        return view('products.search', compact('products', 'query'));
    }
}
