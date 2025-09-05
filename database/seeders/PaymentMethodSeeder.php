<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'MoMo',
                'code' => 'momo',
                'type' => 'ewallet',
                'description' => 'Thanh toán qua ví MoMo',
                'icon' => 'momo',
                'color' => '#A50064',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'ZaloPay',
                'code' => 'zalopay',
                'type' => 'ewallet',
                'description' => 'Thanh toán qua ví ZaloPay',
                'icon' => 'zalopay',
                'color' => '#0068FF',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'VNPay',
                'code' => 'vnpay',
                'type' => 'ewallet',
                'description' => 'Thanh toán qua VNPay',
                'icon' => 'vnpay',
                'color' => '#0055A4',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Chuyển khoản ngân hàng',
                'code' => 'bank_transfer',
                'type' => 'bank',
                'description' => 'Chuyển khoản qua ngân hàng',
                'icon' => 'bank',
                'color' => '#10B981',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Thanh toán khi nhận hàng',
                'code' => 'cod',
                'type' => 'cod',
                'description' => 'Thanh toán tiền mặt khi nhận hàng',
                'icon' => 'cod',
                'color' => '#F59E0B',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'ShopeePay',
                'code' => 'shopeepay',
                'type' => 'ewallet',
                'description' => 'Thanh toán qua ShopeePay',
                'icon' => 'shopeepay',
                'color' => '#EE4D2D',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'PayPal',
                'code' => 'paypal',
                'type' => 'ewallet',
                'description' => 'Thanh toán qua PayPal',
                'icon' => 'paypal',
                'color' => '#003087',
                'sort_order' => 7,
                'is_active' => false, // Mặc định tắt
            ],
            [
                'name' => 'Stripe',
                'code' => 'stripe',
                'type' => 'card',
                'description' => 'Thanh toán qua thẻ tín dụng/ghi nợ',
                'icon' => 'stripe',
                'color' => '#6772E5',
                'sort_order' => 8,
                'is_active' => false, // Mặc định tắt
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
