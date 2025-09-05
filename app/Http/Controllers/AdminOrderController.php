<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  })
                  ->orWhere('shipping_name', 'like', '%' . $search . '%')
                  ->orWhere('shipping_phone', 'like', '%' . $search . '%');
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(20)->withQueryString();

        // Get statistics for dashboard cards
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::whereIn('status', ['delivered'])->sum('total'),
            'monthly_revenue' => Order::whereIn('status', ['delivered'])
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->sum('total'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $order->status;
        
        $order->update([
            'status' => $request->status,
            'notes' => $request->notes ? ($order->notes . "\n\n" . now()->format('d/m/Y H:i') . " - Admin: " . $request->notes) : $order->notes
        ]);

        // Create notification for order status change
        $notificationService = new \App\Services\NotificationService();
        $notificationService->createOrderNotification($order, $request->status);

        // Log the status change (you can implement activity log later)
        // activity()
        //     ->performedOn($order)
        //     ->causedBy(auth()->user())
        //     ->withProperties([
        //         'old_status' => $oldStatus,
        //         'new_status' => $request->status,
        //         'notes' => $request->notes
        //     ])
        //     ->log('Order status updated');

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đơn hàng đã được cập nhật thành công!'
        ]);
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,processing,paid,failed'
        ]);

        $oldPaymentStatus = $order->payment_status;
        
        $order->update([
            'payment_status' => $request->payment_status
        ]);

        // Create notification for payment status change
        $notificationService = new \App\Services\NotificationService();
        $notificationService->createPaymentNotification($order, $request->payment_status);

        // Log the payment status change (you can implement activity log later)
        // activity()
        //     ->performedOn($order)
        //     ->causedBy(auth()->user())
        //     ->withProperties([
        //         'old_payment_status' => $oldPaymentStatus,
        //         'new_payment_status' => $request->payment_status
        //     ])
        //     ->log('Order payment status updated');

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái thanh toán đã được cập nhật thành công!'
        ]);
    }

    /**
     * Bulk update order status.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $updatedCount = Order::whereIn('id', $request->order_ids)
                            ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => "Đã cập nhật trạng thái cho {$updatedCount} đơn hàng!"
        ]);
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'Mã đơn hàng',
                'Khách hàng',
                'Email',
                'Số điện thoại',
                'Trạng thái',
                'Trạng thái thanh toán',
                'Phương thức thanh toán',
                'Tổng tiền',
                'Ngày tạo'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $order->shipping_phone,
                    $order->status,
                    $order->payment_status,
                    $order->payment_method,
                    number_format($order->total, 0, ',', '.') . 'đ',
                    $order->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get order statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                                  ->whereIn('status', ['delivered'])
                                  ->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
        ];

        return response()->json($stats);
    }
}
