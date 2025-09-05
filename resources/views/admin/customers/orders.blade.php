@extends('layouts.app')

@section('title', 'Tất cả đơn hàng - ' . $customer->name . ' - Perfume Luxury')

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
                    All Orders - {{ $customer->name }}
                @else
                    Tất cả đơn hàng - {{ $customer->name }}
                @endif
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2">
                @if(app()->getLocale() === 'en')
                    Complete order history for this customer
                @else
                    Lịch sử đơn hàng đầy đủ của khách hàng này
                @endif
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.customers.show', $customer) }}" 
               class="group inline-flex items-center justify-center px-6 py-3 bg-white/20 dark:bg-white/5 hover:bg-white/30 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-5 h-5 mr-2 bg-slate-400/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
                    </svg>
                </div>
                @if(app()->getLocale() === 'en')
                    Back to Customer
                @else
                    Quay lại khách hàng
                @endif
            </a>
        </div>
    </div>

    <!-- Orders List -->
    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                @if(app()->getLocale() === 'en')
                    Order History
                @else
                    Lịch sử đơn hàng
                @endif
            </h3>
            <span class="text-sm text-slate-500 dark:text-slate-400">
                {{ $orders->total() }} @if(app()->getLocale() === 'en') orders @else đơn hàng @endif
            </span>
        </div>

        @if($orders && $orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="border border-slate-200/60 dark:border-slate-700 rounded-xl p-4 hover:bg-white/10 dark:hover:bg-white/5 transition-colors duration-200">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <span class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                    #{{ $order->order_number ?? 'N/A' }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    @if(($order->status ?? '') === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @elseif(($order->status ?? '') === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                    @elseif(($order->status ?? '') === 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                    @elseif(($order->status ?? '') === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif(($order->status ?? '') === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @else bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-400 @endif shadow-sm">
                                    @if(app()->getLocale() === 'en')
                                        {{ ucfirst($order->status ?? 'unknown') }}
                                    @else
                                        @if(($order->status ?? '') === 'pending') Chờ xử lý
                                        @elseif(($order->status ?? '') === 'processing') Đang xử lý
                                        @elseif(($order->status ?? '') === 'shipped') Đã gửi hàng
                                        @elseif(($order->status ?? '') === 'delivered') Đã giao hàng
                                        @elseif(($order->status ?? '') === 'cancelled') Đã hủy
                                        @else {{ ucfirst($order->status ?? 'unknown') }} @endif
                                    @endif
                                </span>
                            </div>
                            <span class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center space-x-3">
                                        @if($item->product)
                                            @if($item->product->primaryImage)
                                                <img src="{{ $item->product->primaryImage->image_url }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-8 h-8 rounded-lg object-cover border border-slate-200/60 dark:border-slate-600/60"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/product-placeholder.png') }}'">
                                            @else
                                                <div class="w-8 h-8 bg-slate-200 dark:bg-slate-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <span class="text-slate-900 dark:text-slate-100">{{ $item->product->name }}</span>
                                        @else
                                            <div class="w-8 h-8 bg-slate-200 dark:bg-slate-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </div>
                                            <span class="text-slate-500 dark:text-slate-400">@if(app()->getLocale() === 'en') Product Deleted @else Sản phẩm đã xóa @endif</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="text-slate-600 dark:text-slate-400">{{ $item->quantity ?? 0 }}x</span>
                                        <span class="text-slate-900 dark:text-slate-100 ml-2">{{ number_format($item->price ?? 0) }}đ</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3 pt-3 border-t border-slate-200/60 dark:border-slate-700 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                @if(app()->getLocale() === 'en')
                                    Total
                                @else
                                    Tổng cộng
                                @endif
                            </span>
                            <div class="flex items-center space-x-3">
                                <span class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                    {{ number_format($order->total ?? 0) }}đ
                                </span>
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium">
                                    @if(app()->getLocale() === 'en')
                                        View Details
                                    @else
                                        Xem chi tiết
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-2">
                    @if(app()->getLocale() === 'en')
                        No Orders Found
                    @else
                        Không tìm thấy đơn hàng nào
                    @endif
                </h3>
                <p class="text-slate-500 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                        This customer hasn't placed any orders yet.
                    @else
                        Khách hàng này chưa đặt đơn hàng nào.
                    @endif
                </p>
            </div>
        @endif
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
</style>
@endsection
