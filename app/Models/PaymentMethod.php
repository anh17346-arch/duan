<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order',
        'config',
        'account_identifier',
        'account_holder',
        'instructions',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'config' => 'array',
    ];

    /**
     * Scope để lấy các phương thức thanh toán đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope để sắp xếp theo thứ tự
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Lấy tất cả phương thức thanh toán đang hoạt động
     */
    public static function getActiveMethods()
    {
        return static::active()->ordered()->get();
    }

    /**
     * Lấy phương thức thanh toán theo code
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Lấy cấu hình theo key
     */
    public function getConfig($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Set cấu hình theo key
     */
    public function setConfig($key, $value)
    {
        $config = $this->config ?? [];
        data_set($config, $key, $value);
        $this->config = $config;
        return $this;
    }

    /**
     * Kiểm tra xem phương thức có được cấu hình đầy đủ không
     */
    public function isConfigured()
    {
        return !empty($this->account_identifier) && !empty($this->account_holder);
    }

    /**
     * Lấy thông tin hiển thị cho khách hàng
     */
    public function getDisplayInfo()
    {
        return [
            'name' => $this->name,
            'icon' => $this->icon,
            'color' => $this->color,
            'description' => $this->description,
            'account_identifier' => $this->account_identifier,
            'account_holder' => $this->account_holder,
            'instructions' => $this->instructions,
        ];
    }

    /**
     * Relationship với đơn hàng
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_method', 'code');
    }
}
