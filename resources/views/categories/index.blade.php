@extends('layouts.app')
@section('title', __('app.home') . ' - Perfume Luxury')

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

  <div class="relative space-y-16 pb-16">
  <!-- Hero Banner với Search - Nhỏ gọn và mềm mại -->
  <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-800 via-blue-800 via-purple-800 to-pink-800 shadow-xl">
    <!-- Animated Background Elements - Nhẹ nhàng hơn -->
    <div class="absolute inset-0">
      <!-- Floating Orbs - Nhỏ hơn -->
      <div class="absolute top-8 left-8 w-20 h-20 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-xl animate-pulse"></div>
      <div class="absolute top-16 right-16 w-24 h-24 bg-gradient-to-r from-pink-400/20 to-rose-400/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 1.5s;"></div>
      <div class="absolute bottom-16 left-1/3 w-16 h-16 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 rounded-full blur-xl animate-pulse" style="animation-delay: 3s;"></div>
      
      <!-- Geometric Patterns - Nhẹ hơn -->
      <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-white/3 to-transparent transform rotate-45"></div>
      <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tl from-white/3 to-transparent transform -rotate-12"></div>
      
      <!-- Mesh Gradient Overlay - Nhẹ hơn -->
      <div class="absolute inset-0 bg-gradient-to-r from-blue-600/15 via-purple-600/15 to-pink-600/15"></div>
    </div>
    
    <!-- Content Container - Nhỏ gọn hơn -->
    <div class="relative px-6 py-12 text-center text-white">
      <div class="max-w-4xl mx-auto">
        <!-- Main Heading - Nhỏ gọn hơn -->
        <div class="mb-6">
          <h1 class="text-3xl md:text-5xl font-black mb-3 leading-tight tracking-tight">
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-white to-purple-200">
              @if(app()->getLocale() === 'en')
                Welcome to
              @else
                Chào mừng đến với
              @endif
            </span>
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-orange-400 to-rose-400 text-4xl md:text-6xl mt-1 drop-shadow-xl">
              Perfume Luxury
            </span>
          </h1>
        </div>
        
        <!-- Subtitle - Nhỏ gọn hơn -->
        <div class="max-w-3xl mx-auto mb-8">
          <p class="text-lg md:text-xl text-white/90 leading-relaxed font-medium px-6 py-4 bg-white/8 backdrop-blur-sm rounded-2xl border border-white/15 shadow-lg">
            @if(app()->getLocale() === 'en')
              ✨ {{ __('app.discover_your_signature_scent') }} ✨
            @else
              ✨ Khám phá bộ sưu tập nước hoa đa dạng và chất lượng từ các thương hiệu hàng đầu thế giới ✨
            @endif
          </p>
        </div>
        
        <!-- Search Bar - Nhỏ gọn hơn -->
        <div class="max-w-3xl mx-auto mb-8">
          <form action="{{ route('search.index') }}" method="GET" class="relative">
            <div class="relative group">
              <input type="text" 
                     name="q" 
                     placeholder="@if(app()->getLocale() === 'en')🔍 Search perfumes, brands, categories...@else🔍 Tìm kiếm nước hoa, thương hiệu, danh mục...@endif"
                     class="w-full px-6 py-4 pl-14 pr-20 text-slate-900 bg-white/90 backdrop-blur-md rounded-2xl border border-white/25 focus:ring-2 focus:ring-white/30 focus:border-white/40 focus:outline-none text-base shadow-lg transition-all duration-300 group-hover:shadow-xl group-hover:scale-[1.01]"
                     autocomplete="off">
              
              <!-- Search Icon -->
              <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-hover:text-brand-600 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
              
              <!-- Search Button -->
              <button type="submit" 
                      class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold text-base transition-all duration-300 hover:scale-105 shadow-md hover:shadow-lg border border-white/20">
                {{ __('app.search') }}
              </button>
            </div>
            
            <!-- Search Suggestions - Bỏ "Đang giảm giá" -->
            <div class="mt-4 text-center">
              <p class="mb-2 text-white/80 text-sm font-medium">
                @if(app()->getLocale() === 'en')
                  💡 <strong>Search suggestions:</strong>
                @else
                  💡 <strong>Gợi ý tìm kiếm:</strong>
                @endif
              </p>
              <div class="flex flex-wrap gap-2 justify-center">
                <a href="{{ route('search.index', ['q' => 'Versace']) }}" 
                   class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Versace</a>
                <a href="{{ route('search.index', ['q' => 'Chanel']) }}" 
                   class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Chanel</a>
                <a href="{{ route('search.index', ['q' => 'Dior']) }}" 
                   class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Dior</a>
                @if(app()->getLocale() === 'en')
                  <a href="{{ route('search.index', ['q' => 'men perfume']) }}" 
                     class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Men's Perfume</a>
                  <a href="{{ route('search.index', ['q' => 'women perfume']) }}" 
                     class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Women's Perfume</a>
                @else
                  <a href="{{ route('search.index', ['q' => 'nước hoa nam']) }}" 
                     class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Nước hoa nam</a>
                  <a href="{{ route('search.index', ['q' => 'nước hoa nữ']) }}" 
                     class="px-3 py-1.5 bg-white/15 backdrop-blur-sm border border-white/25 rounded-xl hover:bg-white/25 hover:scale-105 transition-all duration-300 cursor-pointer font-medium text-sm">Nước hoa nữ</a>
                @endif
              </div>
            </div>
          </form>
        </div>
        
        <!-- Quick Actions - Nhỏ gọn hơn -->
        <div class="flex flex-wrap gap-4 justify-center">
          <a href="{{ route('products.index') }}" 
             class="group px-8 py-4 bg-white/12 backdrop-blur-md border border-white/25 text-white rounded-2xl font-semibold text-base hover:bg-white hover:text-slate-900 transition-all duration-400 hover:scale-105 shadow-lg hover:shadow-xl">
            <span class="flex items-center gap-2">
              <svg class="w-5 h-5 group-hover:rotate-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
              @if(app()->getLocale() === 'en')
                View All Products
              @else
                Xem tất cả sản phẩm
              @endif
            </span>
          </a>
          <a href="{{ route('search.on-sale') }}" 
             class="group px-8 py-4 bg-gradient-to-r from-rose-500/25 to-pink-500/25 backdrop-blur-md border border-rose-400/30 text-rose-100 rounded-2xl font-semibold text-base hover:from-rose-500 hover:to-pink-500 hover:text-white transition-all duration-400 hover:scale-105 shadow-lg hover:shadow-xl">
            <span class="flex items-center gap-2">
              <span class="text-xl group-hover:animate-bounce">🎉</span>
              @if(app()->getLocale() === 'en')
                On Sale
              @else
                Đang giảm giá
              @endif
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Sản phẩm nổi bật -->
  @if($featuredProducts->count() > 0)
    @include('partials.product-slider', [
      'products' => $featuredProducts,
      'section' => 'featured',
      'title' => app()->getLocale() === 'en' ? 'Featured Products' : 'Sản phẩm nổi bật',
      'subtitle' => app()->getLocale() === 'en' ? 'Most loved products' : 'Những sản phẩm được yêu thích nhất',
      'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>',
      'iconBg' => 'bg-gradient-to-br from-yellow-400 to-orange-500',
      'gradient' => 'bg-white/20 dark:bg-white/5',
      'viewAllUrl' => route('products.index'),
      'titleColor' => 'text-brand-600 hover:text-brand-700'
    ])
  @endif

  <!-- Sản phẩm đang giảm giá -->
  @if($onSaleProducts->count() > 0)
    @include('partials.product-slider', [
      'products' => $onSaleProducts,
      'section' => 'onsale',
      'title' => app()->getLocale() === 'en' ? 'On Sale' : 'Đang giảm giá',
      'subtitle' => app()->getLocale() === 'en' ? 'Amazing deals you can\'t miss' : 'Ưu đãi hấp dẫn không thể bỏ qua',
      'icon' => '<span class="text-xl">🎉</span>',
      'iconBg' => 'bg-gradient-to-br from-rose-500 to-pink-500',
      'gradient' => 'bg-gradient-to-br from-rose-200/15 to-pink-200/15 dark:from-rose-400/10 dark:to-pink-400/10',
      'viewAllUrl' => route('search.on-sale'),
      'titleColor' => 'text-rose-600 hover:text-rose-700'
    ])
  @endif

  <!-- Sản phẩm bán chạy -->
  @if($bestSellerProducts->count() > 0)
    @include('partials.product-slider', [
      'products' => $bestSellerProducts,
      'section' => 'bestseller',
      'title' => app()->getLocale() === 'en' ? 'Best Sellers' : 'Bán chạy nhất',
      'subtitle' => app()->getLocale() === 'en' ? 'Most purchased products' : 'Những sản phẩm được mua nhiều nhất',
      'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
      'iconBg' => 'bg-gradient-to-br from-emerald-500 to-teal-500',
      'gradient' => 'bg-gradient-to-br from-emerald-200/15 to-teal-200/15 dark:from-emerald-400/10 dark:to-teal-400/10',
      'viewAllUrl' => route('products.index') . '?sort=best_seller',
      'titleColor' => 'text-emerald-600 hover:text-emerald-700'
    ])
  @endif

  <!-- Sản phẩm hàng mới -->
  @if($newProducts->count() > 0)
    @include('partials.product-slider', [
      'products' => $newProducts,
      'section' => 'newarrivals',
      'title' => app()->getLocale() === 'en' ? 'New Arrivals' : 'Hàng mới về',
      'subtitle' => app()->getLocale() === 'en' ? 'Latest products just arrived' : 'Những sản phẩm mới nhất vừa về',
      'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
      'iconBg' => 'bg-gradient-to-br from-blue-500 to-indigo-500',
      'gradient' => 'bg-gradient-to-br from-blue-200/15 to-indigo-200/15 dark:from-blue-400/10 dark:to-indigo-400/10',
      'viewAllUrl' => route('products.index') . '?sort=newest',
      'titleColor' => 'text-blue-600 hover:text-blue-700'
    ])
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
