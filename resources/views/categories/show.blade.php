@extends('layouts.app')
@section('title', $category->display_name)

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
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600">Trang chủ</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('categories.index') }}" class="hover:text-brand-600">Danh mục</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ $category->display_name }}</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-200 mb-2">{{ $category->display_name }}</h1>
                 <p class="text-slate-600 dark:text-slate-400">
           {{ __('app.explore_category_collection', ['category' => strtolower($category->display_name)]) }}
         </p>
    </div>

    <!-- Category Info -->
    <div class="backdrop-blur-md bg-white/25 dark:bg-white/10 rounded-3xl p-8 shadow-2xl border border-white/40 dark:border-white/20 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-brand-600">{{ $category->products_count ?? 0 }}</div>
                                 <div class="text-sm text-slate-600 dark:text-slate-400">
                   {{ __('app.products') }}
                 </div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-slate-600 dark:text-slate-400">{{ $category->created_at->format('d/m/Y') }}</div>
                                 <div class="text-sm text-slate-600 dark:text-slate-400">
                   {{ __('app.created_date') }}
                 </div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-slate-600 dark:text-slate-400">{{ $category->updated_at->format('d/m/Y') }}</div>
                                 <div class="text-sm text-slate-600 dark:text-slate-400">
                   {{ __('app.updated_date') }}
                 </div>
            </div>
        </div>
        
        @auth
            @if(auth()->user()->role === 'admin')
                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 flex justify-center">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-medium transition-colors">
                                                 ✏️ {{ __('app.edit_category') }}
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Products Section - Chỉ hiển thị sản phẩm của danh mục hiện tại -->

    <!-- Products Section -->
    @if($products->count() > 0)
        <div class="backdrop-blur-md bg-white/25 dark:bg-white/10 rounded-3xl p-8 shadow-2xl border border-white/40 dark:border-white/20">
            <div class="flex items-center justify-between mb-6">
                                 <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-200">
                   {{ __('app.products_in_category') }}
                 </h2>
                 <span class="text-sm text-slate-600 dark:text-slate-400">
                   {{ __('app.products_count', ['count' => $products->total()]) }}
                 </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="group relative backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-3xl overflow-hidden shadow-xl border border-white/40 dark:border-white/20 hover:bg-white/40 dark:hover:bg-white/15 hover:shadow-2xl hover:scale-[1.02] transition-all duration-500 h-full flex flex-col">
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
            @if($products->hasPages())
                <div class="mt-8">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="backdrop-blur-md bg-white/25 dark:bg-white/10 rounded-3xl p-12 text-center shadow-2xl border border-white/40 dark:border-white/20">
            <div class="text-slate-400 dark:text-slate-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
                         <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-2">
               {{ __('app.no_products_in_category') }}
             </h3>
             <p class="text-slate-600 dark:text-slate-400 mb-6">
               {{ __('app.category_has_no_products', ['category' => $category->display_name]) }}
             </p>
            <div class="flex flex-wrap gap-4 justify-center">
                                                  <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-medium transition-colors">
                   {{ __('app.view_all_products') }}
                 </a>
                 <a href="{{ route('categories.index') }}" class="inline-block px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                   {{ __('app.back_to_categories') }}
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
