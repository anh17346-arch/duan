<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        // Lấy tham số filter từ request
        $period = $request->get('period', 'month'); // day, week, month, year
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Chuyển đổi string thành Carbon object nếu cần
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        // 1. Doanh thu theo thời gian
        $revenueData = $this->getRevenueData($period, $startDate, $endDate);
        
        // 2. Thống kê theo phương thức thanh toán
        $paymentStats = $this->getPaymentStatistics($startDate, $endDate);
        
        // 3. Tỷ lệ đơn hàng theo trạng thái
        $orderStatusStats = $this->getOrderStatusStatistics($startDate, $endDate);
        
        // 4. Top sản phẩm bán chạy
        $topProducts = $this->getTopProducts($startDate, $endDate);
        
        // 5. Top khách hàng mua nhiều nhất
        $topCustomers = $this->getTopCustomers($startDate, $endDate);
        
        // 6. Tổng quan
        $overview = $this->getOverview($startDate, $endDate);

        return view('admin.analytics.index', compact(
            'revenueData',
            'paymentStats', 
            'orderStatusStats',
            'topProducts',
            'topCustomers',
            'overview',
            'period',
            'startDate',
            'endDate'
        ));
    }

    public function showExportOptions(Request $request): View
    {
        // Lấy tham số filter từ request
        $period = $request->get('period', 'month');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Chuyển đổi string thành Carbon object nếu cần
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        return view('admin.analytics.export-options', compact(
            'period',
            'startDate',
            'endDate'
        ));
    }

    private function getRevenueData(string $period, Carbon $startDate, Carbon $endDate): array
    {
        $query = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        switch ($period) {
            case 'day':
                $data = $query->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total) as revenue')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;
            case 'week':
                $data = $query->selectRaw('YEARWEEK(created_at) as week, COUNT(*) as orders, SUM(total) as revenue')
                    ->groupBy('week')
                    ->orderBy('week')
                    ->get();
                break;
            case 'month':
                $data = $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as orders, SUM(total) as revenue')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
                break;
            case 'year':
                $data = $query->selectRaw('YEAR(created_at) as year, COUNT(*) as orders, SUM(total) as revenue')
                    ->groupBy('year')
                    ->orderBy('year')
                    ->get();
                break;
            default:
                $data = collect();
        }

        return [
            'labels' => $data->pluck($period === 'day' ? 'date' : ($period === 'week' ? 'week' : ($period === 'month' ? 'month' : 'year'))),
            'revenue' => $data->pluck('revenue'),
            'orders' => $data->pluck('orders'),
            'data' => $data
        ];
    }

    private function getPaymentStatistics(Carbon $startDate, Carbon $endDate): array
    {
        // Lấy tất cả phương thức thanh toán đang hoạt động
        $paymentMethods = \App\Models\PaymentMethod::getActiveMethods();
        
        // Lấy thống kê từ đơn hàng thực tế
        $orderStats = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment_method, COUNT(*) as orders, SUM(total) as revenue')
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        $methods = [];
        $orders = [];
        $revenue = [];
        $percentages = [];
        
        $totalOrders = $orderStats->sum('orders');
        
        // Duyệt qua tất cả phương thức thanh toán
        foreach ($paymentMethods as $method) {
            $methods[] = $method->name;
            
            // Lấy số liệu từ đơn hàng thực tế (nếu có)
            $orderData = $orderStats->get($method->code);
            $orderCount = $orderData ? $orderData->orders : 0;
            $orderRevenue = $orderData ? $orderData->revenue : 0;
            
            $orders[] = $orderCount;
            $revenue[] = $orderRevenue;
            
            // Tính phần trăm
            $percentage = $totalOrders > 0 ? round(($orderCount / $totalOrders) * 100, 1) : 0;
            $percentages[] = $percentage;
        }

        return [
            'methods' => $methods,
            'orders' => $orders,
            'revenue' => $revenue,
            'percentages' => $percentages,
            'total_orders' => $totalOrders,
            'total_revenue' => $orderStats->sum('revenue')
        ];
    }

    private function getOrderStatusStatistics(Carbon $startDate, Carbon $endDate): array
    {
        $stats = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $totalOrders = $stats->sum('count');

        return [
            'statuses' => $stats->pluck('status')->map(function($status) {
                return $this->translateOrderStatus($status);
            }),
            'counts' => $stats->pluck('count'),
            'percentages' => $stats->map(function ($item) use ($totalOrders) {
                return $totalOrders > 0 ? round(($item->count / $totalOrders) * 100, 1) : 0;
            }),
            'total_orders' => $totalOrders
        ];
    }

    private function getTopProducts(Carbon $startDate, Carbon $endDate, int $limit = 10): array
    {
        $products = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('products.name, SUM(order_items.quantity) as total_quantity, SUM(order_items.quantity * order_items.price) as total_revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();

        return [
            'names' => $products->pluck('name'),
            'quantities' => $products->pluck('total_quantity'),
            'revenues' => $products->pluck('total_revenue')
        ];
    }

    private function getTopCustomers(Carbon $startDate, Carbon $endDate, int $limit = 10): array
    {
        $customers = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('user_id, COUNT(*) as orders, SUM(total) as total_spent')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->limit($limit)
            ->get();

        // Get user names
        $userIds = $customers->pluck('user_id');
        $users = User::whereIn('id', $userIds)->pluck('name', 'id');
        
        return [
            'names' => $customers->map(function($customer) use ($users) {
                return $users->get($customer->user_id, 'Unknown User');
            }),
            'orders' => $customers->pluck('orders'),
            'spent' => $customers->pluck('total_spent')
        ];
    }

    private function getOverview(Carbon $startDate, Carbon $endDate): array
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate]);
        
        $totalOrders = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total');
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'delivered')->count();
        
        // Tính tỷ lệ thành công
        $successRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0;
        
        // Tính doanh thu trung bình mỗi đơn hàng
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 0) : 0;

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'success_rate' => $successRate,
            'avg_order_value' => $avgOrderValue
        ];
    }

    public function export(Request $request)
    {
        // Lấy tham số filter từ request
        $period = $request->get('period', 'month');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        $format = $request->get('format', 'pdf'); // Mặc định là pdf thay vì excel

        // Chuyển đổi string thành Carbon object nếu cần
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        // Lấy dữ liệu
        $revenueData = $this->getRevenueData($period, $startDate, $endDate);
        $paymentStats = $this->getPaymentStatistics($startDate, $endDate);
        $orderStatusStats = $this->getOrderStatusStatistics($startDate, $endDate);
        $topProducts = $this->getTopProducts($startDate, $endDate);
        $topCustomers = $this->getTopCustomers($startDate, $endDate);
        $overview = $this->getOverview($startDate, $endDate);

        // Tạo tên file
        $fileName = 'revenue_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.' . ($format === 'pdf' ? 'pdf' : 'csv');

        if ($format === 'pdf') {
            // Xuất PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('admin.analytics.export-pdf', compact(
                'revenueData',
                'paymentStats',
                'orderStatusStats', 
                'topProducts',
                'topCustomers',
                'overview',
                'startDate',
                'endDate'
            ));
            
            return $pdf->download($fileName);
        } else {
            // Xuất CSV đơn giản thay vì Excel
            $csvData = $this->generateCsvData($revenueData, $paymentStats, $orderStatusStats, $topProducts, $topCustomers, $overview, $startDate, $endDate);
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];
            
            return response($csvData, 200, $headers);
        }
    }
    
    private function generateCsvData($revenueData, $paymentStats, $orderStatusStats, $topProducts, $topCustomers, $overview, $startDate, $endDate)
    {
        $csv = "\xEF\xBB\xBF"; // UTF-8 BOM để Excel đọc tiếng Việt đúng
        
        // Header tổng quan
        $csv .= "BÁO CÁO DOANH THU\n";
        $csv .= "Thời gian: " . $startDate->format('d/m/Y') . " - " . $endDate->format('d/m/Y') . "\n\n";
        
        // Tổng quan
        $csv .= "TỔNG QUAN\n";
        $csv .= "Chỉ số,Giá trị\n";
        $csv .= "Tổng đơn hàng," . $overview['total_orders'] . "\n";
        $csv .= "Tổng doanh thu," . number_format($overview['total_revenue'], 0, ',', '.') . " VNĐ\n";
        $csv .= "Đơn hàng đang xử lý," . $overview['pending_orders'] . "\n";
        $csv .= "Đơn hàng đã hoàn thành," . $overview['completed_orders'] . "\n";
        $csv .= "Tỷ lệ thành công," . $overview['success_rate'] . "%\n";
        $csv .= "Giá trị đơn hàng trung bình," . number_format($overview['avg_order_value'], 0, ',', '.') . " VNĐ\n\n";
        
        // Doanh thu theo thời gian
        $csv .= "DOANH THU THEO THỜI GIAN\n";
        $csv .= "Thời gian,Số đơn hàng,Doanh thu\n";
        foreach ($revenueData['data'] as $item) {
            $time = $item->date ?? $item->month ?? $item->year ?? $item->week;
            $csv .= $time . "," . $item->orders . "," . number_format($item->revenue, 0, ',', '.') . " VNĐ\n";
        }
        $csv .= "\n";
        
        // Phương thức thanh toán
        $csv .= "PHƯƠNG THỨC THANH TOÁN\n";
        $csv .= "Phương thức,Số đơn hàng,Doanh thu\n";
        foreach ($paymentStats['methods'] as $index => $method) {
            $csv .= $method . "," . $paymentStats['orders'][$index] . "," . number_format($paymentStats['revenue'][$index], 0, ',', '.') . " VNĐ\n";
        }
        $csv .= "\n";
        
        // Trạng thái đơn hàng
        $csv .= "TRẠNG THÁI ĐƠN HÀNG\n";
        $csv .= "Trạng thái,Số lượng,Tỷ lệ\n";
        foreach ($orderStatusStats['statuses'] as $index => $status) {
            $csv .= $status . "," . $orderStatusStats['counts'][$index] . "," . $orderStatusStats['percentages'][$index] . "%\n";
        }
        $csv .= "\n";
        
        // Top sản phẩm
        $csv .= "TOP SẢN PHẨM\n";
        $csv .= "Thứ hạng,Tên sản phẩm,Số lượng bán,Doanh thu\n";
        foreach ($topProducts['names'] as $index => $name) {
            $csv .= ($index + 1) . "," . $name . "," . $topProducts['quantities'][$index] . "," . number_format($topProducts['revenues'][$index], 0, ',', '.') . " VNĐ\n";
        }
        $csv .= "\n";
        
        // Top khách hàng
        $csv .= "TOP KHÁCH HÀNG\n";
        $csv .= "Thứ hạng,Tên khách hàng,Số đơn hàng,Tổng chi tiêu\n";
        foreach ($topCustomers['names'] as $index => $name) {
            $csv .= ($index + 1) . "," . $name . "," . $topCustomers['orders'][$index] . "," . number_format($topCustomers['spent'][$index], 0, ',', '.') . " VNĐ\n";
        }
        
        return $csv;
    }
    

    
    private function translateOrderStatus($status)
    {
        $translations = [
            'pending' => app()->getLocale() === 'en' ? 'Pending' : 'Chờ xử lý',
            'processing' => app()->getLocale() === 'en' ? 'Processing' : 'Đang xử lý',
            'delivered' => app()->getLocale() === 'en' ? 'Delivered' : 'Đã giao hàng',
            'cancelled' => app()->getLocale() === 'en' ? 'Cancelled' : 'Đã hủy',
            'completed' => app()->getLocale() === 'en' ? 'Completed' : 'Hoàn thành',
        ];
        
        return $translations[$status] ?? $status;
    }
}
