@extends('layouts.app')

@section('title', $category->name . ' - Perfume Luxury')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600">Trang chủ</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-brand-600">Sản phẩm</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ $category->name }}</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">{{ $category->name }}</h1>
        <p class="text-slate-600 dark:text-slate-400">Khám phá bộ sưu tập {{ strtolower($category->name) }} đa dạng</p>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-shadow h-full flex flex-col">
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ $product->main_image_url }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <div class="p-4 flex-grow flex flex-col">
                        <div class="mb-2 h-[1.8rem] flex items-center">
                            <span class="inline-block px-2 py-1 text-xs bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 line-clamp-2 h-[2.5rem] flex items-start">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="mb-2 h-[1.2rem] flex items-center">
                            @if($product->brand)
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $product->brand }}</p>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between mb-3 h-[1.2rem]">
                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $product->volume_ml }}ml
                            </div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                @switch($product->gender)
                                    @case('male') Nam @break
                                    @case('female') Nữ @break
                                    @default Unisex
                                @endswitch
                            </div>
                        </div>
                        
                        <div class="mb-4 min-h-[3.5rem] flex items-start">
                            @if($product->is_on_sale)
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg font-bold text-brand-600">
                                            {{ number_format($product->final_price, 0, ',', '.') }}đ
                                        </span>
                                        <span class="text-sm text-slate-400 line-through">
                                            {{ number_format($product->price, 0, ',', '.') }}đ
                                        </span>
                                    </div>
                                    <span class="text-xs bg-rose-100 text-rose-600 px-2 py-1 rounded-full w-fit">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @else
                                <span class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-slate-500 dark:text-slate-400">
                                @if($product->stock > 0)
                                    <span class="text-green-600">Còn hàng</span>
                                @else
                                    <span class="text-rose-600">Hết hàng</span>
                                @endif
                            </span>
                            
                            @if($product->origin)
                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $product->origin }}</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('products.show', $product) }}" 
                           class="group/btn relative w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white/90 dark:bg-white/80 text-slate-800 dark:text-slate-900 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl border border-slate-200/50 dark:border-slate-300/50 hover:bg-white dark:hover:bg-white overflow-hidden whitespace-nowrap mt-auto">
                            <!-- Shimmer effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                            
                            <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span class="relative z-10 flex-shrink-0">{{ __('app.view_details') }}</span>
                            <svg class="w-3 h-3 group-hover/btn:translate-x-1 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-slate-400 dark:text-slate-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-2">Chưa có sản phẩm nào</h3>
            <p class="text-slate-600 dark:text-slate-400">Danh mục {{ $category->name }} chưa có sản phẩm nào</p>
            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg transition-colors">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
