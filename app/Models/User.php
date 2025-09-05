<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'name',              // để tương thích nếu có seed/breeze cũ
        'gender',
        'address',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'customer_type',
        'terms_accepted_at',
        'avatar',            // QUAN TRỌNG: cho phép mass-assign avatar
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** Họ tên đầy đủ (fallback về name nếu chưa tách) */
    public function getFullNameAttribute(): string
    {
        $full = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
        return $full !== '' ? $full : (string) ($this->name ?? '');
    }

    /** URL hiển thị avatar */
    public function getAvatarUrlAttribute(): string
    {
        $path = $this->avatar;

        if (is_string($path) && $path !== '' && $path !== null) {
            // Nếu dùng `php artisan storage:link`, Storage::url('avatars/x.png') => /storage/avatars/x.png
            if (Storage::disk('public')->exists($path)) {
                return Storage::url($path);
            }
            // Fallback nhẹ phòng trường hợp file tồn tại vật lý nhưng Storage chưa thấy
            return asset('storage/' . ltrim($path, '/'));
        }

        // Fallback về ảnh mặc định local
        return asset('images/default-avatar.svg');
    }

    // Relationships
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all notifications for this user
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications')
                    ->withPivot(['is_read', 'read_at', 'is_sent_email', 'email_sent_at', 'is_sent_sms', 'sms_sent_at'])
                    ->withTimestamps()
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get notifications appropriate for user role
     */
    public function roleNotifications()
    {
        $query = $this->belongsToMany(Notification::class, 'user_notifications')
                    ->withPivot(['is_read', 'read_at', 'is_sent_email', 'email_sent_at', 'is_sent_sms', 'sms_sent_at'])
                    ->withTimestamps()
                    ->orderBy('created_at', 'desc');
        
        // Filter by user role
        if ($this->role === 'admin') {
            $query->where('type', 'admin');
        } else {
            $query->where('type', 'customer');
        }
        
        return $query;
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->roleNotifications()
                    ->wherePivot('is_read', false)
                    ->count();
    }

    /**
     * Get unread notifications
     */
    public function unreadNotifications()
    {
        return $this->roleNotifications()
                    ->wherePivot('is_read', false);
    }

    /**
     * Get read notifications
     */
    public function readNotifications()
    {
        return $this->roleNotifications()
                    ->wherePivot('is_read', true);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead($notificationId): bool
    {
        return $this->roleNotifications()
                    ->where('notification_id', $notificationId)
                    ->updateExistingPivot($notificationId, [
                        'is_read' => true,
                        'read_at' => now(),
                    ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead(): int
    {
        return $this->roleNotifications()
                    ->wherePivot('is_read', false)
                    ->updateExistingPivot($this->roleNotifications()->pluck('id'), [
                        'is_read' => true,
                        'read_at' => now(),
                    ]);
    }

    // Cart helper methods
    public function getCartItemsCountAttribute(): int
    {
        return $this->cart()->sum('quantity');
    }

    public function getCartTotalAttribute(): int
    {
        return $this->cart()->get()->sum('subtotal');
    }

    public function getCartTotalFormattedAttribute(): string
    {
        if (app()->getLocale() === 'en') {
            return '$' . number_format($this->cart_total / 25000, 2);
        }
        return number_format($this->cart_total, 0, ',', '.') . 'đ';
    }

    public function hasItemsInCart(): bool
    {
        return $this->cart()->exists();
    }

    public function clearCart(): void
    {
        $this->cart()->delete();
    }
}
