<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->orders()->with(['items.product'])->latest();
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by payment status if provided
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }
        
        $orders = $query->paginate(10)->withQueryString();
        
        // Get status counts for filter tabs
        $statusCounts = [
            'all' => $user->orders()->count(),
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'processing' => $user->orders()->where('status', 'processing')->count(),
            'shipped' => $user->orders()->where('status', 'shipped')->count(),
            'delivered' => $user->orders()->where('status', 'delivered')->count(),
            'cancelled' => $user->orders()->where('status', 'cancelled')->count(),
        ];
        
        return view('orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        // Make sure user can only see their own orders
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load(['items.product', 'user']);
        
        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        // Make sure user can only cancel their own orders
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        // Only allow cancellation for pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'Không thể hủy đơn hàng đã được xử lý.');
        }

        // Update order status
        $order->update(['status' => 'cancelled']);

        // Restore product stock
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
            $item->product->decrement('sold_count', $item->quantity);
        }

        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    /**
     * Reorder - add order items to cart
     */
    public function reorder(Order $order)
    {
        // Make sure user can only reorder their own orders
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền đặt lại đơn hàng này.');
        }

        $user = Auth::user();
        $addedItems = 0;
        $outOfStockItems = [];

        foreach ($order->items as $item) {
            $product = $item->product;
            
            // Check if product is still available and has stock
            if ($product->status && $product->stock >= $item->quantity) {
                // Check if item already in cart
                $existingCartItem = $user->cart()->where('product_id', $product->id)->first();
                
                if ($existingCartItem) {
                    $newQuantity = $existingCartItem->quantity + $item->quantity;
                    if ($product->stock >= $newQuantity) {
                        $existingCartItem->update(['quantity' => $newQuantity]);
                        $addedItems++;
                    } else {
                        $outOfStockItems[] = $product->name;
                    }
                } else {
                    $user->cart()->create([
                        'product_id' => $product->id,
                        'quantity' => $item->quantity,
                    ]);
                    $addedItems++;
                }
            } else {
                $outOfStockItems[] = $product->name;
            }
        }

        $message = "Đã thêm {$addedItems} sản phẩm vào giỏ hàng.";
        
        if (!empty($outOfStockItems)) {
            $message .= " Một số sản phẩm không còn đủ hàng: " . implode(', ', $outOfStockItems);
        }

        return redirect()->route('cart.index')->with('success', $message);
    }

    /**
     * Download order invoice (if needed)
     */
    public function invoice(Order $order)
    {
        // Make sure user can only download their own invoices
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền tải hóa đơn này.');
        }

        // For now, redirect to order details
        // In the future, this could generate a PDF invoice
        return redirect()->route('orders.show', $order);
    }
}