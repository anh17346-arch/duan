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
