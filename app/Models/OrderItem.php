<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'total' => 'decimal:0',
    ];

    /**
     * Get the order that owns the item
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->price / 25000, 2);
        }
        return number_format($this->price, 0, ',', '.') . 'đ';
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotalAttribute()
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->total / 25000, 2);
        }
        return number_format($this->total, 0, ',', '.') . 'đ';
    }
}