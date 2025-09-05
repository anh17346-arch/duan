@extends('layouts.app')

@section('title', __('app.promotion_management'))

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

<div class="relative max-w-6xl mx-auto px-4 py-8">
  <!-- Back Button -->
  <div class="mb-6">
      <a href="{{ route('admin.dashboard') }}" 
         class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-2xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
          </svg>
      </a>
  </div>

  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.promotion_management') }}</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('app.promotion_management_description') }}</p>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.promotions.create') }}" 
         class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
        + {{ __('app.create_promotion') }}
      </a>
    </div>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 px-4 py-3">
      {{ session('error') }}
    </div>
  @endif

  <!-- Promotions Table -->
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 overflow-hidden">
    @if($promotions->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-slate-50 dark:bg-slate-700/50">
            <tr>
              <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.product') }}</th>
              <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.discount') }}</th>
              <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.promotion_quantity') }}</th>
              <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.start_date') }}</th>
              <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.end_date') }}</th>
              <th class="text-center px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.status') }}</th>
              <th class="text-right px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.actions') }}</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($promotions as $promotion)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <img class="h-12 w-12 rounded-lg object-cover mr-3 border border-slate-200 dark:border-slate-600" 
                         src="{{ $promotion->product->main_image_url }}" 
                         alt="{{ $promotion->product->name }}">
                    <div>
                      <div class="font-medium text-slate-900 dark:text-slate-100">{{ $promotion->product->name }}</div>
                      <div class="text-sm text-slate-500 dark:text-slate-400">{{ $promotion->product->brand }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                    {{ $promotion->formatted_discount }}
                  </span>
                </td>
                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                  @if($promotion->quantity == 0)
                    <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('app.unlimited') }}</span>
                  @else
                    <div class="text-sm">
                      <div class="font-medium text-slate-900 dark:text-slate-100">{{ $promotion->quantity }}</div>
                      @if($promotion->sold_quantity > 0)
                        <div class="text-xs text-slate-500 dark:text-slate-400">
                          {{ __('app.sold_quantity') }}: {{ $promotion->sold_quantity }}
                        </div>
                      @endif
                    </div>
                  @endif
                </td>
                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                  {{ $promotion->formatted_start_date }}
                </td>
                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                  {{ $promotion->formatted_end_date }}
                </td>
                <td class="px-6 py-4">
                  @if($promotion->isActive())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                      <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      {{ __('app.active') }}
                    </span>
                  @elseif($promotion->isUpcoming())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                      <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      {{ __('app.upcoming') }}
                    </span>
                  @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300">
                      <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      {{ __('app.ended') }}
                    </span>
                  @endif
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2 justify-end">
                    <a href="{{ route('admin.promotions.edit', $promotion) }}" 
                       class="px-3 py-1.5 text-sm rounded-lg border border-amber-300 dark:border-amber-600 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                      {{ __('app.edit') }}
                    </a>
                    <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" 
                          class="inline" 
                          onsubmit="return confirm('{{ __('app.confirm_delete_promotion') }}')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-3 py-1.5 text-sm rounded-lg border border-red-300 dark:border-red-600 text-red-700 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        {{ __('app.delete') }}
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-100">{{ __('app.no_promotions') }}</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('app.no_promotions_description') }}</p>
        <div class="mt-6">
          <a href="{{ route('admin.promotions.create') }}" 
             class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ __('app.create_promotion') }}
          </a>
        </div>
      </div>
    @endif
  </div>

  <!-- Statistics -->
  @if($promotions->count() > 0)
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.active_promotions') }}</p>
            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
              {{ $promotions->where('start_date', '<=', now())->where('end_date', '>=', now())->count() }}
            </p>
          </div>
        </div>
      </div>

      <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.upcoming_promotions') }}</p>
            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
              {{ $promotions->where('start_date', '>', now())->count() }}
            </p>
          </div>
        </div>
      </div>

      <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.ended_promotions') }}</p>
            <p class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
              {{ $promotions->where('end_date', '<', now())->count() }}
            </p>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
</div>
@endsection
