@extends('layouts.app')

@section('title', __('app.manage_categories') . ' - Perfume Luxury')

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
         class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
          </svg>
          {{ __('app.back') }}
      </a>
  </div>

  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.manage_categories') }}</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('app.manage_all_categories') }}</p>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.categories.create') }}" 
         class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
        + {{ __('app.add_new_category') }}
      </a>
    </div>
  </div>

  <!-- Search and Filters -->
  <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700 mb-6">
    <form method="GET" class="flex items-center gap-4">
      <div class="flex-1">
        <input name="kw" value="{{ request('kw') }}"
               class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"
               placeholder="{{ __('app.search_by_name_brand') }}" />
      </div>
      <button type="submit" class="px-6 py-3 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 rounded-xl font-semibold hover:bg-slate-800 dark:hover:bg-slate-200 transition-colors">
        {{ __('app.search') }}
      </button>
      @if(request('kw'))
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
          {{ __('app.clear_filter') }}
        </a>
      @endif
    </form>
  </div>

  <!-- Categories Table -->
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-slate-50 dark:bg-slate-700/50">
          <tr>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">ID</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.category_name') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.description') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.status') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.products_count') }}</th>
            <th class="text-right px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
          @forelse($categories as $category)
            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $category->id }}</td>
              <td class="px-6 py-4">
                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $category->display_name }}</div>
                @if($category->name_en && app()->getLocale() === 'vi')
                  <div class="text-sm text-blue-600 dark:text-blue-400">{{ $category->name_en }}</div>
                @endif
                @if($category->slug)
                  <div class="text-xs text-slate-500 dark:text-slate-400">{{ $category->slug }}</div>
                @endif
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                <div>{{ Str::limit($category->description, 30) ?: __('app.no_description') }}</div>
                @if($category->description_en)
                  <div class="text-sm text-blue-600 dark:text-blue-400">{{ Str::limit($category->description_en, 30) }}</div>
                @endif
              </td>
              <td class="px-6 py-4">
                @if($category->status)
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                    {{ __('app.active') }}
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                    {{ __('app.hidden') }}
                  </span>
                @endif
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                {{ $category->products_count ?? 0 }}
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2 justify-end">
                  <a href="{{ route('categories.show', $category) }}" 
                     class="px-3 py-1.5 text-sm rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    {{ __('app.view') }}
                  </a>
                  <a href="{{ route('admin.categories.edit', $category) }}" 
                     class="px-3 py-1.5 text-sm rounded-lg border border-amber-300 dark:border-amber-600 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                    {{ __('app.edit') }}
                  </a>
                  <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                        onsubmit="return confirm('{{ __('app.confirm_delete_category') }}')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="px-3 py-1.5 text-sm rounded-lg border border-rose-300 dark:border-rose-600 text-rose-700 dark:text-rose-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                      {{ __('app.delete') }}
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                <div class="flex flex-col items-center gap-3">
                  <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                  </svg>
                  <div>
                    <p class="font-medium">{{ __('app.no_categories_yet') }}</p>
                    <p class="text-sm">{{ __('app.start_by_creating_first_category') }}</p>
                  </div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if ($categories->hasPages())
      <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
        {{ $categories->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</div>
</div>
@endsection
