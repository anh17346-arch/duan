<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of payment methods
     */
    public function index(): View
    {
        $paymentMethods = PaymentMethod::ordered()->get();
        
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method
     */
    public function create(): View
    {
        $types = [
            'ewallet' => 'Ví điện tử',
            'bank' => 'Ngân hàng',
            'card' => 'Thẻ tín dụng',
            'crypto' => 'Tiền điện tử',
            'cod' => 'Thanh toán khi nhận hàng',
            'other' => 'Khác'
        ];
        
        return view('admin.payment-methods.create', compact('types'));
    }

    /**
     * Store a newly created payment method
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'type' => 'required|string|in:ewallet,bank,card,crypto,cod,other',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'account_identifier' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
        ]);

        PaymentMethod::create($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Phương thức thanh toán đã được tạo thành công!');
    }

    /**
     * Show the form for editing a payment method
     */
    public function edit(PaymentMethod $paymentMethod): View
    {
        $types = [
            'ewallet' => 'Ví điện tử',
            'bank' => 'Ngân hàng',
            'card' => 'Thẻ tín dụng',
            'crypto' => 'Tiền điện tử',
            'cod' => 'Thanh toán khi nhận hàng',
            'other' => 'Khác'
        ];
        
        return view('admin.payment-methods.edit', compact('paymentMethod', 'types'));
    }

    /**
     * Update the specified payment method
     */
    public function update(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'type' => 'required|string|in:ewallet,bank,card,crypto,cod,other',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'account_identifier' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
        ]);

        $paymentMethod->update($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Phương thức thanh toán đã được cập nhật thành công!');
    }

    /**
     * Remove the specified payment method
     */
    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        // Kiểm tra xem có đơn hàng nào sử dụng phương thức này không
        if ($paymentMethod->orders()->exists()) {
            return redirect()->route('admin.payment-methods.index')
                ->with('error', 'Không thể xóa phương thức thanh toán này vì đã có đơn hàng sử dụng!');
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Phương thức thanh toán đã được xóa thành công!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(PaymentMethod $paymentMethod): RedirectResponse
    {
        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);

        $status = $paymentMethod->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        
        return redirect()->route('admin.payment-methods.index')
            ->with('success', "Phương thức thanh toán đã được {$status} thành công!");
    }
}
