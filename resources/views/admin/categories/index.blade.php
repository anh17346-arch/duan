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

<div class="relative max-w-7xl mx-auto px-4 py-8">
  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.manage_categories') }}</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">
        @if(app()->getLocale() === 'en')
          Manage all categories in the system
        @else
          Quản lý tất cả danh mục trong hệ thống
        @endif
      </p>
    </div>
    
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.dashboard') }}" 
         class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        {{ __('app.dashboard') }}
      </a>
      
      <a href="{{ route('admin.categories.create') }}" 
         class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-lg hover:from-emerald-600 hover:to-green-600 transition-all duration-300 font-semibold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        {{ __('app.add_new_category') }}
      </a>
    </div>
  </div>

  <!-- Flash Messages -->
  @if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3">
      {{ session('success') }}
    </div>
  @endif

  <!-- Search and Filters -->
  <div class="bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10 mb-8">
    <form method="GET" class="flex items-center gap-4">
      <div class="flex-1">
        <input name="kw" value="{{ request('kw') }}"
               placeholder="{{ __('app.search_by_name_brand') }}"
               class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
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

  <!-- Categories List -->
  <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden">
    @if($categories->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full category-table">
          <thead class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-700/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                {{ __('app.category') }}
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                {{ __('app.description') }}
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                {{ __('app.status') }}
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                {{ __('app.products_count') }}
              </th>
              <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                {{ __('app.created') }}
              </th>
              <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                {{ __('app.actions') }}
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/30">
            @foreach($categories as $category)
              <tr class="category-table-row group hover:bg-slate-50/60 dark:hover:bg-slate-700/30 transition-all duration-300 ease-out relative border-b border-slate-100/50 dark:border-slate-700/30">
                <td class="px-6 py-4 relative z-10">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                      <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 flex items-center justify-center shadow-sm category-icon ring-1 ring-slate-200/50 dark:ring-slate-600/30">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="category-name text-sm font-semibold text-slate-900 dark:text-slate-100 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">
                        {{ $category->display_name }}
                      </div>
                      @if($category->name_en && app()->getLocale() === 'vi')
                        <div class="text-sm font-medium text-blue-600 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                          {{ $category->name_en }}
                        </div>
                      @endif
                      @if($category->slug)
                        <div class="text-xs text-slate-500 dark:text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-400 transition-colors">
                          {{ $category->slug }}
                        </div>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 relative z-10">
                  <div class="text-sm text-slate-900 dark:text-slate-100 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">
                    {{ Str::limit($category->description, 50) ?: __('app.no_description') }}
                  </div>
                  @if($category->description_en)
                    <div class="text-sm text-blue-600 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                      {{ Str::limit($category->description_en, 50) }}
                    </div>
                  @endif
                </td>
                <td class="px-6 py-4 relative z-10">
                  @if($category->status)
                    <span class="category-status active inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-300 group-hover:from-green-200 group-hover:to-emerald-200 dark:group-hover:from-green-900/40 dark:group-hover:to-emerald-900/40 transition-all duration-200 ease-out shadow-sm">
                      {{ __('app.active') }}
                    </span>
                  @else
                    <span class="category-status inactive inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-red-100 to-pink-100 text-red-800 dark:from-red-900/30 dark:to-pink-900/30 dark:text-red-300 group-hover:from-red-200 group-hover:to-pink-200 dark:group-hover:from-red-900/40 dark:group-hover:to-pink-900/40 transition-all duration-200 ease-out shadow-sm">
                      {{ __('app.hidden') }}
                    </span>
                  @endif
                </td>
                <td class="px-6 py-4 relative z-10">
                  <div class="text-sm text-slate-900 dark:text-slate-100 font-mono group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100/80 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300 group-hover:bg-blue-200/80 dark:group-hover:bg-blue-900/40 transition-all duration-200 ease-out shadow-sm">
                      {{ $category->products_count ?? 0 }} {{ __('app.products') }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 relative z-10 group-hover:text-slate-600 dark:group-hover:text-slate-400 transition-colors category-date">
                  {{ $category->created_at ? $category->created_at->format('d/m/Y') : '-' }}
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium relative z-10">
                  <div class="action-buttons flex items-center justify-end gap-2">
                    <a href="{{ route('categories.show', $category) }}" 
                       class="action-button text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-all duration-200 ease-out p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:scale-105"
                       title="{{ __('app.view') }}">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                      </svg>
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="action-button text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-all duration-200 ease-out p-1 rounded hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:scale-105"
                       title="{{ __('app.edit') }}">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('app.confirm_delete_category') }}')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                              class="action-button text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-all duration-200 ease-out p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:scale-105"
                              title="{{ __('app.delete') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
        {{ $categories->links() }}
      </div>
    @else
      <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-slate-100">{{ __('app.no_categories_yet') }}</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
          {{ __('app.start_by_creating_first_category') }}
        </p>
        <div class="mt-6">
          <a href="{{ route('admin.categories.create') }}" 
             class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ __('app.add_new_category') }}
          </a>
        </div>
      </div>
    @endif
  </div>
</div>
</div>
@endsection
