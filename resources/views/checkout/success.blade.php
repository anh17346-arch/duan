@extends('layouts.app')

@section('title', 'Đặt hàng thành công - Perfume Luxury')

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

    <div class="relative container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-6">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">Đặt hàng thành công!</h1>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-full border border-green-200 dark:border-green-800/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Mã đơn hàng: <span class="font-mono font-semibold">{{ $order->order_number }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Summary -->
                    <div class="backdrop-blur-sm bg-white/40 dark:bg-white/10 rounded-2xl p-6 border border-white/50 dark:border-white/20 shadow-lg">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-200 mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Thông tin đơn hàng
                        </h2>

                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 p-4 bg-slate-50/80 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700">
                                    <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->name }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-slate-900 dark:text-slate-100 truncate">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $item->product->volume_ml }}ml</p>
                                        <p class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                            {{ $item->formatted_price }} × {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $item->formatted_total }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">Tạm tính</span>
                                <span class="font-medium text-slate-900 dark:text-slate-100">{{ $order->formatted_subtotal }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">Phí vận chuyển</span>
                                <span class="font-medium text-slate-900 dark:text-slate-100">{{ $order->formatted_shipping_fee }}</span>
                            </div>
                            <div class="border-t border-slate-200 dark:border-slate-700 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-slate-900 dark:text-slate-100">Tổng cộng</span>
                                    <span class="text-xl font-bold text-brand-600 dark:text-brand-400">{{ $order->formatted_total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="backdrop-blur-sm bg-white/40 dark:bg-white/10 rounded-2xl p-6 border border-white/50 dark:border-white/20 shadow-lg">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-200 mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Thông tin giao hàng
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Người nhận</label>
                                <p class="text-slate-900 dark:text-slate-100 font-medium">{{ $order->shipping_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Số điện thoại</label>
                                <p class="text-slate-900 dark:text-slate-100 font-medium">{{ $order->shipping_phone }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Địa chỉ</label>
                                <p class="text-slate-900 dark:text-slate-100 font-medium">
                                    {{ $order->shipping_address }}, {{ $order->shipping_district }}, {{ $order->shipping_city }}
                                </p>
                            </div>
                            @if($order->notes)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ghi chú</label>
                                    <p class="text-slate-900 dark:text-slate-100">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="lg:col-span-1">
                    <div class="backdrop-blur-sm bg-white/40 dark:bg-white/10 rounded-2xl p-6 border border-white/50 dark:border-white/20 shadow-lg sticky top-8">
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-200 mb-6 flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Trạng thái đơn hàng
                        </h2>

                        <div class="space-y-4">
                            <!-- Order Status -->
                            <div class="flex items-center justify-between p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Trạng thái</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_badge_class }}">
                                    {{ $order->status_display }}
                                </span>
                            </div>

                            <!-- Payment Status -->
                            <div class="flex items-center justify-between p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Thanh toán</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status_badge_class }}">
                                    {{ $order->payment_status_display }}
                                </span>
                            </div>

                            <!-- Payment Method -->
                            <div class="flex items-center justify-between p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Phương thức</span>
                                <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $order->payment_method_display }}</span>
                            </div>

                            <!-- Order Date -->
                            <div class="flex items-center justify-between p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Ngày đặt</span>
                                <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <!-- Payment Instructions -->
                        @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                            <div class="mt-6 p-4 bg-blue-50/80 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/30 rounded-lg">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Thông tin chuyển khoản</h3>
                                <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                                    <p><strong>Ngân hàng:</strong> Vietcombank</p>
                                    <p><strong>Số tài khoản:</strong> 0123456789</p>
                                    <p><strong>Chủ tài khoản:</strong> PERFUME LUXURY</p>
                                    <p><strong>Nội dung:</strong> {{ $order->order_number }}</p>
                                    <p><strong>Số tiền:</strong> {{ $order->formatted_total }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('orders.show', $order) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-medium transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Xem chi tiết đơn hàng
                            </a>
                            <a href="{{ route('orders.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-emerald-300 dark:border-emerald-600 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl font-medium transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Tất cả đơn hàng
                            </a>
                            <a href="{{ route('products.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl font-medium transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection