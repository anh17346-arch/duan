<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentSettings;

class PaymentSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentSettings::create([
            // Ngân hàng
            'bank_name' => 'Vietcombank',
            'bank_account_number' => '1234567890',
            'bank_account_holder' => 'CÔNG TY TNHH PERFUME LUXURY',
            'bank_branch' => 'Chi nhánh Hà Nội',
            
            // Ví điện tử
            'momo_phone' => '0901234567',
            'momo_holder' => 'Nguyễn Văn A',
            'zalopay_id' => '0901234567',
            'zalopay_holder' => 'Nguyễn Văn A',
            'shopeepay_id' => '0901234567',
            'shopeepay_holder' => 'Nguyễn Văn A',
            
            // API Keys (để trống cho mẫu)
            'momo_partner_code' => null,
            'momo_access_key' => null,
            'momo_secret_key' => null,
            'momo_callback_url' => null,
            
            'zalopay_partner_code' => null,
            'zalopay_access_key' => null,
            'zalopay_secret_key' => null,
            'zalopay_callback_url' => null,
            
            // QR Code settings
            'qr_logo_path' => null,
            'qr_primary_color' => '#000000',
            'qr_secondary_color' => '#FFFFFF',
            'qr_show_logo' => true,
            'qr_style' => 'square',
            
            // Payment timeout
            'payment_timeout_minutes' => 15,
            
            // Status
            'bank_enabled' => true,
            'momo_enabled' => true,
            'zalopay_enabled' => true,
            'shopeepay_enabled' => true,
        ]);
    }
}
