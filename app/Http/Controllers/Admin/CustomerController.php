<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $customers = $query->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user', // Giữ nguyên role 'user' cho khách hàng
            'status' => $request->status,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Khách hàng đã được tạo thành công');
    }

    /**
     * Display the specified customer
     */
    public function show(User $customer)
    {
        if ($customer->role === 'admin') {
            abort(404);
        }

        // Get customer's recent orders (3 most recent)
        $recentOrders = $customer->orders()->with('items.product')->latest()->take(3)->get();
        
        // Get total orders count for pagination info
        $totalOrders = $customer->orders()->count();
        
        // Calculate total spent (excluding cancelled orders)
        $totalSpent = $customer->orders()->where('status', '!=', 'cancelled')->sum('total');
        
        // Auto-determine customer type based on behavior
        $this->determineCustomerType($customer);

        return view('admin.customers.show', compact('customer', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    /**
     * Determine customer type based on behavior
     */
    private function determineCustomerType(User $customer)
    {
        $totalOrders = $customer->orders()->count();
        $cancelledOrders = $customer->orders()->where('status', 'cancelled')->count();
        $totalSpent = $customer->orders()->where('status', '!=', 'cancelled')->sum('total');
        
        // Calculate cancellation rate
        $cancellationRate = $totalOrders > 0 ? ($cancelledOrders / $totalOrders) * 100 : 0;
        
        $newType = 'regular'; // default
        
        // VIP: Customers with over 100 orders
        if ($totalOrders > 100) {
            $newType = 'vip';
        }
        // Potential: Customers with 50-100 orders
        elseif ($totalOrders > 50 && $totalOrders <= 100) {
            $newType = 'potential';
        }
        // Internal: Customers with 30-50 orders
        elseif ($totalOrders > 30 && $totalOrders <= 50) {
            $newType = 'internal';
        }
        // Frequent canceller: > 50% cancellation rate (override other types)
        elseif ($cancellationRate > 50 && $totalOrders >= 3) {
            $newType = 'frequent_canceller';
        }
        // Regular: Customers with under 30 orders
        else {
            $newType = 'regular';
        }
        
        // Update customer type if it changed
        if ($customer->customer_type !== $newType) {
            $customer->update(['customer_type' => $newType]);
        }
    }

    /**
     * Show all orders for a specific customer
     */
    public function orders(User $customer)
    {
        if ($customer->role === 'admin') {
            abort(404);
        }

        $orders = $customer->orders()->with('items.product')->latest()->paginate(15);

        return view('admin.customers.orders', compact('customer', 'orders'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(User $customer)
    {
        if ($customer->role === 'admin') {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, User $customer)
    {
        if ($customer->role === 'admin') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'customer_type' => 'nullable|in:regular,vip,internal,frequent_canceller,potential',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ];

        if ($request->filled('customer_type')) {
            $data['customer_type'] = $request->customer_type;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Thông tin khách hàng đã được cập nhật');
    }

    /**
     * Remove the specified customer
     */
    public function destroy(User $customer)
    {
        if ($customer->role === 'admin') {
            abort(404);
        }

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Không thể xóa khách hàng đã có đơn hàng');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Khách hàng đã được xóa thành công');
    }

    /**
     * Toggle customer status
     */
    public function toggleStatus(Request $request, User $customer)
    {
        if ($customer->role === 'admin') {
            abort(404);
        }

        // Validate the request
        $request->validate([
            'action' => 'required|in:activate,deactivate',
            'confirmation' => 'required|in:confirmed'
        ]);

        $oldStatus = $customer->status;
        $newStatus = $request->action === 'activate' ? 'active' : 'inactive';

        // Prevent unnecessary updates
        if ($oldStatus === $newStatus) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Trạng thái khách hàng không thay đổi');
        }

        // Update customer status
        $customer->update(['status' => $newStatus]);

        // Log the action
        \Log::info('Customer status changed', [
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'admin_id' => auth()->id(),
            'admin_name' => auth()->user()->name
        ]);

        // Return appropriate message based on action
        if ($newStatus === 'active') {
            $message = 'Tài khoản khách hàng đã được kích hoạt thành công';
        } else {
            $message = 'Tài khoản khách hàng đã được vô hiệu hóa thành công';
        }

        return redirect()->route('admin.customers.index')
            ->with('success', $message);
    }

    /**
     * Show customer statistics
     */
    public function statistics()
    {
        $totalCustomers = User::where('role', '!=', 'admin')->count();
        $activeCustomers = User::where('role', '!=', 'admin')->where('status', 'active')->count();
        $inactiveCustomers = User::where('role', '!=', 'admin')->where('status', 'inactive')->count();
        
        // New customers this month
        $newCustomersThisMonth = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Top customers by order count
        $topCustomers = User::where('role', '!=', 'admin')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        // Customer registration trend (last 6 months)
        $registrationTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::where('role', '!=', 'admin')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            
            $registrationTrend[] = [
                'month' => $month->format('M Y'),
                'count' => $count
            ];
        }

        return view('admin.customers.statistics', compact(
            'totalCustomers',
            'activeCustomers', 
            'inactiveCustomers',
            'newCustomersThisMonth',
            'topCustomers',
            'registrationTrend'
        ));
    }
}
