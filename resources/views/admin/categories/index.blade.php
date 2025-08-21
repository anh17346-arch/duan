@extends('layouts.app')

@section('title', 'Quản lý danh mục - Perfume Luxury')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
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
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Quản lý danh mục</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">Quản lý các danh mục sản phẩm trong hệ thống</p>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.categories.create') }}" 
         class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
        + Thêm danh mục
      </a>
    </div>
  </div>

  <!-- Search and Filters -->
  <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700 mb-6">
    <form method="GET" class="flex items-center gap-4">
      <div class="flex-1">
        <input name="kw" value="{{ request('kw') }}"
               class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"
               placeholder="Tìm kiếm danh mục..." />
      </div>
      <button type="submit" class="px-6 py-3 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 rounded-xl font-semibold hover:bg-slate-800 dark:hover:bg-slate-200 transition-colors">
        Tìm kiếm
      </button>
      @if(request('kw'))
        <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
          Xóa bộ lọc
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
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">Tên danh mục</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">Mô tả</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">Trạng thái</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">Số sản phẩm</th>
            <th class="text-right px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">Hành động</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
          @forelse($categories as $category)
            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $category->id }}</td>
              <td class="px-6 py-4">
                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $category->name }}</div>
                @if($category->slug)
                  <div class="text-sm text-slate-500 dark:text-slate-400">{{ $category->slug }}</div>
                @endif
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                {{ Str::limit($category->description, 50) ?: 'Không có mô tả' }}
              </td>
              <td class="px-6 py-4">
                @if($category->status)
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                    Hoạt động
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                    Ẩn
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
                    Xem
                  </a>
                  <a href="{{ route('admin.categories.edit', $category) }}" 
                     class="px-3 py-1.5 text-sm rounded-lg border border-amber-300 dark:border-amber-600 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                    Sửa
                  </a>
                  <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                        onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" 
                            class="px-3 py-1.5 text-sm rounded-lg border border-rose-300 dark:border-rose-600 text-rose-700 dark:text-rose-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                      Xóa
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
                    <p class="font-medium">Chưa có danh mục nào</p>
                    <p class="text-sm">Bắt đầu bằng cách tạo danh mục đầu tiên</p>
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
@endsection
