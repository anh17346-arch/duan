@extends('layouts.app')

@section('title', __('app.my_orders') . ' - Perfume Luxury')

@section('content')
<!-- Modern Unified Background (giống cart) -->
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

  <!-- Modern Toast Notifications -->
  @include('partials.toast')

<div class="relative container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600">{{ __('app.home') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('profile.edit') }}" class="hover:text-brand-600">{{ __('app.my_account') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ __('app.my_orders') }}</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('app.my_orders') }}</h1>
        <p class="text-slate-600 dark:text-slate-400">{{ __('app.manage_track_orders') }}</p>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-8">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('app.order_number_placeholder') }}"
                           class="w-full px-4 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.status') }}</label>
                    <select name="status" class="w-full px-4 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                        <option value="" class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.all') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.pending') }}</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.processing') }}</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.shipped') }}</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.delivered') }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.cancelled') }}</option>
                    </select>
                </div>
                
                <!-- Payment Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.payment_status') }}</label>
                    <select name="payment_status" class="w-full px-4 py-2 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                        <option value="" class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.all') }}</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_pending') }}</option>
                        <option value="processing" {{ request('payment_status') == 'processing' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_processing') }}</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_paid') }}</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_failed') }}</option>
                    </select>
                </div>
                
                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-medium transition-all duration-300">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        {{ __('app.filter') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('orders.index') }}" 
           class="px-4 py-2 {{ !request('status') ? 'bg-brand-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-brand-50 dark:hover:bg-brand-900/20' }} rounded-lg font-medium transition-all border border-slate-200 dark:border-slate-700 shadow-sm">
            {{ __('app.all') }} ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('orders.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 {{ request('status') == 'pending' ? 'bg-yellow-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20' }} rounded-lg font-medium transition-all border border-slate-200 dark:border-slate-700 shadow-sm">
            {{ __('app.pending') }} ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('orders.index', ['status' => 'processing']) }}" 
           class="px-4 py-2 {{ request('status') == 'processing' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} rounded-lg font-medium transition-all border border-slate-200 dark:border-slate-700 shadow-sm">
            {{ __('app.processing') }} ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('orders.index', ['status' => 'shipped']) }}" 
           class="px-4 py-2 {{ request('status') == 'shipped' ? 'bg-purple-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-purple-50 dark:hover:bg-purple-900/20' }} rounded-lg font-medium transition-all border border-slate-200 dark:border-slate-700 shadow-sm">
            {{ __('app.shipped') }} ({{ $statusCounts['shipped'] }})
        </a>
        <a href="{{ route('orders.index', ['status' => 'delivered']) }}" 
           class="px-4 py-2 {{ request('status') == 'delivered' ? 'bg-green-600 text-white' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-green-50 dark:hover:bg-green-900/20' }} rounded-lg font-medium transition-all border border-slate-200 dark:border-slate-700 shadow-sm">
            {{ __('app.delivered') }} ({{ $statusCounts['delivered'] }})
        </a>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-all duration-300">
                    <!-- Compact Order Header -->
                    <div class="p-4">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">
                                        #{{ $order->order_number }}
                                    </h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-400">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                
                                <!-- Compact Status Badges -->
                                <div class="flex gap-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $order->status_badge_class }}">
                                        {{ $order->status_display }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $order->payment_status_badge_class }}">
                                        {{ $order->payment_status_display }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $order->formatted_total }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-400">{{ $order->payment_method_display }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Compact Order Items & Actions -->
                    <div class="px-4 pb-4">
                        <!-- Mini Items Preview -->
                        <div class="flex items-center gap-2 mb-3">
                            @foreach($order->items->take(4) as $item)
                                <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->name }}" 
                                     class="w-8 h-8 object-cover rounded border-2 border-white dark:border-slate-700">
                            @endforeach
                            @if($order->items->count() > 4)
                                <div class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded flex items-center justify-center">
                                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">+{{ $order->items->count() - 4 }}</span>
                                </div>
                            @endif
                            <span class="text-xs text-slate-600 dark:text-slate-400 ml-2">{{ $order->items->count() }} {{ __('app.products') }}</span>
                        </div>

                        <!-- Compact Actions -->
                        <div class="flex flex-wrap gap-2">
                            <!-- View Details -->
                            <a href="{{ route('orders.show', $order) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-medium transition-all duration-300 text-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ __('app.view_details') }}
                            </a>

                            <!-- Cancel Order (if pending) -->
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('orders.cancel', $order) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('{{ __('app.confirm_cancel_order') }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-300 text-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        {{ __('app.cancel_order') }}
                                    </button>
                                </form>
                            @endif

                            <!-- Reorder -->
                            @if($order->status === 'delivered')
                                <form method="POST" action="{{ route('orders.reorder', $order) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all duration-300 text-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        {{ __('app.reorder') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-12">
                <div class="text-slate-400 dark:text-slate-500 mb-6">
                    <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.no_orders_yet') }}</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8">{{ __('app.no_orders_description') }}</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-block px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold text-lg transition-colors">
                    🛍️ {{ __('app.start_shopping') }}
                </a>
            </div>
        </div>
    @endif
</div>
</div>

<style>
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
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