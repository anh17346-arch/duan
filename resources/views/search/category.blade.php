@extends('layouts.app')

@section('title', '{{ $category->name }} - Perfume Luxury')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50/30 to-teal-50/40 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Header Section -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-slate-200/60 dark:border-slate-700/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <!-- Back Button -->
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-2xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                
                <!-- Category Info -->
                <div class="text-center">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-300 bg-clip-text text-transparent">
                        {{ $category->name }}
                    </h1>
                    @if($category->description)
                        <p class="text-slate-600 dark:text-slate-400 mt-2 px-4 py-2 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl">
                            {{ $category->description }}
                        </p>
                    @endif
                </div>
                
                <!-- Results Count -->
                <div class="text-right">
                    <div class="text-sm text-slate-600 dark:text-slate-400">
                        Tìm thấy <span class="font-bold text-brand-600">{{ $products->total() }}</span> sản phẩm
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($products->count() > 0)
            <!-- Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
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
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 text-slate-300 dark:text-slate-600">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">
                    Không có sản phẩm nào
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-6">
                    Danh mục {{ $category->name }} chưa có sản phẩm nào
                </p>
                <a href="{{ route('categories.index') }}" 
                   class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-semibold transition-colors">
                    Về trang chủ
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
