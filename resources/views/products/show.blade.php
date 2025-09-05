@extends('layouts.app')

@section('title', $product->name . ' - Perfume Luxury')

@section('content')
<!-- Modern Unified Background (giống cart và orders) -->
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
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600 transition-colors">{{ __('app.home') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-brand-600 transition-colors">{{ __('app.products') }}</a></li>
                <li><span class="mx-2">/</span></li>
                @if($product->category)
                    <li><a href="{{ route('products.category', $product->category) }}" class="hover:text-brand-600 transition-colors">{{ $product->category->display_name }}</a></li>
                @else
                    <li class="text-slate-500 dark:text-slate-400">{{ __('app.no_category') }}</li>
                @endif
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ $product->display_name }}</li>
            </ol>
        </nav>

        <!-- Main Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mb-12">
            <!-- Product Image Gallery - Larger column -->
            <div class="lg:col-span-1 space-y-4 max-w-lg mx-auto lg:max-w-none">
                <!-- Main Image with navigation - Square size -->
                <div class="relative aspect-square overflow-hidden rounded-2xl shadow-2xl border border-white/40 dark:border-white/20 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900">
                    <img id="main-product-image" src="{{ $product->main_image_url }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover object-center cursor-zoom-in transition-all duration-500 hover:scale-105">
                    
                    <!-- Navigation Arrows -->
                    <button type="button" aria-label="{{ __('app.previous_image') }}" onclick="galleryPrev()" 
                            class="absolute left-3 top-1/2 -translate-y-1/2 backdrop-blur-sm bg-white/80 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button" aria-label="{{ __('app.next_image') }}" onclick="galleryNext()" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 backdrop-blur-sm bg-white/80 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($product->has_gallery && ($product->images->count() > 0 || $product->main_image))
                    <div id="thumbnails" class="grid grid-cols-5 gap-2">
                        <!-- Main Image Thumbnail -->
                        @if($product->main_image)
                            <button type="button" 
                                    data-index="main"
                                    data-image-url="{{ $product->main_image_url }}"
                                    onclick="changeMainImage(this.dataset.imageUrl, this)"
                                    class="aspect-square overflow-hidden rounded-xl border-2 border-brand-500 dark:border-brand-400 hover:border-brand-600 dark:hover:border-brand-300 transition-all duration-300 hover:scale-105 shadow-lg main-image-thumb">
                                <img src="{{ $product->main_image_url }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </button>
                        @endif
                        
                        <!-- Gallery Images -->
                        @foreach($product->images as $idx => $image)
                            <button type="button" 
                                    data-index="{{ $idx }}"
                                    data-image-url="{{ $image->image_url }}"
                                    onclick="changeMainImage(this.dataset.imageUrl, this)"
                                    class="aspect-square overflow-hidden rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-500 dark:hover:border-brand-400 transition-all duration-300 hover:scale-105 shadow-lg">
                                <img src="{{ $image->thumbnail_url }}" 
                                     alt="{{ $image->alt_text ?? $product->name }}"
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info - Right column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Compact Header Section -->
                <div class="backdrop-blur-sm bg-white/40 dark:bg-white/10 rounded-2xl p-6 border border-white/50 dark:border-white/20 shadow-lg space-y-4">
                    <!-- Category & Brand -->
                    <div class="flex items-center gap-2">
                        @if($product->category)
                            <span class="inline-block px-3 py-1 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 rounded-full text-xs font-semibold border border-brand-200 dark:border-brand-800/50">
                                {{ $product->category->display_name }}
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-full text-xs font-semibold border border-slate-200 dark:border-slate-600">
                                {{ __('app.no_category') }}
                            </span>
                        @endif
                        @if($product->brand)
                            <span class="inline-block px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full text-xs font-medium border border-slate-200 dark:border-slate-600">
                                {{ $product->brand }}
                            </span>
                        @endif
                        <span class="inline-block px-2 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-full text-xs font-bold animate-pulse" id="sale-badge" style="display: {{ $promotionService->isProductOnSale($product) ? 'inline-block' : 'none' }};">
                            SALE
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 leading-tight">{{ $product->display_name }}</h1>

                    <!-- Short Description -->
                    @if($product->display_short_description)
                        <div class="p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                            <p class="text-slate-600 dark:text-slate-300 text-base leading-relaxed">
                                {{ $product->display_short_description }}
                            </p>
                        </div>
                    @endif

                    <!-- Price Section with Real-time Update -->
                    <div class="space-y-2" id="price-section" data-product-id="{{ $product->id }}">
                        <!-- Sale Price Display (always present, controlled by JavaScript) -->
                        <div class="flex items-baseline gap-3" id="sale-price-display" style="display: {{ $promotionService->isProductOnSale($product) ? 'flex' : 'none' }};">
                            <span class="text-2xl font-bold text-rose-600" id="final-price">
                                @if(app()->getLocale() === 'en')
                                    ${{ number_format($promotionService->getFinalPrice($product) / 25000, 2) }}
                                @else
                                    {{ number_format($promotionService->getFinalPrice($product), 0, ',', '.') }}đ
                                @endif
                            </span>
                            <span class="text-lg text-slate-400 line-through" id="original-price">
                                @if(app()->getLocale() === 'en')
                                    ${{ number_format($product->price / 25000, 2) }}
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                @endif
                            </span>
                            <span class="px-2 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-full text-xs font-bold" id="discount-badge">
                                -{{ $promotionService->getDiscountPercentage($product) }}%
                            </span>
                        </div>
                        
                        <!-- Regular Price Display (always present, controlled by JavaScript) -->
                        <span class="text-2xl font-bold text-slate-900 dark:text-slate-100" id="regular-price" style="display: {{ $promotionService->isProductOnSale($product) ? 'none' : 'block' }};">
                            @if(app()->getLocale() === 'en')
                                ${{ number_format($product->price / 25000, 2) }}
                            @else
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            @endif
                        </span>
                    </div>

                    <!-- Promotion Quantity Info -->
                    @php
                        $quantityInfo = $promotionService->getPromotionQuantityInfo($product);
                        $showQuantityInfo = $promotionService->isProductOnSale($product) && $quantityInfo && $quantityInfo['has_limit'];
                    @endphp
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg" id="quantity-info" style="display: {{ $showQuantityInfo ? 'block' : 'none' }};">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-amber-700 dark:text-amber-300">
                                <strong>{{ __('app.remaining_quantity') }}:</strong> 
                                <span id="remaining-quantity">{{ $quantityInfo ? $quantityInfo['remaining_quantity'] : 0 }}</span>
                            </span>
                            <span class="text-sm text-amber-600 dark:text-amber-400">
                                {{ __('app.sold_quantity') }}: <span id="sold-quantity">{{ $quantityInfo ? $quantityInfo['sold_quantity'] : 0 }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Upcoming Promotion Info -->
                    @if($promotionService->getUpcomingPromotionInfo($product))
                        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                    Khuyến mãi sắp diễn ra
                                </span>
                            </div>
                            <div class="text-sm text-blue-600 dark:text-blue-400">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold">-{{ $promotionService->getUpcomingPromotionInfo($product)['discount_percentage'] }}%</span>
                                    <span>từ {{ $promotionService->getUpcomingPromotionInfo($product)['formatted_start_date'] }}</span>
                                </div>
                                <div class="text-xs">
                                    Kết thúc: {{ $promotionService->getUpcomingPromotionInfo($product)['formatted_end_date'] }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Essential Product Info -->
                <div class="flex flex-wrap items-center gap-2 p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                    <!-- Volume -->
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded text-xs font-medium">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        {{ $product->volume_ml }}ml
                    </span>

                    <!-- Gender -->
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded text-xs font-medium">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        @switch($product->gender)
                            @case('male') Nam @break
                            @case('female') Nữ @break
                            @default Unisex
                        @endswitch
                    </span>

                    <!-- Stock Status -->
                    @if($product->stock > 0)
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded text-xs font-medium">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            {{ __('app.remaining') }} {{ $product->stock }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded text-xs font-medium">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            {{ __('app.out_of_stock') }}
                        </span>
                    @endif

                    <!-- Origin (if exists) -->
                    @if($product->origin)
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 rounded text-xs font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $product->origin }}
                        </span>
                    @endif
                </div>

                <!-- Mini Stats Section -->
                <div class="flex items-center justify-between p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                    <!-- Views -->
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="text-xs text-slate-600 dark:text-slate-400">{{ $product->formatted_views }} {{ __('app.views') }}</span>
                    </div>

                    <!-- Sales -->
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="text-xs text-slate-600 dark:text-slate-400">{{ $product->formatted_sold }} {{ __('app.sold') }}</span>
                    </div>
                </div>

                <!-- Streamlined Purchase Section -->
                <div class="space-y-3">
                    @if($product->stock > 0)
                        <form method="POST" action="{{ route('cart.add') }}" class="space-y-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <!-- Inline Quantity & Buttons -->
                            <div class="space-y-3">
                                <!-- Quantity Selector -->
                                <div class="flex items-center justify-center">
                                    <div class="flex items-center bg-slate-100 dark:bg-slate-700 rounded-lg overflow-hidden">
                                        <button type="button" onclick="changeQuantity(-1)" class="px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                               class="w-12 text-center border-0 focus:ring-0 bg-transparent text-slate-900 dark:text-slate-100 text-sm">
                                        <button type="button" onclick="changeQuantity(1)" class="px-3 py-2 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="grid grid-cols-2 gap-2">
                                    <!-- Add to Cart Button -->
                                    <button type="submit" class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg font-medium transition-all duration-300 text-sm">
                                        🛒 {{ __('app.add_to_cart') }}
                                    </button>
                                    
                                    <!-- Buy Now Button -->
                                    <button type="button" onclick="buyNow()" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-medium transition-all duration-300 text-sm">
                                        💸 {{ __('app.buy_now') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Quick Actions -->
                        <div class="flex items-center gap-2">
                            <button class="flex-1 px-3 py-2 border border-rose-300 text-rose-600 hover:bg-rose-50 rounded-lg font-medium transition-all duration-300 text-xs">
                                ❤️ {{ __('app.favorite') }}
                            </button>
                            <button class="flex-1 px-3 py-2 border border-blue-300 text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300 text-xs">
                                📤 {{ __('app.share') }}
                            </button>
                        </div>
                    @else
                        <button class="w-full px-4 py-3 bg-slate-400 text-white rounded-lg font-medium cursor-not-allowed text-sm" disabled>
                            {{ __('app.out_of_stock') }}
                        </button>
                    @endif

                    <!-- Low Stock Alert -->
                    @if($product->stock <= 10 && $product->stock > 0)
                        <div class="flex items-center gap-2 p-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                            <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-amber-700 dark:text-amber-300 text-xs">Chỉ còn {{ $product->stock }} sản phẩm!</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Description -->
        @if($product->description)
            <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-8 shadow-lg border border-white/40 dark:border-white/20 mb-12">
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-200 mb-6">{{ __('app.product_description') }}</h2>
                <div class="prose prose-slate dark:prose-invert max-w-none text-base leading-relaxed">
                    {!! nl2br(e($product->display_description)) !!}
                </div>
            </div>
        @endif

        <!-- Product Reviews -->
        <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-8 shadow-lg border border-white/40 dark:border-white/20 mb-12">
            <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-200 mb-6">{{ __('app.product_reviews') }}</h2>
            
            <!-- Reviews Summary with Expandable Panel -->
            @include('products.partials.reviews-summary')
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-8 shadow-lg border border-white/40 dark:border-white/20">
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-200 mb-8">{{ __('app.related_products') }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl overflow-hidden shadow-lg border border-white/40 dark:border-white/20 hover:shadow-2xl hover:bg-white/40 dark:hover:bg-white/15 transition-all duration-300 h-full flex flex-col group">
                            <div class="aspect-square overflow-hidden">
                                <img src="{{ $relatedProduct->main_image_url }}" 
                                     alt="{{ $relatedProduct->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            
                            <div class="p-4 flex-grow flex flex-col">
                                <div class="mb-2 h-[1.8rem] flex items-center">
                                    @if($relatedProduct->category)
                                        <span class="inline-block px-2 py-1 text-xs bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 rounded-full font-medium">
                                            {{ $relatedProduct->category->display_name }}
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 rounded-full font-medium">
                                            {{ __('app.no_category') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 line-clamp-2 text-sm h-[2.5rem] flex items-start">
                                    {{ $relatedProduct->name }}
                                </h3>
                                
                                <div class="mb-2 h-[1.2rem] flex items-center">
                                    @if($relatedProduct->brand)
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ $relatedProduct->brand }}</p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between mb-3 h-[1.2rem]">
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $relatedProduct->volume_ml }}ml
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        @switch($relatedProduct->gender)
                                            @case('male') Nam @break
                                            @case('female') Nữ @break
                                            @default Unisex
                                        @endswitch
                                    </div>
                                </div>
                                
                                <div class="mb-4 min-h-[3rem] flex items-start">
                                    @if($relatedProduct->is_on_sale)
                                        <div class="flex flex-col gap-1">
                                            <span class="text-lg font-bold text-brand-600">
                                                {{ number_format($relatedProduct->final_price, 0, ',', '.') }}đ
                                            </span>
                                            <span class="text-sm text-slate-400 line-through">
                                                {{ number_format($relatedProduct->price, 0, ',', '.') }}đ
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                            {{ number_format($relatedProduct->price, 0, ',', '.') }}đ
                                        </span>
                                    @endif
                                </div>
                                
                                <a href="{{ route('products.show', $relatedProduct) }}" 
                                   class="group/btn relative w-full inline-flex items-center justify-center gap-2 px-3 py-2.5 bg-white/90 dark:bg-white/80 text-slate-800 dark:text-slate-900 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl border border-slate-200/50 dark:border-slate-300/50 hover:bg-white dark:hover:bg-white overflow-hidden whitespace-nowrap text-sm mt-auto">
                                    <!-- Shimmer effect -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                    
                                    <svg class="w-3.5 h-3.5 group-hover/btn:scale-110 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="relative z-10 flex-shrink-0">{{ __('app.view_details') }}</span>
                                    <svg class="w-2.5 h-2.5 group-hover/btn:translate-x-1 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Build gallery list including main image
const galleryImages = [
    @if($product->main_image)
        '{{ $product->main_image_url }}',
    @endif
    @if($product->has_gallery && $product->images->count() > 0)
        @foreach($product->images as $image)
            '{{ $image->image_url }}',
        @endforeach
    @endif
];
let currentIndex = 0; // Start with main image (index 0)

function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    const newValue = Math.max(1, Math.min(currentValue + change, {{ $product->stock }}));
    input.value = newValue;
}

function changeMainImage(imageUrl, button) {
    // Thay đổi ảnh chính
    document.getElementById('main-product-image').src = imageUrl;
    const idx = galleryImages.indexOf(imageUrl);
    if (idx >= 0) currentIndex = idx;
    
    // Cập nhật border của thumbnail
    document.querySelectorAll('#thumbnails button').forEach(btn => {
        if (btn.classList.contains('main-image-thumb')) {
            // Main image thumb keeps brand color when not selected
            if (btn === button) {
                btn.classList.remove('border-brand-500', 'dark:border-brand-400');
                btn.classList.add('border-brand-600', 'dark:border-brand-300');
            } else {
                btn.classList.remove('border-brand-600', 'dark:border-brand-300');
                btn.classList.add('border-brand-500', 'dark:border-brand-400');
            }
        } else {
            // Gallery thumbnails
            btn.classList.remove('border-brand-500', 'dark:border-brand-400');
            btn.classList.add('border-slate-200', 'dark:border-slate-700');
        }
    });
    
    // Highlight selected thumbnail
    if (!button.classList.contains('main-image-thumb')) {
        button.classList.remove('border-slate-200', 'dark:border-slate-700');
        button.classList.add('border-brand-500', 'dark:border-brand-400');
    }
}

function galleryShow(index) {
    if (!galleryImages || galleryImages.length === 0) return;
    currentIndex = (index + galleryImages.length) % galleryImages.length;
    const url = galleryImages[currentIndex];
    const main = document.getElementById('main-product-image');
    if (main) main.src = url;
    // highlight thumbnail if exists
    const thumbnails = document.querySelectorAll('#thumbnails button');
    if (thumbnails.length) {
        thumbnails.forEach(btn => {
            btn.classList.remove('border-brand-500', 'dark:border-brand-400');
            btn.classList.add('border-slate-200', 'dark:border-slate-700');
        });
        if (thumbnails[currentIndex]) {
            thumbnails[currentIndex].classList.remove('border-slate-200', 'dark:border-slate-700');
            thumbnails[currentIndex].classList.add('border-brand-500', 'dark:border-brand-400');
        }
    }
}

function galleryPrev() { galleryShow(currentIndex - 1); }
function galleryNext() { galleryShow(currentIndex + 1); }

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') galleryPrev();
    if (e.key === 'ArrowRight') galleryNext();
});
</script>
@endsection

@push('scripts')
<script>
// Buy Now function
function buyNow() {
    const quantity = parseInt(document.getElementById('quantity')?.value) || 1;
    const productId = {{ $product->id }};
    
    // Redirect to buy-now page with quantity in URL
    window.location.href = `{{ route('checkout.buy-now.show', $product->id) }}?quantity=${quantity}`;
}

// Real-time promotion status update
let promotionUpdateInterval;

function startPromotionStatusUpdate() {
    const productId = {{ $product->id }};
    const priceSection = document.getElementById('price-section');
    
    if (!priceSection) return;
    
    // Update every 5 seconds
    promotionUpdateInterval = setInterval(async () => {
        try {
            const response = await fetch(`/api/promotion-status/${productId}`);
            const data = await response.json();
            
            updatePriceDisplay(data);
        } catch (error) {
            console.error('Error updating promotion status:', error);
        }
    }, 5000);
}

function updatePriceDisplay(data) {
    const priceSection = document.getElementById('price-section');
    const salePriceDisplay = document.getElementById('sale-price-display');
    const regularPrice = document.getElementById('regular-price');
    const finalPrice = document.getElementById('final-price');
    const originalPrice = document.getElementById('original-price');
    const discountBadge = document.getElementById('discount-badge');
    const saleBadge = document.getElementById('sale-badge');
    const quantityInfo = document.getElementById('quantity-info');
    const remainingQuantity = document.getElementById('remaining-quantity');
    const soldQuantity = document.getElementById('sold-quantity');
    
    if (data.is_on_sale) {
        // Show sale price
        if (salePriceDisplay) {
            salePriceDisplay.style.display = 'flex';
        }
        if (regularPrice) {
            regularPrice.style.display = 'none';
        }
        if (saleBadge) {
            saleBadge.style.display = 'inline-block';
        }
        
        // Update prices
        if (finalPrice) {
            finalPrice.textContent = formatPrice(data.final_price);
        }
        if (originalPrice) {
            originalPrice.textContent = formatPrice(data.original_price);
        }
        if (discountBadge) {
            discountBadge.textContent = `-${data.discount_percentage}%`;
        }
        
        // Update quantity info
        if (data.quantity_info && data.quantity_info.has_limit) {
            if (quantityInfo) {
                quantityInfo.style.display = 'block';
            }
            if (remainingQuantity) {
                remainingQuantity.textContent = data.quantity_info.remaining_quantity;
            }
            if (soldQuantity) {
                soldQuantity.textContent = data.quantity_info.sold_quantity;
            }
        } else {
            if (quantityInfo) {
                quantityInfo.style.display = 'none';
            }
        }
    } else {
        // Show regular price
        if (salePriceDisplay) {
            salePriceDisplay.style.display = 'none';
        }
        if (regularPrice) {
            regularPrice.style.display = 'block';
            regularPrice.textContent = formatPrice(data.original_price);
        }
        if (saleBadge) {
            saleBadge.style.display = 'none';
        }
        
        // Hide quantity info
        if (quantityInfo) {
            quantityInfo.style.display = 'none';
        }
    }
}

function formatPrice(price) {
    @if(app()->getLocale() === 'en')
        return `$${(price / 25000).toFixed(2)}`;
    @else
        return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
    @endif
}

// Start real-time updates when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Chạy ngay lập tức để cập nhật trạng thái ban đầu
    const productId = {{ $product->id }};
    checkPromotionStatusImmediately(productId);
    
    // Sau đó bắt đầu interval
    startPromotionStatusUpdate();
});

// Kiểm tra trạng thái khuyến mãi ngay lập tức
async function checkPromotionStatusImmediately(productId) {
    try {
        const response = await fetch(`/api/promotion-status/${productId}`);
        const data = await response.json();
        updatePriceDisplay(data);
    } catch (error) {
        console.error('Error checking initial promotion status:', error);
    }
}

// Clean up interval when page unloads
window.addEventListener('beforeunload', function() {
    if (promotionUpdateInterval) {
        clearInterval(promotionUpdateInterval);
    }
});
</script>
@endpush
