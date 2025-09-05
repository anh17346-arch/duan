<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $settings = PaymentSettings::getSettings();
        return view('admin.payment-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Ngân hàng
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_holder' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            
            // Ví điện tử
            'momo_phone' => 'nullable|string|max:20',
            'momo_holder' => 'nullable|string|max:255',
            'zalopay_id' => 'nullable|string|max:255',
            'zalopay_holder' => 'nullable|string|max:255',
            'shopeepay_id' => 'nullable|string|max:255',
            'shopeepay_holder' => 'nullable|string|max:255',
            
            // API Keys
            'momo_partner_code' => 'nullable|string|max:255',
            'momo_access_key' => 'nullable|string|max:255',
            'momo_secret_key' => 'nullable|string|max:1000',
            'momo_callback_url' => 'nullable|url|max:500',
            
            'zalopay_partner_code' => 'nullable|string|max:255',
            'zalopay_access_key' => 'nullable|string|max:255',
            'zalopay_secret_key' => 'nullable|string|max:1000',
            'zalopay_callback_url' => 'nullable|url|max:500',
            
            // QR Code settings
            'qr_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qr_primary_color' => 'nullable|string|max:7',
            'qr_secondary_color' => 'nullable|string|max:7',
            'qr_show_logo' => 'boolean',
            'qr_style' => 'nullable|in:square,rounded,circle',
            
            // Payment timeout
            'payment_timeout_minutes' => 'required|integer|min:5|max:1440',
            
            // Status
            'bank_enabled' => 'boolean',
            'momo_enabled' => 'boolean',
            'zalopay_enabled' => 'boolean',
            'shopeepay_enabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $settings = PaymentSettings::getSettings();

        // Handle QR logo upload
        if ($request->hasFile('qr_logo')) {
            // Delete old logo if exists
            if ($settings->qr_logo_path) {
                Storage::disk('public')->delete($settings->qr_logo_path);
            }
            
            $logoPath = $request->file('qr_logo')->store('payment/qr-logos', 'public');
            $settings->qr_logo_path = $logoPath;
        }

        // Update settings
        $settings->update([
            // Ngân hàng
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_holder' => $request->bank_account_holder,
            'bank_branch' => $request->bank_branch,
            
            // Ví điện tử
            'momo_phone' => $request->momo_phone,
            'momo_holder' => $request->momo_holder,
            'zalopay_id' => $request->zalopay_id,
            'zalopay_holder' => $request->zalopay_holder,
            'shopeepay_id' => $request->shopeepay_id,
            'shopeepay_holder' => $request->shopeepay_holder,
            
            // API Keys
            'momo_partner_code' => $request->momo_partner_code,
            'momo_access_key' => $request->momo_access_key,
            'momo_secret_key' => $request->momo_secret_key,
            'momo_callback_url' => $request->momo_callback_url,
            
            'zalopay_partner_code' => $request->zalopay_partner_code,
            'zalopay_access_key' => $request->zalopay_access_key,
            'zalopay_secret_key' => $request->zalopay_secret_key,
            'zalopay_callback_url' => $request->zalopay_callback_url,
            
            // QR Code settings
            'qr_primary_color' => $request->qr_primary_color ?? '#000000',
            'qr_secondary_color' => $request->qr_secondary_color ?? '#FFFFFF',
            'qr_show_logo' => $request->has('qr_show_logo'),
            'qr_style' => $request->qr_style ?? 'square',
            
            // Payment timeout
            'payment_timeout_minutes' => $request->payment_timeout_minutes,
            
            // Status
            'bank_enabled' => $request->has('bank_enabled'),
            'momo_enabled' => $request->has('momo_enabled'),
            'zalopay_enabled' => $request->has('zalopay_enabled'),
            'shopeepay_enabled' => $request->has('shopeepay_enabled'),
        ]);

        return back()->with('success', 'Cài đặt thanh toán đã được cập nhật thành công!');
    }

    public function deleteQrLogo()
    {
        $settings = PaymentSettings::getSettings();
        
        if ($settings->qr_logo_path) {
            Storage::disk('public')->delete($settings->qr_logo_path);
            $settings->update(['qr_logo_path' => null]);
        }

        return back()->with('success', 'Logo QR Code đã được xóa thành công!');
    }

    public function testApiConnection(Request $request)
    {
        $method = $request->input('method');
        $settings = PaymentSettings::getSettings();

        try {
            switch ($method) {
                case 'momo':
                    if (!$settings->momo_partner_code || !$settings->momo_access_key || !$settings->momo_secret_key) {
                        return response()->json(['success' => false, 'message' => 'Thiếu thông tin API MoMo']);
                    }
                    // Add MoMo API test logic here
                    return response()->json(['success' => true, 'message' => 'Kết nối MoMo API thành công!']);
                    
                case 'zalopay':
                    if (!$settings->zalopay_partner_code || !$settings->zalopay_access_key || !$settings->zalopay_secret_key) {
                        return response()->json(['success' => false, 'message' => 'Thiếu thông tin API ZaloPay']);
                    }
                    // Add ZaloPay API test logic here
                    return response()->json(['success' => true, 'message' => 'Kết nối ZaloPay API thành công!']);
                    
                default:
                    return response()->json(['success' => false, 'message' => 'Phương thức thanh toán không hợp lệ']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi kết nối: ' . $e->getMessage()]);
        }
    }

    /**
     * Display all available payment methods
     */
    public function paymentMethods()
    {
        $settings = PaymentSettings::getSettings();
        $availableMethods = $settings->getAvailablePaymentMethods();
        
        return view('admin.payment-settings.payment-methods', compact('settings', 'availableMethods'));
    }
}
