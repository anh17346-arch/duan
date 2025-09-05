@extends('layouts.app')

@section('title', 'Sản phẩm đang giảm giá - Perfume Luxury')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-rose-50 via-pink-50/30 to-rose-50/40 dark:from-slate-900 dark:via-rose-900/20 dark:to-slate-900">
    <!-- Header Section -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-rose-200/60 dark:border-rose-700/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <!-- Back Button -->
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-2xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                
                <!-- Sale Info -->
                <div class="text-center">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-rose-600 via-pink-600 to-rose-700 dark:from-rose-400 dark:via-pink-400 dark:to-rose-300 bg-clip-text text-transparent">
                         Sản phẩm đang giảm giá
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-2 px-4 py-2 bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 rounded-xl">
                        Ưu đãi hấp dẫn không thể bỏ qua
                    </p>
                </div>
                
                <!-- Sale Stats -->
                <div class="text-right">
                    <div class="px-4 py-2 bg-gradient-to-br from-rose-50 to-pink-100 dark:from-rose-900/20 dark:to-pink-800/30 rounded-xl border border-rose-200/50 dark:border-rose-700/50">
                        <div class="text-sm text-slate-600 dark:text-slate-400">
                            <span class="font-bold text-rose-600 dark:text-rose-400">{{ $stats['total'] }}</span> sản phẩm giảm giá
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-500 mt-1">
                            {{ $stats['sale_percentage'] }}% tổng sản phẩm
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sale Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($products->count() > 0)
            <!-- Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    @include('partials.product-card', [
                        'product' => $product,
                        'promotionService' => $promotionService
                    ])
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- No Results -->
            <div class="text-center py-20">
                <div class="w-32 h-32 mx-auto mb-8 p-6 bg-gradient-to-br from-rose-100 to-pink-200 dark:from-rose-700 dark:to-pink-600 rounded-3xl shadow-lg">
                    <svg class="w-full h-full text-rose-400 dark:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 dark:from-rose-400 dark:to-pink-400 bg-clip-text text-transparent mb-3">
                    {{ __('app.no_products_found') }}
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                    {{ __('app.try_changing_filters') }}
                </p>
                <a href="{{ route('categories.index') }}" 
                   class="px-8 py-4 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                    {{ __('app.back_to_home') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
