@extends('layouts.app')

@section('title', __('app.order') . ' #' . $order->order_number . ' - Perfume Luxury')

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

  <!-- Modern Toast Notifications -->
  @include('partials.toast')

<div class="relative container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600">{{ __('app.home') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('orders.index') }}" class="hover:text-brand-600">{{ __('app.my_orders') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ __('app.order') }} #{{ $order->order_number }}</li>
            </ol>
        </nav>
        
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('app.order') }} #{{ $order->order_number }}</h1>
                <p class="text-slate-600 dark:text-slate-400">{{ __('app.ordered_at') }} {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            <!-- Order Status -->
            <div class="flex flex-col items-end gap-2">
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge_class }}">
                        {{ $order->status_display }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->payment_status_badge_class }}">
                        {{ $order->payment_status_display }}
                    </span>
                </div>
                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $order->formatted_total }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        {{ __('app.ordered_products') }} ({{ $order->items->count() }})
                    </h2>
                </div>

                <div class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($order->items as $item)
                        <div class="p-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ $item->product->main_image_url }}" alt="{{ $item->product->name }}" 
                                     class="w-20 h-20 object-cover rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-slate-900 dark:text-slate-100 mb-1">{{ $item->product->display_name }}</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">{{ $item->product->brand }} • {{ $item->product->volume_ml }}ml</p>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $item->formatted_price }}</span>
                                        <span class="text-sm text-slate-600 dark:text-slate-400">× {{ $item->quantity }}</span>
                                        <span class="text-sm font-semibold text-brand-600">= {{ $item->formatted_total }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('products.show', $item->product) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1 text-brand-600 hover:text-brand-700 bg-brand-50 hover:bg-brand-100 dark:bg-brand-900/20 dark:hover:bg-brand-900/30 rounded-lg text-sm font-medium transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ __('app.view_product') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="p-6 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/30">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.subtotal') }}</span>
                            <span class="font-medium text-slate-900 dark:text-slate-100">{{ $order->formatted_subtotal }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.shipping_fee') }}</span>
                            <span class="font-medium text-slate-900 dark:text-slate-100">{{ $order->formatted_shipping_fee }}</span>
                        </div>
                        <div class="border-t border-slate-200 dark:border-slate-600 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ __('app.total') }}</span>
                                <span class="text-xl font-bold text-brand-600 dark:text-brand-400">{{ $order->formatted_total }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('app.shipping_information') }}
                    </h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.recipient_name') }}</label>
                            <p class="text-slate-900 dark:text-slate-100 font-medium">{{ $order->shipping_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.phone_number') }}</label>
                            <p class="text-slate-900 dark:text-slate-100 font-medium">{{ $order->shipping_phone }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.address') }}</label>
                            <p class="text-slate-900 dark:text-slate-100 font-medium">
                                {{ $order->shipping_address }}, {{ $order->shipping_district }}, {{ $order->shipping_city }}
                            </p>
                        </div>
                        @if($order->notes)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.notes') }}</label>
                                <p class="text-slate-900 dark:text-slate-100 bg-slate-50 dark:bg-slate-700 p-3 rounded-lg">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800/30 shadow-sm">
                    <div class="p-6 border-b border-blue-200 dark:border-blue-700">
                        <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            {{ __('app.bank_transfer_info') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-blue-800 dark:text-blue-200">
                            <div>
                                <p class="text-sm font-medium mb-1">{{ __('app.bank_name') }}:</p>
                                <p class="font-semibold">Vietcombank</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium mb-1">{{ __('app.account_number') }}:</p>
                                <p class="font-mono font-semibold">0123456789</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium mb-1">{{ __('app.account_holder') }}:</p>
                                <p class="font-semibold">PERFUME LUXURY</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium mb-1">{{ __('app.amount') }}:</p>
                                <p class="font-semibold text-lg">{{ $order->formatted_total }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium mb-1">{{ __('app.transfer_content') }}:</p>
                                <p class="font-mono font-semibold bg-blue-100 dark:bg-blue-900/30 p-2 rounded">{{ $order->order_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Order Status & Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 sticky top-8">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('app.order_information') }}
                    </h2>
                </div>

                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <!-- Order Status -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 rounded-lg">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.order_status') }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_badge_class }}">
                                {{ $order->status_display }}
                            </span>
                        </div>

                        <!-- Payment Status -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 rounded-lg">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.payment_status') }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status_badge_class }}">
                                {{ $order->payment_status_display }}
                            </span>
                        </div>

                        <!-- Payment Method -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 rounded-lg">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.payment_method') }}</span>
                            <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $order->payment_method_display }}</span>
                        </div>

                        <!-- Order Date -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700 rounded-lg">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.order_date') }}</span>
                            <span class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="space-y-3">
                        <!-- Cancel Order (if pending) -->
                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('{{ __('app.confirm_cancel_order') }}')"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ __('app.cancel_order') }}
                                </button>
                            </form>
                        @endif

                        <!-- Review Products (if delivered) -->
                        @if($order->status === 'delivered')
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    @php
                                        $existingReview = \App\Models\Review::where('user_id', auth()->id())
                                            ->where('product_id', $item->product_id)
                                            ->where('order_id', $order->id)
                                            ->first();
                                    @endphp
                                    
                                    @if(!$existingReview)
                                        <a href="{{ route('reviews.create', ['product_id' => $item->product_id, 'order_id' => $order->id]) }}"
                                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-medium transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            Đánh giá {{ $item->product->name }}
                                        </a>
                                    @else
                                        <div class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gray-400 text-white rounded-xl font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Đã đánh giá {{ $item->product->name }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <!-- Reorder (if delivered) -->
                        @if($order->status === 'delivered')
                            <form method="POST" action="{{ route('orders.reorder', $order) }}">
                                @csrf
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    {{ __('app.reorder') }}
                                </button>
                            </form>
                        @endif

                        <!-- Download Invoice -->
                        <a href="{{ route('orders.invoice', $order) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl font-medium transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('app.download_invoice') }}
                        </a>

                        <!-- Continue Shopping -->
                        <a href="{{ route('products.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-medium transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            {{ __('app.continue_shopping') }}
                        </a>
                    </div>

                    <!-- Order Timeline -->
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">{{ __('app.order_timeline') }}</h3>
                        <div class="space-y-3">
                            <!-- Order Placed -->
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ __('app.order_placed') }}</p>
                                    <p class="text-xs text-slate-600 dark:text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Processing -->
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-blue-500' : 'bg-slate-300 dark:bg-slate-600' }} rounded-full"></div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ __('app.processing') }}</p>
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ __('app.processed') }}</p>
                                    @else
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ __('app.waiting_process') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Shipped -->
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-purple-500' : 'bg-slate-300 dark:bg-slate-600' }} rounded-full"></div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ __('app.shipped') }}</p>
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ __('app.in_transit') }}</p>
                                    @else
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ __('app.not_shipped') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Delivered -->
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-slate-300 dark:bg-slate-600' }} rounded-full"></div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ __('app.delivered') }}</p>
                                    @if($order->status === 'delivered')
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ __('app.delivery_completed') }}</p>
                                    @else
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ __('app.not_delivered') }}</p>
                                    @endif
                                </div>
                            </div>
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