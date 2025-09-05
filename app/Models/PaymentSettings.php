<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'bank_branch',
        'momo_phone',
        'momo_holder',
        'zalopay_id',
        'zalopay_holder',
        'shopeepay_id',
        'shopeepay_holder',

        'momo_partner_code',
        'momo_access_key',
        'momo_secret_key',
        'momo_callback_url',
        'zalopay_partner_code',
        'zalopay_access_key',
        'zalopay_secret_key',
        'zalopay_callback_url',

        'qr_logo_path',
        'qr_primary_color',
        'qr_secondary_color',
        'qr_show_logo',
        'qr_style',
        'payment_timeout_minutes',
        'bank_enabled',
        'momo_enabled',
        'zalopay_enabled',
        'shopeepay_enabled',

    ];

    protected $casts = [
        'qr_show_logo' => 'boolean',
        'bank_enabled' => 'boolean',
        'momo_enabled' => 'boolean',
        'zalopay_enabled' => 'boolean',
        'shopeepay_enabled' => 'boolean',

        'payment_timeout_minutes' => 'integer',
    ];

    /**
     * Get the first payment settings instance (singleton pattern)
     */
    public static function getSettings()
    {
        return static::first() ?? static::create();
    }

    /**
     * Get QR logo URL
     */
    public function getQrLogoUrlAttribute()
    {
        if ($this->qr_logo_path) {
            return asset('storage/' . $this->qr_logo_path);
        }
        return null;
    }

    /**
     * Get available payment methods
     */
    public function getAvailablePaymentMethods()
    {
        $methods = [];
        
        if ($this->bank_enabled && $this->bank_account_number) {
            $methods['bank'] = [
                'name' => 'Chuyển khoản ngân hàng',
                'icon' => 'bank',
                'description' => 'Chuyển khoản qua ' . $this->bank_name
            ];
        }
        
        if ($this->momo_enabled && $this->momo_phone) {
            $methods['momo'] = [
                'name' => 'MoMo',
                'icon' => 'momo',
                'description' => 'Thanh toán qua MoMo'
            ];
        }
        
        if ($this->zalopay_enabled && $this->zalopay_id) {
            $methods['zalopay'] = [
                'name' => 'ZaloPay',
                'icon' => 'zalopay',
                'description' => 'Thanh toán qua ZaloPay'
            ];
        }
        
        if ($this->shopeepay_enabled && $this->shopeepay_id) {
            $methods['shopeepay'] = [
                'name' => 'ShopeePay',
                'icon' => 'shopeepay',
                'description' => 'Thanh toán qua ShopeePay'
            ];
        }
        

        
        return $methods;
    }

    /**
     * Check if a payment method is enabled and configured
     */
    public function isPaymentMethodEnabled($method)
    {
        switch ($method) {
            case 'bank':
                return $this->bank_enabled && !empty($this->bank_account_number);
            case 'momo':
                return $this->momo_enabled && !empty($this->momo_phone);
            case 'zalopay':
                return $this->zalopay_enabled && !empty($this->zalopay_id);
            case 'shopeepay':
                return $this->shopeepay_enabled && !empty($this->shopeepay_id);

            default:
                return false;
        }
    }

    /**
     * Get payment method details
     */
    public function getPaymentMethodDetails($method)
    {
        switch ($method) {
            case 'bank':
                return [
                    'name' => $this->bank_name,
                    'account_number' => $this->bank_account_number,
                    'account_holder' => $this->bank_account_holder,
                    'branch' => $this->bank_branch,
                ];
            case 'momo':
                return [
                    'phone' => $this->momo_phone,
                    'holder' => $this->momo_holder,
                ];
            case 'zalopay':
                return [
                    'id' => $this->zalopay_id,
                    'holder' => $this->zalopay_holder,
                ];
            case 'shopeepay':
                return [
                    'id' => $this->shopeepay_id,
                    'holder' => $this->shopeepay_holder,
                ];

            default:
                return null;
        }
    }
}
