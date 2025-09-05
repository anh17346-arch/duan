<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
        'is_verified',
        'is_approved',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    /**
     * Get the user that wrote the review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product being reviewed
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order associated with this review
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the images/videos for this review
     */
    public function images(): HasMany
    {
        return $this->hasMany(ReviewImage::class)->orderBy('sort_order');
    }

    /**
     * Check if review can be edited (within 24 hours)
     */
    public function canBeEdited(): bool
    {
        $editDeadline = $this->created_at->addHours(24);
        return now()->lt($editDeadline);
    }

    /**
     * Get time remaining to edit
     */
    public function getTimeRemainingToEdit(): ?string
    {
        if (!$this->canBeEdited()) {
            return null;
        }

        $editDeadline = $this->created_at->addHours(24);
        $remaining = now()->diff($editDeadline);

        if ($remaining->days > 0) {
            return $remaining->days . ' ngày ' . $remaining->h . ' giờ';
        } elseif ($remaining->h > 0) {
            return $remaining->h . ' giờ ' . $remaining->i . ' phút';
        } else {
            return $remaining->i . ' phút';
        }
    }

    /**
     * Get formatted rating stars
     */
    public function getStarsAttribute(): string
    {
        $stars = '';
        $rating = (float) $this->rating;
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '★'; // Full star
            } elseif ($i - 0.5 <= $rating) {
                $stars .= '★'; // Half star (using full star for better visual)
            } else {
                $stars .= '☆'; // Empty star
            }
        }
        return $stars;
    }

    /**
     * Get rating percentage
     */
    public function getRatingPercentageAttribute(): float
    {
        return ($this->rating / 5) * 100;
    }

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for verified purchases
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for reviews with images
     */
    public function scopeWithImages($query)
    {
        return $query->whereHas('images');
    }

    /**
     * Scope for recent reviews
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
