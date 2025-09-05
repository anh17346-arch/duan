@extends('layouts.app')

@section('title', 'Thống kê khách hàng - Perfume Luxury')

@section('content')
<!-- Modern Unified Background -->
<div class="min-h-screen relative overflow-hidden">
  <!-- Animated Background -->
  <div class="fixed inset-0 -z-10">
    <!-- Main Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 via-purple-50/60 to-pink-50/60 dark:from-slate-900 dark:via-blue-900/30 dark:via-purple-900/30 dark:to-pink-900/30"></div>
    
    <!-- Floating Animated Blobs -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-gradient-to-r from-blue-400/10 to-purple-400/10 dark:from-blue-400/5 dark:to-purple-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-pink-400/10 to-rose-400/10 dark:from-pink-400/5 dark:to-rose-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-32 left-1/3 w-80 h-80 bg-gradient-to-r from-cyan-400/10 to-teal-400/10 dark:from-cyan-400/5 dark:to-teal-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-4000"></div>
    <div class="absolute bottom-20 right-1/4 w-56 h-56 bg-gradient-to-r from-emerald-400/10 to-green-400/10 dark:from-emerald-400/5 dark:to-green-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-6000"></div>
    
    <!-- Mesh Gradient Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.05),transparent_50%)]"></div>
    
    <!-- Subtle Grid Pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(100,116,139,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(100,116,139,0.03)_1px,transparent_1px)] bg-[size:64px_64px] dark:bg-[linear-gradient(rgba(148,163,184,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.02)_1px,transparent_1px)]"></div>
  </div>

<div class="relative max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">
                @if(app()->getLocale() === 'en')
                    Customer Statistics
                @else
                    Thống kê khách hàng
                @endif
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2">
                @if(app()->getLocale() === 'en')
                    Customer analytics and insights
                @else
                    Phân tích và thông tin chi tiết về khách hàng
                @endif
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.customers.index') }}" 
               class="group inline-flex items-center justify-center px-6 py-3 bg-white/20 dark:bg-white/5 hover:bg-white/30 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-5 h-5 mr-2 bg-slate-400/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
                    </svg>
                </div>
                @if(app()->getLocale() === 'en')
                    Back to Customers
                @else
                    Quay lại danh sách
                @endif
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Customers -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                        @if(app()->getLocale() === 'en')
                            Total Customers
                        @else
                            Tổng khách hàng
                        @endif
                    </p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ number_format($totalCustomers) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Customers -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                        @if(app()->getLocale() === 'en')
                            Active Customers
                        @else
                            Khách hàng hoạt động
                        @endif
                    </p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($activeCustomers) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inactive Customers -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                        @if(app()->getLocale() === 'en')
                            Inactive Customers
                        @else
                            Khách hàng không hoạt động
                        @endif
                    </p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ number_format($inactiveCustomers) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- New Customers This Month -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                        @if(app()->getLocale() === 'en')
                            New This Month
                        @else
                            Mới trong tháng
                        @endif
                    </p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($newCustomersThisMonth) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                 <!-- Registration Trend Chart -->
         <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6 chart-animation">
             <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">
                 @if(app()->getLocale() === 'en')
                     Customer Registration Trend
                 @else
                     Xu hướng đăng ký khách hàng
                 @endif
             </h3>
             <div class="h-64 chart-container">
                 <canvas id="registrationChart"></canvas>
             </div>
         </div>

         <!-- Top Customers by Orders -->
         <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6 chart-animation">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">
                @if(app()->getLocale() === 'en')
                    Top Customers by Orders
                @else
                    Khách hàng hàng đầu theo đơn hàng
                @endif
            </h3>
            <div class="space-y-4">
                @forelse($topCustomers as $index => $customer)
                    <div class="flex items-center justify-between p-3 bg-white/10 dark:bg-white/5 rounded-lg hover:bg-white/20 dark:hover:bg-white/10 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center mr-3">
                                <span class="text-white font-medium text-xs">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $customer->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $customer->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $customer->orders_count }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                @if(app()->getLocale() === 'en')
                                    orders
                                @else
                                    đơn hàng
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-slate-500 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                No customer data available
                            @else
                                Chưa có dữ liệu khách hàng
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Customer Status Distribution -->
    <div class="mt-8 backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-8">
        <!-- Header with Icon -->
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">
                    @if(app()->getLocale() === 'en')
                        Customer Status Distribution
                    @else
                        Phân bố trạng thái khách hàng
                    @endif
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                        Visual breakdown of customer account statuses
                    @else
                        Phân tích trực quan trạng thái tài khoản khách hàng
                    @endif
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                         <!-- Chart Container -->
             <div class="relative chart-animation">
                 <div class="h-80 bg-gradient-to-br from-white/10 to-white/5 rounded-2xl p-6 border border-white/20 dark:border-white/10 chart-container">
                     <canvas id="statusChart"></canvas>
                 </div>
                <!-- Floating Stats -->
                <div class="absolute top-4 right-4 bg-white/20 dark:bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/30 dark:border-white/20">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $totalCustomers }}</div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                Total
                            @else
                                Tổng cộng
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Cards -->
            <div class="space-y-6">
                <!-- Active Customers Card -->
                <div class="group relative overflow-hidden bg-gradient-to-r from-emerald-500/10 via-emerald-400/10 to-teal-500/10 dark:from-emerald-500/20 dark:via-emerald-400/20 dark:to-teal-500/20 rounded-2xl p-6 border border-emerald-200/50 dark:border-emerald-500/30 hover:shadow-xl transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                        @if(app()->getLocale() === 'en')
                                            Active Customers
                                        @else
                                            Khách hàng hoạt động
                                        @endif
                                    </h4>
                                    <p class="text-sm text-emerald-600 dark:text-emerald-400 font-medium">
                                        @if(app()->getLocale() === 'en')
                                            Account active
                                        @else
                                            Tài khoản hoạt động
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($activeCustomers) }}</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    @if($totalCustomers > 0)
                                        {{ number_format(($activeCustomers / $totalCustomers) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full bg-emerald-200/50 dark:bg-emerald-900/30 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $totalCustomers > 0 ? ($activeCustomers / $totalCustomers) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Inactive Customers Card -->
                <div class="group relative overflow-hidden bg-gradient-to-r from-red-500/10 via-red-400/10 to-pink-500/10 dark:from-red-500/20 dark:via-red-400/20 dark:to-pink-500/20 rounded-2xl p-6 border border-red-200/50 dark:border-red-500/30 hover:shadow-xl transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/20 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                        @if(app()->getLocale() === 'en')
                                            Inactive Customers
                                        @else
                                            Khách hàng không hoạt động
                                        @endif
                                    </h4>
                                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">
                                        @if(app()->getLocale() === 'en')
                                            Account suspended
                                        @else
                                            Tài khoản bị tạm ngưng
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ number_format($inactiveCustomers) }}</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    @if($totalCustomers > 0)
                                        {{ number_format(($inactiveCustomers / $totalCustomers) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full bg-red-200/50 dark:bg-red-900/30 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-pink-600 h-2 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $totalCustomers > 0 ? ($inactiveCustomers / $totalCustomers) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white/10 dark:bg-white/5 rounded-xl p-4 text-center border border-white/20 dark:border-white/10">
                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $activeCustomers > 0 ? number_format(($activeCustomers / $totalCustomers) * 100, 1) : 0 }}%</div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                Active Rate
                            @else
                                Tỷ lệ hoạt động
                            @endif
                        </div>
                    </div>
                    <div class="bg-white/10 dark:bg-white/5 rounded-xl p-4 text-center border border-white/20 dark:border-white/10">
                        <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $inactiveCustomers > 0 ? number_format(($inactiveCustomers / $totalCustomers) * 100, 1) : 0 }}%</div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                Inactive Rate
                            @else
                                Tỷ lệ không hoạt động
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

 <style>
 @keyframes blob {
   0% {
     transform: translate(0px, 0px) scale(1);
   }
   33% {
     transform: translate(30px, -50px) scale(1.1);
   }
   66% {
     transform: translate(-20px, 20px) scale(0.9);
   }
   100% {
     transform: translate(0px, 0px) scale(1);
   }
 }

 .animate-blob {
   animation: blob 7s infinite;
 }

 .animation-delay-2000 {
   animation-delay: 2s;
 }

 .animation-delay-4000 {
   animation-delay: 4s;
 }

 .animation-delay-6000 {
   animation-delay: 6s;
 }

 /* Custom Tooltip Styles */
 .chartjs-tooltip {
   backdrop-filter: blur(10px);
   box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
   border: 1px solid rgba(59, 130, 246, 0.2);
   border-radius: 16px;
   padding: 16px 20px;
   font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
   z-index: 1000;
 }

 .chartjs-tooltip::before {
   content: '';
   position: absolute;
   top: -8px;
   left: 50%;
   transform: translateX(-50%);
   width: 0;
   height: 0;
   border-left: 8px solid transparent;
   border-right: 8px solid transparent;
   border-bottom: 8px solid rgba(15, 23, 42, 0.95);
 }

 /* Chart Point Hover Effects */
 .chartjs-render-monitor {
   transition: all 0.3s ease;
 }

 /* Custom Scrollbar for Chart Containers */
 .chart-container::-webkit-scrollbar {
   width: 6px;
 }

 .chart-container::-webkit-scrollbar-track {
   background: rgba(148, 163, 184, 0.1);
   border-radius: 3px;
 }

 .chart-container::-webkit-scrollbar-thumb {
   background: rgba(59, 130, 246, 0.3);
   border-radius: 3px;
 }

 .chart-container::-webkit-scrollbar-thumb:hover {
   background: rgba(59, 130, 246, 0.5);
 }

 /* Enhanced Chart Animations */
 @keyframes chartFadeIn {
   from {
     opacity: 0;
     transform: translateY(20px);
   }
   to {
     opacity: 1;
     transform: translateY(0);
   }
 }

 .chart-animation {
   animation: chartFadeIn 0.8s ease-out;
 }

 /* Tooltip Glow Effect */
 .chartjs-tooltip {
   position: relative;
 }

 .chartjs-tooltip::after {
   content: '';
   position: absolute;
   top: -2px;
   left: -2px;
   right: -2px;
   bottom: -2px;
   background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(147, 51, 234, 0.3));
   border-radius: 18px;
   z-index: -1;
   opacity: 0;
   transition: opacity 0.3s ease;
 }

 .chartjs-tooltip:hover::after {
   opacity: 1;
 }
 </style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Registration Trend Chart
    const registrationCtx = document.getElementById('registrationChart').getContext('2d');
    new Chart(registrationCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($registrationTrend, 'month')),
            datasets: [{
                label: '@if(app()->getLocale() === 'en') New Customers @else Khách hàng mới @endif',
                data: @json(array_column($registrationTrend, 'count')),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointHoverBorderWidth: 4,
                pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                pointHoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(59, 130, 246, 0.3)',
                    borderWidth: 2,
                    cornerRadius: 12,
                    displayColors: false,
                    padding: 16,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        title: function(context) {
                            return '📅 ' + context[0].label;
                        },
                        label: function(context) {
                            const value = context.parsed.y;
                            const label = context.dataset.label;
                            return `👥 ${label}: ${value} @if(app()->getLocale() === 'en') customers @else khách hàng @endif`;
                        }
                    },
                    animation: {
                        duration: 200
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: 'rgba(71, 85, 105, 0.8)',
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: 'rgba(71, 85, 105, 0.8)',
                        font: {
                            size: 12
                        },
                        stepSize: 1,
                        callback: function(value) {
                            return value + ' @if(app()->getLocale() === 'en') customers @else khách hàng @endif';
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: [
                '@if(app()->getLocale() === 'en') Active @else Hoạt động @endif',
                '@if(app()->getLocale() === 'en') Inactive @else Không hoạt động @endif'
            ],
            datasets: [{
                data: [{{ $activeCustomers }}, {{ $inactiveCustomers }}],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 2,
                hoverBorderWidth: 6,
                hoverOffset: 15,
                hoverBackgroundColor: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#ffffff',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(59, 130, 246, 0.3)',
                    borderWidth: 2,
                    cornerRadius: 16,
                    displayColors: true,
                    padding: 20,
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 14
                    },
                    callbacks: {
                        title: function(context) {
                            const labels = ['✅ @if(app()->getLocale() === 'en') Active Customers @else Khách hàng hoạt động @endif', '❌ @if(app()->getLocale() === 'en') Inactive Customers @else Khách hàng không hoạt động @endif'];
                            return labels[context[0].dataIndex];
                        },
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            
                            // Add icons based on status
                            const icons = ['🟢', '🔴'];
                            const icon = icons[context.dataIndex];
                            
                            return [
                                `${icon} ${label}`,
                                `📊 @if(app()->getLocale() === 'en') Count @else Số lượng @endif: ${value.toLocaleString()}`,
                                `📈 @if(app()->getLocale() === 'en') Percentage @else Tỷ lệ @endif: ${percentage}%`,
                                `📋 @if(app()->getLocale() === 'en') Total @else Tổng cộng @endif: ${total.toLocaleString()}`
                            ];
                        }
                    },
                    animation: {
                        duration: 300
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutQuart'
            },
            interaction: {
                mode: 'nearest',
                intersect: false,
                axis: 'xy'
            }
        }
    });
});
</script>
@endsection
