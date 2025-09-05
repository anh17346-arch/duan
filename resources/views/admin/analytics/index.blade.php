@extends('layouts.app')

@section('title', __('app.analytics_dashboard'))

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
        padding: 24px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.25);
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
    }
    
    .chart-container:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    
    .dark .chart-container {
        background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.03) 100%);
        border-color: rgba(255,255,255,0.15);
    }
    
    .revenue-chart-container {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.08) 50%, rgba(99, 102, 241, 0.05) 100%);
    }
    
    .stat-card {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.3s ease;
    }
    
    .dark .stat-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .dark .stat-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    
    .revenue-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .orders-gradient {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .success-gradient {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .pending-gradient {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    
    .filter-section {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .dark .filter-section {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .product-card {
        position: relative;
        background: linear-gradient(135deg, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.6) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.4s ease;
    }
    
    .dark .product-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .product-card:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .dark .product-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    .animation-delay-6000 { animation-delay: 6s; }
</style>
@endpush

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

  <div class="relative">
    <!-- Header -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ __('app.analytics_dashboard') }}</h1>
                    <p class="text-slate-600 dark:text-slate-300 mt-1">{{ __('app.analytics_description') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Export Button -->
                    <a href="{{ route('admin.analytics.export-options', ['period' => $period, 'start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" 
                       class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('app.export_report') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="filter-section rounded-2xl p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                 <div>
                     <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.period') }}</label>
                     <select name="period" class="w-full px-3 py-2 bg-white border border-slate-300 dark:bg-slate-700 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         <option value="day" {{ $period === 'day' ? 'selected' : '' }}>{{ __('app.daily') }}</option>
                         <option value="week" {{ $period === 'week' ? 'selected' : '' }}>{{ __('app.weekly') }}</option>
                         <option value="month" {{ $period === 'month' ? 'selected' : '' }}>{{ __('app.monthly') }}</option>
                         <option value="year" {{ $period === 'year' ? 'selected' : '' }}>{{ __('app.yearly') }}</option>
                     </select>
                 </div>
                 
                 <div>
                     <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.start_date') }}</label>
                     <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                            class="w-full px-3 py-2 bg-white border border-slate-300 dark:bg-slate-700 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                 </div>
                 
                 <div>
                     <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.end_date') }}</label>
                     <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                            class="w-full px-3 py-2 bg-white border border-slate-300 dark:bg-slate-700 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                 </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                        {{ __('app.apply_filter') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="stat-card rounded-2xl p-6 revenue-gradient">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium">{{ __('app.total_revenue') }}</p>
                        <p class="text-white text-2xl font-bold">
                            @if(app()->getLocale() === 'en')
                                ${{ number_format($overview['total_revenue'] / 25000, 2) }}
                            @else
                                {{ number_format($overview['total_revenue'], 0, ',', '.') }}đ
                            @endif
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="stat-card rounded-2xl p-6 orders-gradient">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium">{{ __('app.total_orders') }}</p>
                        <p class="text-white text-2xl font-bold">{{ number_format($overview['total_orders']) }}</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Success Rate -->
            <div class="stat-card rounded-2xl p-6 success-gradient">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium">{{ __('app.success_rate') }}</p>
                        <p class="text-white text-2xl font-bold">{{ $overview['success_rate'] }}%</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Order Value -->
            <div class="stat-card rounded-2xl p-6 pending-gradient">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium">{{ __('app.avg_order_value') }}</p>
                        <p class="text-white text-2xl font-bold">
                            @if(app()->getLocale() === 'en')
                                ${{ number_format($overview['avg_order_value'] / 25000, 2) }}
                            @else
                                {{ number_format($overview['avg_order_value'], 0, ',', '.') }}đ
                            @endif
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                         <!-- Revenue Chart -->
             <div class="stat-card rounded-2xl p-6">
                 <div class="flex items-center justify-between mb-6">
                     <h3 class="text-xl font-semibold text-slate-900 dark:text-white">{{ __('app.revenue_trend') }}</h3>
                     <div class="flex items-center space-x-2">
                         <div class="w-3 h-3 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full animate-pulse"></div>
                         <span class="text-sm text-slate-600 dark:text-slate-400 font-medium">Live Data</span>
                     </div>
                 </div>
                 <div class="chart-container revenue-chart-container">
                     <canvas id="revenueChart"></canvas>
                 </div>
             </div>
 
             <!-- Payment Methods Chart -->
             <div class="stat-card rounded-2xl p-6">
                 <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">{{ __('app.payment_methods') }}</h3>
                 <div class="chart-container">
                     <canvas id="paymentChart"></canvas>
                 </div>
             </div>
        </div>

        <!-- Order Status & Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                         <!-- Order Status -->
             <div class="stat-card rounded-2xl p-6">
                 <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">{{ __('app.order_status') }}</h3>
                 <div class="chart-container">
                     <canvas id="orderStatusChart"></canvas>
                 </div>
             </div>
 
             <!-- Top Products -->
             <div class="stat-card rounded-2xl p-6">
                 <div class="flex items-center justify-between mb-6">
                     <h3 class="text-xl font-semibold text-slate-900 dark:text-white">{{ __('app.top_products') }}</h3>
                     <div class="flex items-center space-x-2">
                         <div class="w-2 h-2 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full animate-pulse"></div>
                         <span class="text-sm text-slate-600 dark:text-slate-400 font-medium">Best Sellers</span>
                     </div>
                 </div>
                 <div class="space-y-4">
                     @foreach($topProducts['names'] as $index => $name)
                         <div class="product-card group relative overflow-hidden bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 rounded-xl p-4 border border-slate-200 dark:border-slate-600 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] hover:border-emerald-300 dark:hover:border-emerald-500">
                             <!-- Rank Badge -->
                             <div class="absolute top-3 right-3">
                                 @if($index === 0)
                                     <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg">
                                         🥇
                                     </div>
                                 @elseif($index === 1)
                                     <div class="w-8 h-8 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg">
                                         🥈
                                     </div>
                                 @elseif($index === 2)
                                     <div class="w-8 h-8 bg-gradient-to-r from-amber-600 to-amber-700 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg">
                                         🥉
                                     </div>
                                 @else
                                     <div class="w-8 h-8 bg-gradient-to-r from-slate-500 to-slate-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg">
                                         {{ $index + 1 }}
                                     </div>
                                 @endif
                             </div>
                             
                             <!-- Product Info -->
                             <div class="flex items-center space-x-4">
                                 <!-- Product Icon -->
                                 <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:shadow-xl transition-all duration-300">
                                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                     </svg>
                                 </div>
                                 
                                 <!-- Product Details -->
                                 <div class="flex-1 min-w-0">
                                     <h4 class="text-slate-900 dark:text-white font-semibold text-lg truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                                         {{ $name }}
                                     </h4>
                                     <div class="flex items-center space-x-4 mt-1">
                                         <div class="flex items-center space-x-1">
                                             <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                             </svg>
                                             <span class="text-sm text-slate-600 dark:text-slate-300 font-medium">
                                                 {{ $topProducts['quantities'][$index] }} {{ __('app.sold') }}
                                             </span>
                                         </div>
                                         <div class="flex items-center space-x-1">
                                             <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                             </svg>
                                             <span class="text-sm text-slate-600 dark:text-slate-300 font-medium">
                                                 @if(app()->getLocale() === 'en')
                                                     ${{ number_format($topProducts['revenues'][$index] / 25000, 2) }}
                                                 @else
                                                     {{ number_format($topProducts['revenues'][$index], 0, ',', '.') }}đ
                                                 @endif
                                             </span>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             
                                                           <!-- Progress Bar -->
                              @php
                                  $maxRevenue = max($topProducts['revenues']->toArray());
                                  $percentage = ($topProducts['revenues'][$index] / $maxRevenue) * 100;
                              @endphp
                             <div class="mt-3">
                                 <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 mb-1">
                                     <span>Performance</span>
                                     <span>{{ number_format($percentage, 1) }}%</span>
                                 </div>
                                 <div class="w-full bg-slate-200 dark:bg-slate-600 rounded-full h-2 overflow-hidden">
                                     <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-1000 ease-out" 
                                          style="width: {{ $percentage }}%"></div>
                                 </div>
                             </div>
                             
                             <!-- Hover Effect Overlay -->
                             <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                         </div>
                     @endforeach
                 </div>
             </div>
        </div>

                 <!-- Top Customers -->
         <div class="stat-card rounded-2xl p-6">
             <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">{{ __('app.top_customers') }}</h3>
             <div class="overflow-x-auto">
                 <table class="w-full text-slate-900 dark:text-white">
                     <thead>
                         <tr class="border-b border-slate-200 dark:border-slate-700">
                             <th class="text-left py-3 px-4">{{ __('app.rank') }}</th>
                             <th class="text-left py-3 px-4">{{ __('app.customer_name') }}</th>
                             <th class="text-left py-3 px-4">{{ __('app.total_orders') }}</th>
                             <th class="text-left py-3 px-4">{{ __('app.total_spent') }}</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($topCustomers['names'] as $index => $name)
                             <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                 <td class="py-3 px-4">
                                     <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                         {{ $index + 1 }}
                                     </div>
                                 </td>
                                 <td class="py-3 px-4 font-medium">{{ $name }}</td>
                                 <td class="py-3 px-4">{{ $topCustomers['orders'][$index] }}</td>
                                 <td class="py-3 px-4 font-semibold">
                                     @if(app()->getLocale() === 'en')
                                         ${{ number_format($topCustomers['spent'][$index] / 25000, 2) }}
                                     @else
                                         {{ number_format($topCustomers['spent'][$index], 0, ',', '.') }}đ
                                     @endif
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    
    const gradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.8)');
    gradient.addColorStop(0.5, 'rgba(139, 92, 246, 0.6)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.1)');
    
    const lineGradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
    lineGradient.addColorStop(0, 'rgba(99, 102, 241, 1)');
    lineGradient.addColorStop(1, 'rgba(139, 92, 246, 1)');
    
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: '{{ app()->getLocale() === "en" ? "Revenue" : "Doanh thu" }}',
                data: @json($revenueData['revenue']),
                borderColor: lineGradient,
                backgroundColor: gradient,
                borderWidth: 4,
                tension: 0.6,
                fill: true,
                pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                pointBorderColor: 'rgba(99, 102, 241, 1)',
                pointBorderWidth: 3,
                pointRadius: 8,
                pointHoverRadius: 12,
                pointHoverBackgroundColor: 'rgba(255, 255, 255, 1)',
                pointHoverBorderColor: 'rgba(139, 92, 246, 1)',
                pointHoverBorderWidth: 4
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
                    titleColor: '#f8fafc',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(99, 102, 241, 0.5)',
                    borderWidth: 2,
                    cornerRadius: 16,
                    displayColors: false,
                    titleFont: {
                        size: 16,
                        weight: '700'
                    },
                    bodyFont: {
                        size: 14,
                        weight: '600'
                    },
                    padding: 16,
                    callbacks: {
                        title: function(context) {
                            return `📈 ${context[0].label}`;
                        },
                        label: function(context) {
                            const value = context.parsed.y;
                            const formattedValue = new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND',
                                minimumFractionDigits: 0
                            }).format(value);
                            
                            return [
                                `💰 ${formattedValue}`,
                                `📊 Ngày: ${context.label}`
                            ];
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    grid: {
                        display: true,
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.05)',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.6)',
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        padding: 8
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    display: true,
                    grid: {
                        display: true,
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.05)',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.7)' : 'rgba(0, 0, 0, 0.6)',
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        padding: 8,
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                notation: 'compact',
                                maximumFractionDigits: 1
                            }).format(value);
                        }
                    },
                    border: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            elements: {
                line: {
                    borderJoinStyle: 'round'
                },
                point: {
                    hoverRadius: 12,
                    hitRadius: 10
                }
            }
        }
    });

    // Payment Methods Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: @json($paymentStats['methods']),
            datasets: [{
                data: @json($paymentStats['orders']),
                backgroundColor: [
                    'rgba(236, 72, 153, 0.9)',
                    'rgba(59, 130, 246, 0.9)',
                    'rgba(245, 158, 11, 0.9)',
                    'rgba(16, 185, 129, 0.9)',
                    'rgba(139, 92, 246, 0.9)',
                    'rgba(239, 68, 68, 0.9)'
                ],
                borderWidth: 3,
                borderColor: 'rgba(255, 255, 255, 0.8)',
                hoverBorderWidth: 4,
                hoverBorderColor: 'rgba(255, 255, 255, 1)',
                cutout: '65%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: document.documentElement.classList.contains('dark') ? 'white' : '#1e293b',
                        padding: 25,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#f8fafc',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(59, 130, 246, 0.5)',
                    borderWidth: 2,
                    cornerRadius: 12,
                    displayColors: true,
                    titleFont: {
                        size: 14,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13,
                        weight: '500'
                    },
                    padding: 12,
                    callbacks: {
                        title: function(context) {
                            return `💳 ${context[0].label}`;
                        },
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return [
                                `📊 ${context.parsed} đơn hàng`,
                                `📈 ${percentage}% tổng số`
                            ];
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'pie',
        data: {
            labels: @json($orderStatusStats['statuses']),
            datasets: [{
                data: @json($orderStatusStats['counts']),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.9)',
                    'rgba(239, 68, 68, 0.9)',
                    'rgba(245, 158, 11, 0.9)',
                    'rgba(59, 130, 246, 0.9)',
                    'rgba(139, 92, 246, 0.9)',
                    'rgba(236, 72, 153, 0.9)'
                ],
                borderWidth: 3,
                borderColor: 'rgba(255, 255, 255, 0.8)',
                hoverBorderWidth: 4,
                hoverBorderColor: 'rgba(255, 255, 255, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: document.documentElement.classList.contains('dark') ? 'white' : '#1e293b',
                        padding: 25,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: '#f8fafc',
                    bodyColor: '#e2e8f0',
                    borderColor: 'rgba(59, 130, 246, 0.5)',
                    borderWidth: 2,
                    cornerRadius: 12,
                    displayColors: true,
                    titleFont: {
                        size: 14,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13,
                        weight: '500'
                    },
                    padding: 12,
                    callbacks: {
                        title: function(context) {
                            return `📦 ${context[0].label}`;
                        },
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return [
                                `📊 ${context.parsed} đơn hàng`,
                                `📈 ${percentage}% tổng số`
                            ];
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endpush
