<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'discount_percentage',
        'quantity',
        'sold_quantity',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'quantity' => 'integer',
        'sold_quantity' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relationship với Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope để lấy các khuyến mãi đang hoạt động
     */
    public function scopeActive(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }

    /**
     * Scope để lấy các khuyến mãi sắp diễn ra
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('start_date', '>', $now);
    }

    /**
     * Scope để lấy các khuyến mãi đã kết thúc
     */
    public function scopeExpired(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('end_date', '<', $now);
    }

    /**
     * Kiểm tra xem khuyến mãi có đang hoạt động không
     */
    public function isActive(): bool
    {
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    /**
     * Kiểm tra xem khuyến mãi có sắp diễn ra không
     */
    public function isUpcoming(): bool
    {
        $now = Carbon::now();
        return $this->start_date > $now;
    }

    /**
     * Kiểm tra xem khuyến mãi có đã kết thúc không
     */
    public function isExpired(): bool
    {
        $now = Carbon::now();
        return $this->end_date < $now;
    }

    /**
     * Tính giá sau khi giảm giá
     */
    public function calculateDiscountedPrice(float $originalPrice): float
    {
        $discountAmount = ($originalPrice * $this->discount_percentage) / 100;
        return $originalPrice - $discountAmount;
    }

    /**
     * Lấy trạng thái khuyến mãi dạng text
     */
    public function getStatusTextAttribute(): string
    {
        if ($this->isActive()) {
            return 'Đang hoạt động';
        } elseif ($this->isUpcoming()) {
            return 'Sắp diễn ra';
        } else {
            return 'Đã kết thúc';
        }
    }

    /**
     * Lấy màu sắc cho trạng thái
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->isActive()) {
            return 'green';
        } elseif ($this->isUpcoming()) {
            return 'blue';
        } else {
            return 'gray';
        }
    }

    /**
     * Format ngày bắt đầu
     */
    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date->format('d/m/Y H:i');
    }

    /**
     * Format ngày kết thúc
     */
    public function getFormattedEndDateAttribute(): string
    {
        return $this->end_date->format('d/m/Y H:i');
    }

    /**
     * Format phần trăm giảm giá
     */
    public function getFormattedDiscountAttribute(): string
    {
        return number_format($this->discount_percentage, 1) . '%';
    }

    /**
     * Kiểm tra xem khuyến mãi có còn số lượng không
     */
    public function hasAvailableQuantity(): bool
    {
        // Nếu quantity = 0, có nghĩa là không giới hạn số lượng
        if ($this->quantity == 0) {
            return true;
        }
        
        return $this->sold_quantity < $this->quantity;
    }

    /**
     * Lấy số lượng còn lại
     */
    public function getRemainingQuantityAttribute(): int
    {
        if ($this->quantity == 0) {
            return -1; // Không giới hạn
        }
        
        return max(0, $this->quantity - $this->sold_quantity);
    }

    /**
     * Tăng số lượng đã bán
     */
    public function incrementSoldQuantity(int $amount = 1): bool
    {
        // Nếu quantity = 0, không giới hạn số lượng
        if ($this->quantity == 0) {
            $this->increment('sold_quantity', $amount);
            return true;
        }

        // Kiểm tra xem còn đủ số lượng không
        if ($this->sold_quantity + $amount <= $this->quantity) {
            $this->increment('sold_quantity', $amount);
            return true;
        }

        return false;
    }

    /**
     * Kiểm tra xem khuyến mãi có đang hoạt động và còn số lượng không
     */
    public function isActiveAndAvailable(): bool
    {
        return $this->isActive() && $this->hasAvailableQuantity();
    }

    /**
     * Scope để lấy các khuyến mãi đang hoạt động và còn số lượng
     */
    public function scopeActiveAndAvailable(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now)
                    ->where(function($q) {
                        $q->where('quantity', 0) // Không giới hạn số lượng
                          ->orWhereRaw('sold_quantity < quantity'); // Còn số lượng
                    });
    }
}
