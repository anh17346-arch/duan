@extends('layouts.app')

@section('title', __('app.system_management') . ' - Perfume Luxury')

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
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.system_management') }}</h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">
      @if(app()->getLocale() === 'en')
        Manage products and categories in the system
      @else
        Quản lý sản phẩm và danh mục trong hệ thống
      @endif
    </p>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/20">
          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.total_products') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ App\Models\Product::count() }}</p>
        </div>
      </div>
    </div>

    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900/20">
          <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.total_categories') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ App\Models\Category::count() }}</p>
        </div>
      </div>
    </div>

    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900/20">
          <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.total_users') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ App\Models\User::count() }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Management Sections -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Products Management -->
    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden">
      <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
        <div>
          <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.product_management') }}</h2>
          <p class="text-slate-600 dark:text-slate-400 mt-1">
            @if(app()->getLocale() === 'en')
              Add, edit, delete products
            @else
              Thêm, sửa, xóa sản phẩm
            @endif
          </p>
        </div>
      </div>
      
      <div class="p-6">
        <div class="space-y-4">
          <a href="{{ route('admin.products.index') }}" 
             class="group flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200/30 dark:border-blue-700/30 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-800/40 dark:hover:to-indigo-800/40 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg backdrop-blur-sm">
            <div class="flex items-center">
              <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 group-hover:scale-110 transition-all duration-300">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <div class="ml-3">
                <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.view_all_products') }}</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                  @if(app()->getLocale() === 'en')
                    List, search, edit, delete
                  @else
                    Danh sách, tìm kiếm, sửa, xóa
                  @endif
                </p>
              </div>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.products.create') }}" 
             class="group flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-emerald-50/50 to-green-50/50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200/30 dark:border-emerald-700/30 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/40 dark:hover:to-green-800/40 hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg backdrop-blur-sm">
            <div class="flex items-center">
              <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/20 group-hover:bg-green-200 dark:group-hover:bg-green-800/40 group-hover:scale-110 transition-all duration-300">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <div class="ml-3">
                <p class="font-medium text-slate-900 dark:text-slate-100">Thêm sản phẩm mới</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Tạo sản phẩm với đầy đủ thông tin</p>
              </div>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Categories Management -->
    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden">
      <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
        <div>
          <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.category_management') }}</h2>
          <p class="text-slate-600 dark:text-slate-400 mt-1">
            @if(app()->getLocale() === 'en')
              Add, edit, delete categories
            @else
              Thêm, sửa, xóa danh mục
            @endif
          </p>
        </div>
      </div>
      
      <div class="p-6">
        <div class="space-y-4">
          <a href="{{ route('admin.categories.index') }}" 
             class="group flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-purple-50/50 to-violet-50/50 dark:from-purple-900/20 dark:to-violet-900/20 border border-purple-200/30 dark:border-purple-700/30 hover:from-purple-100 hover:to-violet-100 dark:hover:from-purple-800/40 dark:hover:to-violet-800/40 hover:border-purple-300 dark:hover:border-purple-600 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg backdrop-blur-sm">
            <div class="flex items-center">
              <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/20 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/40 group-hover:scale-110 transition-all duration-300">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
              </div>
              <div class="ml-3">
                <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.view_all_categories') }}</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                  @if(app()->getLocale() === 'en')
                    List, search, edit, delete
                  @else
                    Danh sách, tìm kiếm, sửa, xóa
                  @endif
                </p>
              </div>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.categories.create') }}" 
             class="group flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-orange-50/50 to-amber-50/50 dark:from-orange-900/20 dark:to-amber-900/20 border border-orange-200/30 dark:border-orange-700/30 hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-800/40 dark:hover:to-amber-800/40 hover:border-orange-300 dark:hover:border-orange-600 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg backdrop-blur-sm">
            <div class="flex items-center">
              <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/20 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/40 group-hover:scale-110 transition-all duration-300">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <div class="ml-3">
                <p class="font-medium text-slate-900 dark:text-slate-100">Thêm danh mục mới</p>
                <p class="text-sm text-slate-600 dark:text-slate-400">Tạo danh mục với tên và mô tả</p>
              </div>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="mt-8 backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.quick_actions') }}</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a href="{{ route('admin.products.create') }}" 
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/30 border border-emerald-200/50 dark:border-emerald-700/50 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/50 dark:hover:to-green-800/50 hover:border-emerald-300 dark:hover:border-emerald-600 hover:shadow-lg hover:scale-105 transition-all duration-300 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/20">
          <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.add_product') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Create new product
            @else
              Tạo sản phẩm mới
            @endif
          </p>
        </div>
      </a>
      
      <a href="{{ route('admin.categories.create') }}" 
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-purple-50 to-violet-50 dark:from-purple-900/30 dark:to-violet-900/30 border border-purple-200/50 dark:border-purple-700/50 hover:from-purple-100 hover:to-violet-100 dark:hover:from-purple-800/50 dark:hover:to-violet-800/50 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg hover:scale-105 transition-all duration-300 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/20 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/40 group-hover:scale-110 transition-all duration-300">
          <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.add_category') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Create new category
            @else
              Tạo danh mục mới
            @endif
          </p>
        </div>
      </a>
      
            <a href="{{ route('trangchu') }}"
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border border-blue-200/50 dark:border-blue-700/50 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-800/50 dark:hover:to-indigo-800/50 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-lg hover:scale-105 transition-all duration-300 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/20">
          <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">Xem trang chủ</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">Kiểm tra hiển thị</p>
        </div>
      </a>
    </div>
  </div>
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
