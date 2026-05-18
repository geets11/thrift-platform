<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    /**
     * Get the user that owns this cart
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this cart
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total price of all items in cart
     */
    public function getTotalPrice()
    {
        return $this->items()->get()->sum(function ($item) {
            return $item->total_price;
        });
    }

    /**
     * Clear all items from cart
     */
    public function clear()
    {
        $this->items()->delete();
    }
}
