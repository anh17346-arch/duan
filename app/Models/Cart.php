<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getSubtotalAttribute(): int
    {
        return $this->product->final_price * $this->quantity;
    }

    public function getSubtotalFormattedAttribute(): string
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->subtotal / 25000, 2);
        }
        return number_format($this->subtotal, 0, ',', '.') . 'đ';
    }

    // Helper methods
    public function increaseQuantity(int $amount = 1): bool
    {
        if ($this->product->hasStock($this->quantity + $amount)) {
            $this->increment('quantity', $amount);
            return true;
        }
        return false;
    }

    public function decreaseQuantity(int $amount = 1): bool
    {
        if ($this->quantity > $amount) {
            $this->decrement('quantity', $amount);
            return true;
        }
        return false;
    }

    public function updateQuantity(int $quantity): bool
    {
        if ($this->product->hasStock($quantity)) {
            $this->update(['quantity' => $quantity]);
            return true;
        }
        return false;
    }
}
