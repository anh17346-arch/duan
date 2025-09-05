<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function process(Request $request, $orderId)
    {
        // Find the order
        $order = Order::with(['items.product'])->findOrFail($orderId);
        
        // Check if order is still pending
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Đơn hàng này không thể thanh toán.');
        }
        
        // Get payment method from request or session
        $paymentMethod = $request->get('method', session('payment_method', 'bank_transfer'));
        
        // Generate transaction ID
        $transactionId = 'TXN' . date('YmdHis') . Str::random(6);
        
        // Calculate expiry time (15 minutes from now)
        $expiryTime = Carbon::now()->addMinutes(config('payment.timeout_minutes', 15));
        
        return view('payment.process', compact('order', 'paymentMethod', 'transactionId', 'expiryTime'));
    }
    
    /**
     * Handle payment confirmation
     */
    public function confirm(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,momo,zalopay',
            'transaction_id' => 'required|string',
        ]);
        
        // Check if payment is still valid (not expired)
        $expiryTime = Carbon::parse($order->created_at)->addMinutes(config('payment.timeout_minutes', 15));
        if (Carbon::now()->gt($expiryTime)) {
            return response()->json([
                'success' => false,
                'message' => 'Thời gian thanh toán đã hết hạn.'
            ], 400);
        }
        
        // Update order status based on payment method
        $paymentMethod = $request->payment_method;
        
        if ($paymentMethod === 'bank_transfer') {
            // For bank transfer, set status to 'pending_confirmation'
            $order->update([
                'status' => 'pending_confirmation',
                'payment_method' => $paymentMethod,
                'transaction_id' => $request->transaction_id,
                'payment_confirmed_at' => null,
            ]);
            
            // Clear checkout data from session after successful payment
            session()->forget('checkout_data');
            
            return response()->json([
                'success' => true,
                'message' => 'Đã gửi thông báo cho admin kiểm tra thanh toán.',
                'redirect' => route('orders.show', $order->id)
            ]);
            
        } else {
            // For e-wallets, set status to 'processing'
            $order->update([
                'status' => 'processing',
                'payment_method' => $paymentMethod,
                'transaction_id' => $request->transaction_id,
                'payment_confirmed_at' => Carbon::now(),
            ]);
            
            // Create notification for successful payment
            $notificationService = new \App\Services\NotificationService();
            $notificationService->createPaymentNotification($order, 'success');
            
            // Clear checkout data from session after successful payment
            session()->forget('checkout_data');
            
            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công!',
                'redirect' => route('orders.show', $order->id)
            ]);
        }
    }
    
    /**
     * Handle payment cancellation
     */
    public function cancel(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Update order status to cancelled
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => Carbon::now(),
        ]);

        // Create notification for payment cancellation
        $notificationService = new \App\Services\NotificationService();
        $notificationService->createPaymentNotification($order, 'cancelled');
        
        return redirect()->route('cart.index')
            ->with('success', 'Đã hủy thanh toán đơn hàng.');
    }
    
    /**
     * Handle payment webhook (for MoMo/ZaloPay callbacks)
     */
    public function webhook(Request $request, $paymentMethod)
    {
        // Validate webhook signature
        if (!$this->validateWebhookSignature($request, $paymentMethod)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }
        
        $transactionId = $request->input('transaction_id');
        $order = Order::where('transaction_id', $transactionId)->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        // Update order status based on payment result
        $paymentStatus = $request->input('status');
        
        if ($paymentStatus === 'success') {
            $order->update([
                'status' => 'processing',
                'payment_confirmed_at' => Carbon::now(),
            ]);
                // Update order status based on payment result
        $paymentStatus = $request->input('status');
        
        if ($paymentStatus === 'success') {
            $order->update([
                'status' => 'processing',
                'payment_confirmed_at' => Carbon::now(),
            ]);

            // Create notification for successful payment
            $notificationService = new \App\Services\NotificationService();
            $notificationService->createPaymentNotification($order, 'success');
        } else {
            $order->update([
                'status' => 'payment_failed',
                'payment_failed_at' => Carbon::now(),
            ]);

            // Create notification for failed payment
            $notificationService = new \App\Services\NotificationService();
            $notificationService->createPaymentNotification($order, 'failed');
        }
            // Update order status based on payment result
        $paymentStatus = $request->input('status');
        
        if ($paymentStatus === 'success') {
            $order->update([
                'status' => 'processing',
                'payment_confirmed_at' => Carbon::now(),
            ]);

            // Create notification for successful payment
            $notificationService = new \App\Services\NotificationService();
            $notificationService->createPaymentNotification($order, 'success');
        } else {
            $order->update([
                'status' => 'payment_failed',
                'payment_failed_at' => Carbon::now(),
            ]);

            // Create notification for failed payment
            $notificationService = new \App\Services\NotificationService();
            $notificationService->createPaymentNotification($order, 'failed');
        }
    
        } else {
            $order->update([
                'status' => 'payment_failed',
                'payment_failed_at' => Carbon::now(),
            ]);
        }
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Validate webhook signature
     */
    private function validateWebhookSignature(Request $request, $paymentMethod)
    {
        // This is a placeholder implementation
        // In real implementation, you would validate the signature from MoMo/ZaloPay
        return true;
    }
    
    /**
     * Generate QR code for bank transfer
     */
    public function generateQRCode(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Generate QR code data for bank transfer
        $qrData = [
            'bank_name' => config('payment.bank_name'),
            'account_number' => config('payment.account_number'),
            'account_holder' => config('payment.account_holder'),
            'amount' => $order->total,
            'content' => $order->order_code . ' - ' . $order->customer_name,
        ];
        
        // In real implementation, you would generate actual QR code
        // For now, return the data structure
        return response()->json([
            'success' => true,
            'qr_data' => $qrData,
            'qr_code_url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg=='
        ]);
    }
    
    /**
     * Check payment status
     */
    public function checkStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        return response()->json([
            'success' => true,
            'status' => $order->status,
            'payment_method' => $order->payment_method,
            'transaction_id' => $order->transaction_id,
            'payment_confirmed_at' => $order->payment_confirmed_at,
            'expires_at' => Carbon::parse($order->created_at)->addMinutes(config('payment.timeout_minutes', 15)),
        ]);
    }
}
