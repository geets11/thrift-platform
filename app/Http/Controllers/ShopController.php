<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        // For now, return a simple view
        // Later you can add product fetching logic here
        return view('shop.index', [
            'products' => collect([]), // Empty collection for now
            'categories' => collect([]), // Empty collection for now
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