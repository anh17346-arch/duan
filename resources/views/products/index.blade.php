@extends('layouts.app')

@section('title', __('app.products') . ' - Perfume Luxury')

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

<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('app.products') }}</h1>
        <p class="text-slate-600 dark:text-slate-400">{{ __('app.discover_perfume_collection') }}</p>
    </div>

    <!-- Advanced Filter System -->
    <div class="backdrop-blur-md bg-white/25 dark:bg-white/10 rounded-3xl p-8 mb-12 shadow-2xl border border-white/40 dark:border-white/20">
        <form method="GET" class="space-y-8" id="filter-form">
            <!-- Primary Search Section -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-3">{{ __('app.discover_perfume_collection') }}</h2>
                <p class="text-slate-600 dark:text-slate-400">{{ __('app.find_perfect_fragrance') }}</p>
            </div>

            <!-- Main Search Bar -->
            <div class="max-w-2xl mx-auto relative">
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" 
                           class="w-full px-6 py-4 pr-16 rounded-2xl border-0 bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 text-lg font-medium shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300"
                           placeholder="{{ __('app.search_placeholder') }}">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-3 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Scientific Filter Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Category Filter -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">{{ __('app.category') }}</label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl border-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm text-slate-900 dark:text-slate-100 shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300 font-medium">
                        <option value="" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id) class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">
                                {{ $category->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Brand Filter -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">{{ __('app.brand') }}</label>
                    <select name="brand" class="w-full px-4 py-3 rounded-xl border-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm text-slate-900 dark:text-slate-100 shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300 font-medium">
                        <option value="" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.all_brands') }}</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" @selected(request('brand') == $brand) class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">
                                {{ $brand }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Gender Filter -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">{{ __('app.gender') }}</label>
                    <select name="gender" class="w-full px-4 py-3 rounded-xl border-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm text-slate-900 dark:text-slate-100 shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300 font-medium">
                        <option value="" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.all') }}</option>
                        <option value="male" @selected(request('gender') == 'male') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.male') }}</option>
                        <option value="female" @selected(request('gender') == 'female') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.female') }}</option>
                        <option value="unisex" @selected(request('gender') == 'unisex') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.unisex') }}</option>
                    </select>
                </div>
                
                <!-- Price Range -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wide">{{ __('app.price_range') }}</label>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" 
                               placeholder="{{ __('app.from') }}" min="0"
                               class="w-full px-4 py-3 rounded-xl border-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300 font-medium text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" 
                               placeholder="{{ __('app.to') }}" min="0"
                               class="w-full px-4 py-3 rounded-xl border-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300 font-medium text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                </div>
            </div>
            
            <!-- Premium Quick Filter Tags -->
            <div class="flex flex-wrap justify-center gap-4">
                <label class="group relative">
                    <input type="checkbox" name="on_sale" value="1" @checked(request('on_sale')) class="sr-only peer">
                    <div class="px-6 py-3 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-white/30 dark:border-slate-600/30 text-slate-700 dark:text-slate-300 font-medium cursor-pointer transition-all duration-300 hover:bg-white/70 dark:hover:bg-slate-800/70 hover:shadow-lg peer-checked:bg-gradient-to-r peer-checked:from-rose-500 peer-checked:to-pink-600 peer-checked:text-white peer-checked:shadow-xl peer-checked:scale-105 select-none">
                        {{ __('app.on_sale') }}
                    </div>
                </label>
                
                <label class="group relative">
                    <input type="checkbox" name="featured" value="1" @checked(request('featured')) class="sr-only peer">
                    <div class="px-6 py-3 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-white/30 dark:border-slate-600/30 text-slate-700 dark:text-slate-300 font-medium cursor-pointer transition-all duration-300 hover:bg-white/70 dark:hover:bg-slate-800/70 hover:shadow-lg peer-checked:bg-gradient-to-r peer-checked:from-amber-500 peer-checked:to-orange-600 peer-checked:text-white peer-checked:shadow-xl peer-checked:scale-105 select-none">
                        {{ __('app.featured_products') }}
                    </div>
                </label>
                
                <label class="group relative">
                    <input type="checkbox" name="new" value="1" @checked(request('new')) class="sr-only peer">
                    <div class="px-6 py-3 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-white/30 dark:border-slate-600/30 text-slate-700 dark:text-slate-300 font-medium cursor-pointer transition-all duration-300 hover:bg-white/70 dark:hover:bg-slate-800/70 hover:shadow-lg peer-checked:bg-gradient-to-r peer-checked:from-emerald-500 peer-checked:to-teal-600 peer-checked:text-white peer-checked:shadow-xl peer-checked:scale-105 select-none">
                        {{ __('app.new_arrivals') }}
                    </div>
                </label>
                
                <label class="group relative">
                    <input type="checkbox" name="best_seller" value="1" @checked(request('best_seller')) class="sr-only peer">
                    <div class="px-6 py-3 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border border-white/30 dark:border-slate-600/30 text-slate-700 dark:text-slate-300 font-medium cursor-pointer transition-all duration-300 hover:bg-white/70 dark:hover:bg-slate-800/70 hover:shadow-lg peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-purple-600 peer-checked:text-white peer-checked:shadow-xl peer-checked:scale-105 select-none">
                        {{ __('app.best_sellers') }}
                    </div>
                </label>
            </div>
            
            <!-- Advanced Clear Filters Section -->
            @if(request()->hasAny(['q', 'category', 'brand', 'gender', 'min_price', 'max_price', 'on_sale', 'featured', 'new', 'best_seller']))
                <div class="flex justify-center items-center pt-6 border-t border-white/20 dark:border-slate-600/20">
                    <div class="text-center space-y-3">
                        <div class="text-sm text-slate-600 dark:text-slate-400 font-medium">
                            {{ __('app.filters_applied', ['count' => count(array_filter(request()->only(['q', 'category', 'brand', 'gender', 'min_price', 'max_price', 'on_sale', 'featured', 'new', 'best_seller'])))]) }}
                        </div>
                        <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-2 px-6 py-3 bg-rose-500/80 hover:bg-rose-600 text-white rounded-full transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl backdrop-blur-sm font-medium">
                            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ __('app.clear_all_filters') }}
                        </a>
                    </div>
                </div>
            @endif
        </form>
    </div>

    <!-- Premium Products Showcase -->
    @if($products->count() > 0)
        <!-- Results Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200">{{ __('app.products') }}</h2>
                <p class="text-slate-600 dark:text-slate-400">{{ $products->total() }} {{ __('app.products_found') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <label class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.sort_by') }}:</label>
                <select onchange="this.form.submit()" name="sort" form="filter-form" class="px-4 py-2 rounded-xl border-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-sm text-slate-900 dark:text-slate-100 shadow-lg focus:ring-4 focus:ring-brand-500/30 focus:bg-white dark:focus:bg-slate-800 transition-all duration-300 font-medium text-sm">
                    <option value="newest" @selected(request('sort') == 'newest') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.newest') }}</option>
                    <option value="price_low" @selected(request('sort') == 'price_low') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.price_low_to_high') }}</option>
                    <option value="price_high" @selected(request('sort') == 'price_high') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.price_high_to_low') }}</option>
                    <option value="name" @selected(request('sort') == 'name') class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.name_a_z') }}</option>
                </select>
            </div>
        </div>

        <!-- Scientific Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="group relative backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-3xl overflow-hidden shadow-xl border border-white/40 dark:border-white/20 hover:bg-white/40 dark:hover:bg-white/15 hover:shadow-2xl hover:scale-[1.02] transition-all duration-500 h-full flex flex-col">
                    <!-- Product Image Container -->
                    <div class="relative aspect-square overflow-hidden">
                        <img src="{{ $product->main_image_url }}" 
                             alt="{{ $product->display_name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        <!-- Product Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($product->is_featured)
                                <span class="px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    {{ __('app.featured') }}
                                </span>
                            @endif
                            @if($promotionService && $promotionService->isProductOnSale($product))
                                <span class="px-3 py-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    -{{ $promotionService->getDiscountPercentage($product) }}%
                                </span>
                            @endif
                            @if($product->is_new)
                                <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    {{ __('app.new') }}
                                </span>
                            @endif
                        </div>

                        <!-- Category Badge -->
                        <div class="absolute top-4 right-4">
                            @if($product->category)
                                <span class="px-3 py-1 bg-black/20 backdrop-blur-sm text-white text-xs font-medium rounded-full border border-white/30">
                                    {{ $product->category->display_name }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-slate-500/20 backdrop-blur-sm text-white text-xs font-medium rounded-full border border-slate-400/30">
                                    {{ __('app.no_category') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Product Information -->
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Product Title & Brand -->
                        <div class="space-y-2 mb-4">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 text-lg leading-tight line-clamp-2 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors duration-300">
                                {{ $product->display_name }}
                            </h3>
                            @if($product->brand)
                                <p class="text-sm text-slate-600 dark:text-slate-400 font-medium uppercase tracking-wide">{{ $product->brand }}</p>
                            @endif
                        </div>
                        
                        <!-- Product Details Grid -->
                        <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0v-4"></path>
                                </svg>
                                <span class="font-medium">{{ $product->volume_ml }}ml</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">
                                    @switch($product->gender)
                                        @case('male') {{ __('app.male') }} @break
                                        @case('female') {{ __('app.female') }} @break
                                        @default {{ __('app.unisex') }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        
                        <!-- Pricing Section - Takes available space -->
                        <div class="flex-grow flex flex-col justify-center mb-6">
                            @if($promotionService && $promotionService->isProductOnSale($product))
                                <div class="space-y-1">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl font-bold text-brand-600 dark:text-brand-400">
                                            @if(app()->getLocale() === 'en')
                                                ${{ number_format($promotionService->getFinalPrice($product) / 25000, 2) }}
                                            @else
                                                {{ number_format($promotionService->getFinalPrice($product), 0, ',', '.') }}đ
                                            @endif
                                        </span>
                                        <span class="text-lg text-slate-400 line-through font-medium">
                                            @if(app()->getLocale() === 'en')
                                                ${{ number_format($product->price / 25000, 2) }}
                                            @else
                                                {{ number_format($product->price, 0, ',', '.') }}đ
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-sm text-emerald-600 dark:text-emerald-400 font-medium">{{ __('app.save') }} 
                                        @if(app()->getLocale() === 'en')
                                            ${{ number_format(($product->price - $product->final_price) / 25000, 2) }}
                                        @else
                                            {{ number_format($product->price - $product->final_price, 0, ',', '.') }}đ
                                        @endif
                                    </p>
                                </div>
                            @else
                                <span class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($product->price / 25000, 2) }}
                                    @else
                                        {{ number_format($product->price, 0, ',', '.') }}đ
                                    @endif
                                </span>
                            @endif
                        </div>
                        
                        <!-- Action Button - Fixed at bottom -->
                        <div class="mt-auto">
                            <a href="{{ route('products.show', $product) }}" 
                               class="group/btn relative w-full inline-flex items-center justify-center gap-3 px-6 py-4 bg-white/90 dark:bg-white/80 text-slate-800 dark:text-slate-900 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl border border-slate-200/50 dark:border-slate-300/50 hover:bg-white dark:hover:bg-white overflow-hidden whitespace-nowrap">
                                <!-- Shimmer effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span class="relative z-10 flex-shrink-0">{{ __('app.view_details') }}</span>
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
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
                                      <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-2">
               {{ __('app.no_products_found') }}
             </h3>
             <p class="text-slate-600 dark:text-slate-400">
               {{ __('app.try_changing_filters') }}
             </p>
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
