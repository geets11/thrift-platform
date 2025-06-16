<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum('total_price');

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10'
        ]);

        $quantity = $request->get('quantity', 1);

        if (!$product->is_available) {
            return back()->with('error', 'This item is no longer available.');
        }

        $cartItem = CartItem::where('product_id', $product->id)
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity
            ]);
        } else {
            CartItem::create([
                'session_id' => Auth::check() ? null : session()->getId(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        $this->updateCartCount();

        return back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        $this->updateCartCount();

        return back()->with('success', 'Cart updated!');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        $this->updateCartCount();

        return back()->with('success', 'Item removed from cart!');
    }

    private function getCartItems()
    {
        return CartItem::with('product')
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })
            ->get();
    }

    private function updateCartCount()
    {
        $count = $this->getCartItems()->sum('quantity');
        session(['cart_count' => $count]);
    }
}