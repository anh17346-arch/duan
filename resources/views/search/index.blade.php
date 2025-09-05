@extends('layouts.app')

@section('title', __('app.search_results') . ' - Perfume Luxury')

@section('content')
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
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-b-3xl bg-gradient-to-br from-slate-800/90 via-blue-800/80 via-purple-800/70 to-pink-800/80 backdrop-blur-xl shadow-2xl">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <!-- Floating Orbs -->
            <div class="absolute top-4 left-8 w-16 h-16 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute top-8 right-16 w-20 h-20 bg-gradient-to-r from-pink-400/20 to-rose-400/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 1.5s;"></div>
            <div class="absolute bottom-4 left-1/3 w-12 h-12 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 rounded-full blur-xl animate-pulse" style="animation-delay: 3s;"></div>
            
            <!-- Geometric Patterns -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-white/5 to-transparent transform rotate-45"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tl from-white/5 to-transparent transform -rotate-12"></div>
            
            <!-- Mesh Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-pink-600/10"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center justify-between">
                <!-- Back Button -->
                <a href="{{ route('categories.index') }}" 
                   class="group inline-flex items-center justify-center w-16 h-16 bg-white/10 dark:bg-white/5 text-white/90 rounded-2xl hover:bg-white/20 dark:hover:bg-white/10 hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-2xl backdrop-blur-lg border border-white/20">
                    <svg class="w-7 h-7 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                
                <!-- Search Info -->
                <div class="text-center">
                    <h1 class="text-3xl md:text-5xl font-black mb-3 leading-tight tracking-tight">
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-white to-purple-200">
                            {{ __('app.search_results') }}
                        </span>
                    </h1>
                    @if($searchStats['query'])
                        <p class="text-white/90 text-lg font-medium">
                            {{ __('app.search_for') }}: <span class="font-bold px-4 py-2 bg-white/20 text-white rounded-full text-base backdrop-blur-sm border border-white/30">"{{ $searchStats['query'] }}"</span>
                        </p>
                    @endif
                </div>
                
                <!-- Results Count & Actions -->
                <div class="text-right flex flex-col items-end gap-3">
                    <div class="px-6 py-3 bg-white/15 backdrop-blur-lg rounded-2xl border border-white/30 shadow-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-white/90 font-medium">
                                {!! __('app.found_products', ['count' => '<span class="font-bold text-emerald-300">' . $searchStats['total'] . '</span>']) !!}
                            </div>
                        </div>
                        @if($searchStats['filters_applied'] > 0)
                            <div class="flex items-center gap-2 mt-2">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                </svg>
                                <div class="text-xs text-blue-300 font-medium">
                                    {!! __('app.filters_applied', ['count' => $searchStats['filters_applied']]) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Action Buttons -->
                    <div class="flex gap-2">
                        @if(request()->hasAny(['q', 'category', 'brand', 'min_price', 'max_price']))
                            <a href="{{ route('search.index') }}" 
                               class="group px-4 py-2 bg-white/10 hover:bg-white/20 text-white/80 hover:text-white rounded-xl text-sm font-medium transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl backdrop-blur-lg border border-white/20 flex items-center gap-2">
                                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                {{ __('app.clear_filters') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Filters & Results -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Search Bar Section -->
        <div class="backdrop-blur-md bg-white/25 dark:bg-white/10 rounded-3xl p-8 shadow-2xl border border-white/40 dark:border-white/20 mb-12">
            <form method="GET" action="{{ route('search.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Main Search Input -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="{{ __('app.search_placeholder') }}"
                           class="search-input w-full pl-12 pr-4 py-3 bg-white/50 dark:bg-slate-700/50 border border-white/30 dark:border-slate-600/30 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none transition-all duration-200 backdrop-blur-sm">
                </div>
                
                <!-- Search Button -->
                <button type="submit" 
                        class="group px-8 py-3 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-2xl flex items-center gap-3 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="relative z-10 hidden sm:inline">{{ __('app.search') }}</span>
                </button>
            </form>
        </div>

        @if($products->count() > 0)
            <!-- Results Grid Container -->
            <div class="results-container backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-3xl p-10 shadow-2xl border border-white/40 dark:border-white/20">
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
                    <div class="mt-16 pt-10 border-t border-white/30 dark:border-white/15">
                        <div class="flex justify-center">
                            <div class="backdrop-blur-lg bg-white/30 dark:bg-white/10 rounded-3xl p-8 border border-white/50 dark:border-white/30 shadow-2xl">
                                <div class="pagination-wrapper">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- No Results -->
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-3xl p-16 shadow-2xl border border-white/40 dark:border-white/20 text-center">
                <div class="w-32 h-32 mx-auto mb-8 p-6 bg-gradient-to-br from-slate-100/80 to-slate-200/80 dark:from-slate-700/80 dark:to-slate-600/80 rounded-3xl shadow-lg backdrop-blur-sm">
                    <svg class="w-full h-full text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-slate-100 dark:to-slate-300 bg-clip-text text-transparent mb-3">
                    {{ __('app.no_products_found') }}
                </h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                    {!! __('app.no_products_match', ['query' => $searchStats['query']]) !!}
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('categories.index') }}" 
                       class="group px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-2xl flex items-center gap-3 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="relative z-10">{{ __('app.back_to_homepage') }}</span>
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="group px-8 py-4 bg-gradient-to-r from-slate-200/80 to-slate-300/80 dark:from-slate-700/80 dark:to-slate-600/80 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:from-slate-300 hover:to-slate-400 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl backdrop-blur-sm flex items-center gap-3">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        {{ __('app.view_all_products') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@keyframes blob {
  0% {
    transform: translate(0px, 0px) scale(1);
  }
  33% {
    transform: translate(30px, -50px) scale(1.1);
  }
  66% {
    transform: translate(-20px, 20px) scale(0.9);
  }
  100% {
    transform: translate(0px, 0px) scale(1);
  }
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

/* Custom Pagination Styling */
.pagination-wrapper nav {
  @apply flex items-center justify-center;
}

.pagination-wrapper .flex {
  @apply gap-2;
}

.pagination-wrapper a,
.pagination-wrapper span {
  @apply px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300;
}

.pagination-wrapper a {
  @apply bg-white/60 dark:bg-slate-700/60 text-slate-700 dark:text-slate-300 hover:bg-brand-500 hover:text-white dark:hover:bg-brand-600 hover:scale-105 shadow-md hover:shadow-lg backdrop-blur-sm border border-white/40 dark:border-slate-600/40;
}

.pagination-wrapper span[aria-current="page"] {
  @apply bg-gradient-to-r from-brand-600 to-brand-700 text-white shadow-lg scale-105 border border-brand-500/50;
}

.pagination-wrapper span:not([aria-current]) {
  @apply bg-slate-300/60 dark:bg-slate-600/60 text-slate-500 dark:text-slate-400 cursor-not-allowed;
}

/* Search Input Focus Enhancement */
.search-input:focus {
  @apply ring-4 ring-brand-500/20 border-brand-500 dark:border-brand-400;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Results Container Fade In */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.results-container {
  animation: fadeInUp 0.6s ease-out;
}
</style>
@endsection
