<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'order_number',
        'order_code',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_confirmed_at',
        'payment_failed_at',
        'cancelled_at',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_district',
        'notes',
        'subtotal',
        'discount_amount',
        'promotion_code',
        'shipping_fee',
        'total',
    ];

    protected $casts = [
        'subtotal' => 'decimal:0',
        'shipping_fee' => 'decimal:0',
        'total' => 'decimal:0',
    ];

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalAttribute()
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->total / 25000, 2);
        }
        return number_format($this->total, 0, ',', '.') . 'đ';
    }

    /**
     * Get formatted subtotal price
     */
    public function getFormattedSubtotalAttribute()
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->subtotal / 25000, 2);
        }
        return number_format($this->subtotal, 0, ',', '.') . 'đ';
    }

    /**
     * Get formatted shipping fee
     */
    public function getFormattedShippingFeeAttribute()
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->shipping_fee / 25000, 2);
        }
        return number_format($this->shipping_fee, 0, ',', '.') . 'đ';
    }

    /**
     * Get total amount (alias for total field)
     */
    public function getTotalAmountAttribute()
    {
        return $this->total;
    }

    /**
     * Get reviews for this order
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get payment status badge class
     */
    public function getPaymentStatusBadgeClassAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'pending' => __('app.pending'),
            'processing' => __('app.processing'),
            'shipped' => __('app.shipped'),
            'delivered' => __('app.delivered'),
            'cancelled' => __('app.cancelled'),
            default => __('app.unknown'),
        };
    }

    /**
     * Get payment status display name
     */
    public function getPaymentStatusDisplayAttribute()
    {
        return match($this->payment_status) {
            'pending' => __('app.payment_pending'),
            'processing' => __('app.payment_processing'),
            'paid' => __('app.payment_paid'),
            'failed' => __('app.payment_failed'),
            default => __('app.unknown'),
        };
    }

    /**
     * Get payment method display name
     */
    public function getPaymentMethodDisplayAttribute()
    {
        return match($this->payment_method) {
            'momo' => __('app.momo_wallet'),
            'zalopay' => __('app.zalopay_wallet'),
            'bank_transfer' => __('app.bank_transfer'),
            'cod' => __('app.cash_on_delivery'),
            default => __('app.unknown'),
        };
    }
}