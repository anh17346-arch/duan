<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'title',
        'message',
        'icon',
        'color',
        'data',
        'action_url',
        'action_text',
        'is_read',
        'is_important',
        'read_at',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'is_important' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Constants for types
    const TYPE_CUSTOMER = 'customer';
    const TYPE_ADMIN = 'admin';

    // Constants for categories
    const CATEGORY_ORDER = 'order';
    const CATEGORY_PAYMENT = 'payment';
    const CATEGORY_PROMOTION = 'promotion';
    const CATEGORY_SYSTEM = 'system';
    const CATEGORY_MARKETING = 'marketing';
    const CATEGORY_SECURITY = 'security';

    // Constants for colors
    const COLOR_BLUE = 'blue';
    const COLOR_GREEN = 'green';
    const COLOR_RED = 'red';
    const COLOR_YELLOW = 'yellow';
    const COLOR_PURPLE = 'purple';
    const COLOR_ORANGE = 'orange';

    // Constants for icons
    const ICON_BELL = 'bell';
    const ICON_SHOPPING_CART = 'shopping-cart';
    const ICON_CREDIT_CARD = 'credit-card';
    const ICON_GIFT = 'gift';
    const ICON_ALERT = 'alert';
    const ICON_CHECK = 'check';
    const ICON_X = 'x';
    const ICON_TRUCK = 'truck';
    const ICON_STAR = 'star';
    const ICON_HEART = 'heart';
    const ICON_USER = 'user';
    const ICON_SHIELD = 'shield';
    const ICON_CLOCK = 'clock';
    const ICON_CHART = 'chart';

    /**
     * Get all users that have this notification
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_notifications')
                    ->withPivot(['is_read', 'read_at', 'is_sent_email', 'email_sent_at', 'is_sent_sms', 'sms_sent_at'])
                    ->withTimestamps();
    }

    /**
     * Get user notifications pivot
     */
    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * Scope for customer notifications
     */
    public function scopeCustomer($query)
    {
        return $query->where('type', self::TYPE_CUSTOMER);
    }

    /**
     * Scope for admin notifications
     */
    public function scopeAdmin($query)
    {
        return $query->where('type', self::TYPE_ADMIN);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for important notifications
     */
    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    /**
     * Scope for active notifications (not expired)
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Check if notification is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if notification is active
     */
    public function isActive(): bool
    {
        return !$this->isExpired();
    }

    /**
     * Get color classes for Tailwind CSS
     */
    public function getColorClassesAttribute(): string
    {
        $colors = [
            self::COLOR_BLUE => 'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-300',
            self::COLOR_GREEN => 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-300',
            self::COLOR_RED => 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300',
            self::COLOR_YELLOW => 'bg-yellow-50 border-yellow-200 text-yellow-800 dark:bg-yellow-900/20 dark:border-yellow-800 dark:text-yellow-300',
            self::COLOR_PURPLE => 'bg-purple-50 border-purple-200 text-purple-800 dark:bg-purple-900/20 dark:border-purple-800 dark:text-purple-300',
            self::COLOR_ORANGE => 'bg-orange-50 border-orange-200 text-orange-800 dark:bg-orange-900/20 dark:border-orange-800 dark:text-orange-300',
        ];

        return $colors[$this->color] ?? $colors[self::COLOR_BLUE];
    }

    /**
     * Get icon classes for Heroicons
     */
    public function getIconClassesAttribute(): string
    {
        $icons = [
            self::ICON_BELL => 'heroicon-o-bell',
            self::ICON_SHOPPING_CART => 'heroicon-o-shopping-cart',
            self::ICON_CREDIT_CARD => 'heroicon-o-credit-card',
            self::ICON_GIFT => 'heroicon-o-gift',
            self::ICON_ALERT => 'heroicon-o-exclamation-triangle',
            self::ICON_CHECK => 'heroicon-o-check-circle',
            self::ICON_X => 'heroicon-o-x-circle',
            self::ICON_TRUCK => 'heroicon-o-truck',
            self::ICON_STAR => 'heroicon-o-star',
            self::ICON_HEART => 'heroicon-o-heart',
            self::ICON_USER => 'heroicon-o-user',
            self::ICON_SHIELD => 'heroicon-o-shield-check',
        ];

        return $icons[$this->icon] ?? $icons[self::ICON_BELL];
    }

    /**
     * Get time ago for display
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get category display name
     */
    public function getCategoryDisplayNameAttribute(): string
    {
        $categories = [
            self::CATEGORY_ORDER => 'Đơn hàng',
            self::CATEGORY_PAYMENT => 'Thanh toán',
            self::CATEGORY_PROMOTION => 'Khuyến mãi',
            self::CATEGORY_SYSTEM => 'Hệ thống',
            self::CATEGORY_MARKETING => 'Marketing',
            self::CATEGORY_SECURITY => 'Bảo mật',
        ];

        return $categories[$this->category] ?? $this->category;
    }

    /**
     * Get type display name
     */
    public function getTypeDisplayNameAttribute(): string
    {
        $types = [
            self::TYPE_CUSTOMER => 'Khách hàng',
            self::TYPE_ADMIN => 'Quản trị viên',
        ];

        return $types[$this->type] ?? $this->type;
    }
}
