<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'sender_id',
        'message',
        'is_read',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that belongs to the notification.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the sender user.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}