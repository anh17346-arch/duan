@extends('layouts.app')

@section('title', __('app.cart'))

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
    
    <!-- Promotion Notification Banner -->
    <div id="promotion-banner" class="hidden mb-6 p-4 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl shadow-lg border border-yellow-300">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-bold text-white">{{ __('app.special_promotion') }}</h3>
                    <p class="text-yellow-100">{{ __('app.cart_promotion_message') }}</p>
                </div>
            </div>
            <button id="close-promotion-banner" class="text-white hover:text-yellow-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600">{{ __('app.home') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ __('app.cart') }}</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('app.cart') }}</h1>
        <p class="text-slate-600 dark:text-slate-400">{{ __('app.manage_cart_products') }}</p>
    </div>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">{{ __('app.cart_products_count', ['count' => $cartItems->count()]) }}</h2>
                    </div>
                    
                    <div class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($cartItems as $item)
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->product->main_image_url }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-20 h-20 rounded-lg object-cover">
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-1">
                                                    {{ $item->product->display_name }}
                                                </h3>
                                                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">
                                                    {{ $item->product->brand }} • {{ $item->product->volume_ml }}ml
                                                </p>
                                                
                                                <!-- Promotion Badge -->
                                                @if($item->has_promotion && $item->promotion)
                                                <div class="promotion-badge-{{ $item->product_id }} mb-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-400 to-orange-500 text-white">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                        </svg>
                                                        {{ __('app.discount') }} {{ $item->promotion->discount_percentage }}%
                                                    </span>
                                                    @if($item->promotion_total > 0)
                                                        <div class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                                            @if($item->promotion_remaining > 0)
                                                                {{ __('app.remaining') }}: {{ $item->promotion_remaining }}
                                                            @else
                                                                {{ __('app.promotion_ended') }}
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                @endif
                                                
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center gap-3">
                                                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.quantity') }}:</label>
                                                    <div class="flex items-center gap-2">
                                                        <!-- Decrease Button -->
                                                        <form method="POST" action="{{ route('cart.decrease', $item) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="group relative w-9 h-9 bg-slate-100 dark:bg-slate-700 hover:bg-rose-500 dark:hover:bg-rose-500 rounded-full transition-all duration-300 ease-out flex items-center justify-center shadow-sm hover:shadow-md hover:scale-110 transform">
                                                                <svg class="w-4 h-4 text-slate-600 dark:text-slate-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path>
                                                                </svg>
                                                                <!-- Ripple effect -->
                                                                <span class="absolute inset-0 rounded-full bg-rose-400 opacity-0 group-active:opacity-30 group-active:scale-125 transition-all duration-200"></span>
                                                            </button>
                                                        </form>
                                                        
                                                        <!-- Quantity Display -->
                                                        <div class="px-4 py-2 min-w-[3rem] text-center text-lg font-semibold text-slate-900 dark:text-slate-100 bg-slate-50 dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-600">
                                                            {{ $item->quantity }}
                                                        </div>
                                                        
                                                        <!-- Increase Button -->
                                                        <form method="POST" action="{{ route('cart.increase', $item) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="group relative w-9 h-9 bg-slate-100 dark:bg-slate-700 hover:bg-emerald-500 dark:hover:bg-emerald-500 rounded-full transition-all duration-300 ease-out flex items-center justify-center shadow-sm hover:shadow-md hover:scale-110 transform {{ $item->has_promotion && $item->promotion_total > 0 && $item->quantity >= $item->promotion_remaining ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                                    {{ $item->has_promotion && $item->promotion_total > 0 && $item->quantity >= $item->promotion_remaining ? 'disabled' : '' }}>
                                                                <svg class="w-4 h-4 text-slate-600 dark:text-slate-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                </svg>
                                                                <!-- Ripple effect -->
                                                                <span class="absolute inset-0 rounded-full bg-emerald-400 opacity-0 group-active:opacity-30 group-active:scale-125 transition-all duration-200"></span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Price & Actions -->
                                            <div class="text-right">
                                                <div class="mb-2">
                                                    @if($item->has_promotion && $item->promotion)
                                                        <!-- Original Price -->
                                                        <div class="text-sm text-slate-400 line-through">
                                                            @if(app()->getLocale() === 'en')
                                                                ${{ number_format($item->product->price / 25000, 2) }}
                                                            @else
                                                                {{ number_format($item->product->price, 0, ',', '.') }}đ
                                                            @endif
                                                        </div>
                                                        <!-- Discounted Price -->
                                                        @php
                                                            $discountedPrice = $item->product->price * (1 - $item->promotion->discount_percentage / 100);
                                                            $discountedSubtotal = $discountedPrice * $item->quantity;
                                                        @endphp
                                                        <div class="text-lg font-bold text-green-600">
                                                            @if(app()->getLocale() === 'en')
                                                                ${{ number_format($discountedSubtotal / 25000, 2) }}
                                                            @else
                                                                {{ number_format($discountedSubtotal, 0, ',', '.') }}đ
                                                            @endif
                                                        </div>
                                                        <!-- Savings -->
                                                        <div class="text-xs text-green-600">
                                                            {{ __('app.savings') }}: 
                                                            @if(app()->getLocale() === 'en')
                                                                ${{ number_format(($item->product->price * $item->quantity - $discountedSubtotal) / 25000, 2) }}
                                                            @else
                                                                {{ number_format($item->product->price * $item->quantity - $discountedSubtotal, 0, ',', '.') }}đ
                                                            @endif
                                                        </div>
                                                    @elseif($item->product->is_on_sale)
                                                        <div class="text-sm text-slate-400 line-through">
                                                            @if(app()->getLocale() === 'en')
                                                                ${{ number_format($item->product->price / 25000, 2) }}
                                                            @else
                                                                {{ number_format($item->product->price, 0, ',', '.') }}đ
                                                            @endif
                                                        </div>
                                                        <div class="text-lg font-bold text-brand-600">
                                                            {{ $item->subtotal_formatted }}
                                                        </div>
                                                    @else
                                                        <div class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                                            {{ $item->subtotal_formatted }}
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <form method="POST" action="{{ route('cart.remove', $item) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-700 text-sm font-medium">
                                                        {{ __('app.remove') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">{{ __('app.order_summary') }}</h3>
                    
                    <!-- Promotion Section -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                {{ __('app.promotion') }}
                            </h4>
                            <div id="promotion-status" class="text-xs text-yellow-600 dark:text-yellow-400">
                            @php
                                $promotionCount = $cartItems->where('has_promotion', true)->count();
                            @endphp
                            @if($promotionCount > 0)
                                {{ $promotionCount }} {{ __('app.promotions_available') }}
                            @else
                                {{ __('app.no_promotions') }}
                            @endif
                        </div>
                        </div>
                        
                        <div id="promotion-info" class="{{ $totalSavings > 0 ? '' : 'hidden' }}">
                            <div id="applied-promotions" class="space-y-2 mb-3">
                                @foreach($cartItems as $item)
                                    @if($item->has_promotion && $item->promotion)
                                        @php
                                            $itemOriginalPrice = $item->product->price * $item->quantity;
                                            $discountRate = $item->promotion->discount_percentage / 100;
                                            $itemDiscountedPrice = $itemOriginalPrice * (1 - $discountRate);
                                            $itemSavings = $itemOriginalPrice - $itemDiscountedPrice;
                                        @endphp
                                        <div class="flex items-center justify-between text-xs bg-white dark:bg-gray-800 p-2 rounded-lg">
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</div>
                                                <div class="text-gray-500 dark:text-gray-400">{{ __('app.discount') }} {{ $item->promotion->discount_percentage }}%</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-green-600 dark:text-green-400 font-medium">
                                                    @if(app()->getLocale() === 'en')
                                                        -${{ number_format($itemSavings / 25000, 2) }}
                                                    @else
                                                        -{{ number_format($itemSavings, 0, ',', '.') }}đ
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-yellow-700 dark:text-yellow-300">{{ __('app.total_savings') }}:</span>
                                <span id="total-savings" class="font-bold text-green-600 dark:text-green-400">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($totalSavings / 25000, 2) }}
                                    @else
                                        {{ number_format($totalSavings, 0, ',', '.') }}đ
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button id="apply-promotion-btn" 
                                    class="flex-1 px-3 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white text-xs font-medium rounded-lg transition-all duration-300 transform hover:scale-105 {{ $totalSavings > 0 ? 'hidden' : '' }}">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('app.apply_promotion') }}
                            </button>
                            <button id="remove-promotion-btn" 
                                    class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs font-medium rounded-lg transition-all duration-300 {{ $totalSavings > 0 ? '' : 'hidden' }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_products') }}:</span>
                            <span class="text-slate-900 dark:text-slate-100">{{ auth()->user()->cart_items_count }}</span>
                        </div>
                        
                        @if($totalSavings > 0)
                            <!-- Original Total -->
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_amount') }}:</span>
                                <span class="text-slate-400 line-through">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($originalTotal / 25000, 2) }}
                                    @else
                                        {{ number_format($originalTotal, 0, ',', '.') }}đ
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Discounted Total -->
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_after_discount') }}:</span>
                                <span id="cart-total" class="text-lg font-bold text-green-600 dark:text-green-400">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($discountedTotal / 25000, 2) }}
                                    @else
                                        {{ number_format($discountedTotal, 0, ',', '.') }}đ
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Total Savings -->
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_savings') }}:</span>
                                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                    @if(app()->getLocale() === 'en')
                                        -${{ number_format($totalSavings / 25000, 2) }}
                                    @else
                                        -{{ number_format($totalSavings, 0, ',', '.') }}đ
                                    @endif
                                </span>
                            </div>
                        @else
                            <!-- No Promotions -->
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_amount') }}:</span>
                                <span id="cart-total" class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($originalTotal / 25000, 2) }}
                                    @else
                                        {{ number_format($originalTotal, 0, ',', '.') }}đ
                                    @endif
                                </span>
                            </div>
                        @endif
                        
                        <!-- Hidden elements for JavaScript -->
                        <div id="discounted-total" class="hidden flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_after_discount') }}</span>
                            <span id="final-total" class="text-lg font-bold text-green-600 dark:text-green-400"></span>
                        </div>
                        <div id="total-savings" class="hidden flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_savings') }}:</span>
                            <span id="savings-amount" class="text-lg font-bold text-green-600 dark:text-green-400"></span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Primary Action: Checkout -->
                        <a href="{{ route('checkout.index') }}" class="group w-full h-14 flex items-center justify-center gap-3 px-6 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <div class="relative">
                                <svg class="w-6 h-6 flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <!-- Sparkle effect -->
                                <div class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 animate-ping"></div>
                            </div>
                            <span class="leading-none">{{ __('app.proceed_to_order') }}</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                        <!-- Secondary Actions -->
                        <div class="grid grid-cols-1 gap-3">
                            <!-- Clear Cart -->
                            <form method="POST" action="{{ route('cart.clear') }}" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('{{ __('app.confirm_clear_cart') }}')" 
                                        class="group w-full h-12 flex items-center justify-center gap-3 px-6 bg-gradient-to-r from-slate-100 to-slate-200 hover:from-rose-500 hover:to-rose-600 dark:from-slate-700 dark:to-slate-600 dark:hover:from-rose-600 dark:hover:to-rose-700 text-slate-700 hover:text-white dark:text-slate-300 dark:hover:text-white rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                    <span class="leading-none">{{ __('app.clear_cart') }}</span>
                                </button>
                            </form>
                            
                            <!-- Continue Shopping -->
                            <a href="{{ route('products.index') }}" 
                               class="group w-full h-12 flex items-center justify-center gap-3 px-6 bg-gradient-to-r from-blue-50 to-brand-50 hover:from-blue-500 hover:to-brand-600 dark:from-blue-900/20 dark:to-brand-900/20 dark:hover:from-blue-600 dark:hover:to-brand-700 text-blue-700 hover:text-white dark:text-blue-400 dark:hover:text-white rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                <span class="leading-none">{{ __('app.continue_shopping') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16">
        <div class="text-slate-400 dark:text-slate-500 mb-6 flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" 
                fill="none" viewBox="0 0 24 24" 
                 stroke-width="1.5" stroke="currentColor" 
                class="w-24 h-24">
            <path stroke-linecap="round" stroke-linejoin="round" 
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218
                c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 
                0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
        </div>
            <h3 class="text-2xl font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.cart_empty') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8">{{ __('app.no_products_in_cart') }}</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold text-lg transition-colors">
                🛒 {{ __('app.start_shopping') }}
            </a>
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

/* Promotion Animation */
@keyframes promotionPulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}
.promotion-pulse {
  animation: promotionPulse 2s infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyPromotionBtn = document.getElementById('apply-promotion-btn');
    const removePromotionBtn = document.getElementById('remove-promotion-btn');
    const promotionInfo = document.getElementById('promotion-info');
    const appliedPromotions = document.getElementById('applied-promotions');
    const totalSavings = document.getElementById('total-savings');
    const cartTotal = document.getElementById('cart-total');
    const discountedTotal = document.getElementById('discounted-total');
    const finalTotal = document.getElementById('final-total');
    const promotionStatus = document.getElementById('promotion-status');
    const promotionBanner = document.getElementById('promotion-banner');
    const closePromotionBanner = document.getElementById('close-promotion-banner');

    // Check for existing promotions in session
    checkExistingPromotions();
    
    // Auto-show promotion banner if there are promotions
    @if($cartItems->where('has_promotion', true)->count() > 0)
        if (!localStorage.getItem('promotionBannerDismissed')) {
            promotionBanner.classList.remove('hidden');
            promotionBanner.classList.add('animate-bounce');
            setTimeout(() => {
                promotionBanner.classList.remove('animate-bounce');
            }, 2000);
        }
        
        // Auto-show promotion info if there are savings
        @if($totalSavings > 0)
            promotionInfo.classList.remove('hidden');
            applyPromotionBtn.classList.add('hidden');
            removePromotionBtn.classList.remove('hidden');
            
            // Update promotion status
            promotionStatus.textContent = 'Đã áp dụng khuyến mãi';
        @endif
    @endif

    // Close promotion banner
    closePromotionBanner.addEventListener('click', function() {
        promotionBanner.classList.add('hidden');
        localStorage.setItem('promotionBannerDismissed', 'true');
    });
    
    // Auto-refresh promotions every 30 seconds
    setInterval(checkExistingPromotions, 30000);

    // Apply promotion button click
    applyPromotionBtn.addEventListener('click', function() {
        applyPromotion();
    });

    // Remove promotion button click
    removePromotionBtn.addEventListener('click', function() {
        removePromotion();
    });

    function applyPromotion() {
        applyPromotionBtn.disabled = true;
        applyPromotionBtn.innerHTML = '<svg class="animate-spin w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Đang áp dụng...';

        fetch('{{ route("promotions.apply") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPromotionSuccess(data);
                showToast('success', data.message);
            } else {
                showToast('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Có lỗi xảy ra khi áp dụng khuyến mãi');
        })
        .finally(() => {
            applyPromotionBtn.disabled = false;
            applyPromotionBtn.innerHTML = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Áp dụng khuyến mãi';
        });
    }

    function removePromotion() {
        removePromotionBtn.disabled = true;
        removePromotionBtn.innerHTML = '<svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

        fetch('{{ route("promotions.remove") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                hidePromotionInfo();
                showToast('success', data.message);
            } else {
                showToast('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', '{{ __('app.promotion_error') }}');
        })
        .finally(() => {
            removePromotionBtn.disabled = false;
            removePromotionBtn.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        });
    }

        function showPromotionSuccess(data) {
        // Show promotion info
        promotionInfo.classList.remove('hidden');
        
        // Display applied promotions
        appliedPromotions.innerHTML = '';
        data.applied_promotions.forEach(promotion => {
            const promotionElement = document.createElement('div');
            promotionElement.className = 'flex items-center justify-between text-xs bg-white dark:bg-gray-800 p-2 rounded-lg';
            promotionElement.innerHTML = `
                <div>
                    <div class="font-medium text-gray-900 dark:text-white">${promotion.product_name}</div>
                    <div class="text-gray-500 dark:text-gray-400">{{ __('app.discount_percentage', ['percentage' => '']) }}${promotion.discount_percentage}%</div>
                </div>
                <div class="text-right">
                    <div class="text-green-600 dark:text-green-400 font-medium">-${formatCurrency(promotion.total_discount)}</div>
                </div>
            `;
            appliedPromotions.appendChild(promotionElement);
        });

        // Update totals
        totalSavings.textContent = formatCurrency(data.total_discount);
        finalTotal.textContent = formatCurrency(calculateFinalTotal(data.total_discount));
        
        // Show discounted total and savings
        discountedTotal.classList.remove('hidden');
        document.getElementById('total-savings').classList.remove('hidden');
        document.getElementById('savings-amount').textContent = formatCurrency(data.total_discount);
        
        // Update button states
        applyPromotionBtn.classList.add('hidden');
        removePromotionBtn.classList.remove('hidden');
        
        // Add success animation
        promotionInfo.classList.add('promotion-pulse');
        setTimeout(() => {
            promotionInfo.classList.remove('promotion-pulse');
        }, 2000);
    }

    function hidePromotionInfo() {
        promotionInfo.classList.add('hidden');
        discountedTotal.classList.add('hidden');
        document.getElementById('total-savings').classList.add('hidden');
        applyPromotionBtn.classList.remove('hidden');
        removePromotionBtn.classList.add('hidden');
    }

    function checkExistingPromotions() {
        // Check if there are promotions in session
        fetch('{{ route("promotions.current") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.promotions.length > 0) {
                // Kiểm tra xem có sản phẩm nào trong giỏ hàng có khuyến mãi không
                const cartItems = @json($cartItems);
                const hasPromotionItems = cartItems.some(item => {
                    return data.promotions.some(promotion => 
                        promotion.product_id === item.product_id
                    );
                });
                
                // Đếm số khuyến mãi có thể áp dụng
                const applicablePromotions = data.promotions.filter(promotion => {
                    return cartItems.some(item => promotion.product_id === item.product_id);
                });
                
                if (hasPromotionItems) {
                    promotionStatus.textContent = `${applicablePromotions.length} {{ __('app.promotion_available') }}`;
                    applyPromotionBtn.classList.add('promotion-pulse');
                    
                    // Show promotion badges for applicable products
                    applicablePromotions.forEach(promotion => {
                        const badge = document.querySelector(`.promotion-badge-${promotion.product_id}`);
                        if (badge) {
                            badge.classList.remove('hidden');
                        }
                    });
                    
                    // Show promotion banner if not dismissed
                    if (!localStorage.getItem('promotionBannerDismissed')) {
                        promotionBanner.classList.remove('hidden');
                        promotionBanner.classList.add('animate-bounce');
                        setTimeout(() => {
                            promotionBanner.classList.remove('animate-bounce');
                        }, 2000);
                    }
                } else {
                    promotionStatus.textContent = '{{ __('app.no_promotion_available') }}';
                    promotionBanner.classList.add('hidden');
                    
                    // Hide all promotion badges
                    document.querySelectorAll('[class*="promotion-badge-"]').forEach(badge => {
                        badge.classList.add('hidden');
                    });
                }
            } else {
                promotionStatus.textContent = '{{ __('app.no_promotion_available') }}';
                promotionBanner.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error checking promotions:', error);
            promotionStatus.textContent = '{{ __('app.no_promotion_available') }}';
        });
    }

    function calculateFinalTotal(discount) {
        const currentTotal = parseFloat(cartTotal.textContent.replace(/[^\d]/g, ''));
        return currentTotal - discount;
    }

    function formatCurrency(amount) {
        const locale = '{{ app()->getLocale() }}';
        if (locale === 'en') {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount / 25000); // Convert VND to USD for English
        } else {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        }
    }

    function showToast(type, message) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
        
        if (type === 'success') {
            toast.classList.add('bg-green-500', 'text-white');
        } else {
            toast.classList.add('bg-red-500', 'text-white');
        }
        
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path>
                </svg>
                ${message}
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Animate out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
});
</script>
@endsection
