<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'active_listings' => Product::where('is_sold', false)->count(),
            'pending_notifications' => Notification::where('is_read', false)->count(),
        ];
        
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recentProducts = Product::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProducts'));
    }

    /**
     * Display the users management page.
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users', compact('users'));
    }

    /**
     * Display the products management page.
     */
    public function products()
    {
        $products = Product::with('user')->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.products', compact('products'));
    }

    /**
     * Display the notifications management page.
     */
    public function notifications()
    {
        $notifications = Notification::with(['user', 'product', 'sender'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);
        
        return view('admin.notifications', compact('notifications'));
    }

    /**
     * Display the settings page.
     */
    public function settings()
    {
        return view('admin.settings');
    }
}