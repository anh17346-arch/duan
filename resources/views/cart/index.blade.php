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
                                                                    class="group relative w-9 h-9 bg-slate-100 dark:bg-slate-700 hover:bg-emerald-500 dark:hover:bg-emerald-500 rounded-full transition-all duration-300 ease-out flex items-center justify-center shadow-sm hover:shadow-md hover:scale-110 transform">
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
                                                    @if($item->product->is_on_sale)
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
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_products') }}:</span>
                            <span class="text-slate-900 dark:text-slate-100">{{ auth()->user()->cart_items_count }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_amount') }}:</span>
                            <span class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ auth()->user()->cart_total_formatted }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Primary Action: Checkout -->
                        <button type="button" class="group w-full h-14 flex items-center justify-center gap-3 px-6 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <div class="relative">
                                <svg class="w-6 h-6 flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <!-- Sparkle effect -->
                                <div class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-400 rounded-full opacity-0 group-hover:opacity-100 animate-ping"></div>
                            </div>
                            <span class="leading-none">{{ __('app.proceed_to_checkout') }}</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
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
            <div class="text-slate-400 dark:text-slate-500 mb-6">
                <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.cart_empty') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8">{{ __('app.no_products_in_cart') }}</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold text-lg transition-colors">
                🛍️ {{ __('app.start_shopping') }}
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
</style>
@endsection
