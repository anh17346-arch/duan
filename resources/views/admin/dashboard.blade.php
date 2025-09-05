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
        Important management functions for admin
      @else
        Các chức năng quản lý quan trọng dành cho admin
      @endif
    </p>
  </div>

  <!-- Management Sections -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Products Management -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/20 mr-3">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h2 class="title">{{ __('app.product_management') }}</h2>
        </div>
        <p class="description">
          @if(app()->getLocale() === 'en')
            Add, edit, delete products
          @else
            Thêm, sửa, xóa sản phẩm
          @endif
        </p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.products.index') }}" 
             class="group action-button bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200/30 dark:border-blue-700/30 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-800/40 dark:hover:to-indigo-800/40 hover:border-blue-300 dark:hover:border-blue-600">
            <div class="content">
              <div class="icon-container bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.view_all_products') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Browse and manage products
                  @else
                    Duyệt và quản lý sản phẩm
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.products.create') }}" 
             class="group action-button bg-gradient-to-r from-emerald-50/50 to-green-50/50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200/30 dark:border-emerald-700/30 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/40 dark:hover:to-green-800/40 hover:border-emerald-300 dark:hover:border-emerald-600">
            <div class="content">
              <div class="icon-container bg-green-100 dark:bg-green-900/20 group-hover:bg-green-200 dark:group-hover:bg-green-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.add_new_product') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Add new product to catalog
                  @else
                    Thêm sản phẩm mới vào danh mục
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Categories Management -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/20 mr-3">
            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
          </div>
          <h2 class="title">{{ __('app.category_management') }}</h2>
        </div>
        <p class="description">
          @if(app()->getLocale() === 'en')
            Add, edit, delete categories
          @else
            Thêm, sửa, xóa danh mục
          @endif
        </p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.categories.index') }}" 
             class="group action-button bg-gradient-to-r from-purple-50/50 to-violet-50/50 dark:from-purple-900/20 dark:to-violet-900/20 border border-purple-200/30 dark:border-purple-700/30 hover:from-purple-100 hover:to-violet-100 dark:hover:from-purple-800/40 dark:hover:to-violet-800/40 hover:border-purple-300 dark:hover:border-purple-600">
            <div class="content">
              <div class="icon-container bg-purple-100 dark:bg-purple-900/20 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.view_all_categories') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Browse and manage categories
                  @else
                    Duyệt và quản lý danh mục
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.categories.create') }}" 
             class="group action-button bg-gradient-to-r from-orange-50/50 to-amber-50/50 dark:from-orange-900/20 dark:to-amber-900/20 border border-orange-200/30 dark:border-orange-700/30 hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-800/40 dark:hover:to-amber-800/40 hover:border-orange-300 dark:hover:border-orange-600">
            <div class="content">
              <div class="icon-container bg-amber-100 dark:bg-amber-900/20 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.add_new_category') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Add new category
                  @else
                    Thêm danh mục mới
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Orders Management -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/20 mr-3">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
          </div>
          <h2 class="title">{{ __('app.order_management') }}</h2>
        </div>
        <p class="description">{{ __('app.order_management_description') }}</p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.orders.index') }}" 
             class="group action-button bg-gradient-to-r from-blue-50/50 to-cyan-50/50 dark:from-blue-900/20 dark:to-cyan-900/20 border border-blue-200/30 dark:border-blue-700/30 hover:from-blue-100 hover:to-cyan-100 dark:hover:from-blue-800/40 dark:hover:to-cyan-800/40 hover:border-blue-300 dark:hover:border-blue-600">
            <div class="content">
              <div class="icon-container bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.all_orders') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View and manage orders
                  @else
                    Xem và quản lý đơn hàng
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
             class="group action-button bg-gradient-to-r from-yellow-50/50 to-orange-50/50 dark:from-yellow-900/20 dark:to-orange-900/20 border border-yellow-200/30 dark:border-yellow-700/30 hover:from-yellow-100 hover:to-orange-100 dark:hover:from-yellow-800/40 dark:hover:to-orange-800/40 hover:border-yellow-300 dark:hover:border-yellow-600">
            <div class="content">
              <div class="icon-container bg-yellow-100 dark:bg-yellow-900/20 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.pending_orders') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View pending orders
                  @else
                    Xem đơn hàng chờ xử lý
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Payment Settings -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/20 mr-3">
            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <h2 class="title">Cấu hình thanh toán</h2>
        </div>
        <p class="description">Quản lý thông tin thanh toán và cài đặt hệ thống</p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.payment-settings.index') }}" 
             class="group action-button bg-gradient-to-r from-indigo-50/50 to-purple-50/50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-200/30 dark:border-indigo-700/30 hover:from-indigo-100 hover:to-purple-100 dark:hover:from-indigo-800/40 dark:hover:to-purple-800/40 hover:border-indigo-300 dark:hover:border-indigo-600">
            <div class="content">
              <div class="icon-container bg-indigo-100 dark:bg-indigo-900/20 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">Cài đặt thanh toán</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Configure payment methods and settings
                  @else
                    Cấu hình phương thức thanh toán
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.payment-settings.methods') }}" 
             class="group action-button bg-gradient-to-r from-blue-50/50 to-cyan-50/50 dark:from-blue-900/20 dark:to-cyan-900/20 border border-blue-200/30 dark:border-blue-700/30 hover:from-blue-100 hover:to-cyan-100 dark:hover:from-blue-800/40 dark:hover:to-cyan-800/40 hover:border-blue-300 dark:hover:border-blue-600">
            <div class="content">
              <div class="icon-container bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">
                  @if(app()->getLocale() === 'en')
                    View All Methods
                  @else
                     Phương thức thanh toán
                  @endif
                </p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View and manage all payment methods
                  @else
                    Xem phương thức thanh toán
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Promotions Management -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-pink-100 dark:bg-pink-900/20 mr-3">
            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
          <h2 class="title">{{ __('app.promotion_management') }}</h2>
        </div>
        <p class="description">{{ __('app.promotion_management_description') }}</p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.promotions.index') }}" 
             class="group action-button bg-gradient-to-r from-purple-50/50 to-pink-50/50 dark:from-purple-900/20 dark:to-pink-900/20 border border-purple-200/30 dark:border-purple-700/30 hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-800/40 dark:hover:to-pink-800/40 hover:border-purple-300 dark:hover:border-purple-600">
            <div class="content">
              <div class="icon-container bg-purple-100 dark:bg-purple-900/20 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.manage_promotions') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Manage promotion programs
                  @else
                    Quản lý chương trình khuyến mãi
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.promotions.create') }}" 
             class="group action-button bg-gradient-to-r from-pink-50/50 to-rose-50/50 dark:from-pink-900/20 dark:to-rose-900/20 border border-pink-200/30 dark:border-pink-700/30 hover:from-pink-100 hover:to-rose-100 dark:hover:from-pink-800/40 dark:hover:to-rose-800/40 hover:border-pink-300 dark:hover:border-pink-600">
            <div class="content">
              <div class="icon-container bg-pink-100 dark:bg-pink-900/20 group-hover:bg-pink-200 dark:group-hover:bg-pink-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">{{ __('app.create_promotion') }}</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Create new promotion
                  @else
                    Tạo khuyến mãi mới
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Customer Management -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-teal-100 dark:bg-teal-900/20 mr-3">
            <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
          <h2 class="title">
            @if(app()->getLocale() === 'en')
              Customer Management
            @else
              Quản lý khách hàng
            @endif
          </h2>
        </div>
        <p class="description">
          @if(app()->getLocale() === 'en')
            Manage customer accounts and information
          @else
            Quản lý tài khoản và thông tin khách hàng
          @endif
        </p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.customers.index') }}" 
             class="group action-button bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200/30 dark:border-blue-700/30 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-800/40 dark:hover:to-indigo-800/40 hover:border-blue-300 dark:hover:border-blue-600">
            <div class="content">
              <div class="icon-container bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">
                  @if(app()->getLocale() === 'en')
                    All Customers
                  @else
                    Tất cả khách hàng
                  @endif
                </p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View and manage customers
                  @else
                    Xem và quản lý khách hàng
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          

          <a href="{{ route('admin.customers.statistics') }}" 
             class="group action-button bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200/30 dark:border-blue-700/30 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-800/40 dark:hover:to-indigo-800/40 hover:border-blue-300 dark:hover:border-blue-600">
            <div class="content">
              <div class="icon-container bg-blue-100 dark:bg-blue-900/20 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">
                  @if(app()->getLocale() === 'en')
                    Customer Statistics
                  @else
                    Thống kê khách hàng
                  @endif
                </p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View customer analytics
                  @else
                    Xem phân tích khách hàng
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Reviews Management -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/20 mr-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
          </div>
          <h2 class="title">Quản lý đánh giá</h2>
        </div>
        <p class="description">Duyệt và quản lý đánh giá từ khách hàng</p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.reviews.index') }}" 
             class="group action-button bg-gradient-to-r from-yellow-50/50 to-amber-50/50 dark:from-yellow-900/20 dark:to-amber-900/20 border border-yellow-200/30 dark:border-yellow-700/30 hover:from-yellow-100 hover:to-amber-100 dark:hover:from-yellow-800/40 dark:hover:to-amber-800/40 hover:border-yellow-300 dark:hover:border-yellow-600">
            <div class="content">
              <div class="icon-container bg-yellow-100 dark:bg-yellow-900/20 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">Tất cả đánh giá</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View and manage all reviews
                  @else
                    Xem và quản lý tất cả đánh giá
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.reviews.statistics') }}" 
             class="group action-button bg-gradient-to-r from-amber-50/50 to-orange-50/50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200/30 dark:border-amber-700/30 hover:from-amber-100 hover:to-orange-100 dark:hover:from-amber-800/40 dark:hover:to-orange-800/40 hover:border-amber-300 dark:hover:border-amber-600">
            <div class="content">
              <div class="icon-container bg-amber-100 dark:bg-amber-900/20 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">Thống kê đánh giá</p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View review statistics
                  @else
                    Xem thống kê đánh giá
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Revenue Reports -->
    <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden management-card">
      <div class="card-header border-b border-slate-200/60 dark:border-slate-700">
        <div class="flex items-center mb-3">
          <div class="p-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/20 mr-3">
            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
          <h2 class="title">
            @if(app()->getLocale() === 'en')
              Revenue Reports
            @else
              Báo cáo doanh thu
            @endif
          </h2>
        </div>
        <p class="description">
          @if(app()->getLocale() === 'en')
            View revenue analytics and financial reports
          @else
            Xem phân tích doanh thu và báo cáo tài chính
          @endif
        </p>
      </div>
      
      <div class="card-content">
        <div class="actions-container">
          <a href="{{ route('admin.analytics.index') }}" 
             class="group action-button bg-gradient-to-r from-emerald-50/50 to-green-50/50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200/30 dark:border-emerald-700/30 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/40 dark:hover:to-green-800/40 hover:border-emerald-300 dark:hover:border-emerald-600">
            <div class="content">
              <div class="icon-container bg-emerald-100 dark:bg-emerald-900/20 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">
                  @if(app()->getLocale() === 'en')
                    Revenue Dashboard
                  @else
                    Doanh thu và Thống kê
                  @endif
                </p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    View revenue overview and analytics
                  @else
                    Xem tổng quan và phân tích doanh thu
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
          
          <a href="{{ route('admin.analytics.export-options') }}" 
             class="group action-button bg-gradient-to-r from-green-50/50 to-teal-50/50 dark:from-green-900/20 dark:to-teal-900/20 border border-green-200 dark:border-green-800 hover:from-green-100 hover:to-teal-100 dark:hover:from-green-800/40 dark:hover:to-teal-800/40 hover:border-green-300 dark:hover:border-green-600">
            <div class="content">
              <div class="icon-container bg-green-100 dark:bg-green-900/20 group-hover:bg-green-200 dark:group-hover:bg-green-800/40 group-hover:scale-110 transition-transform duration-200">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </div>
              <div class="text-container">
                <p class="title">
                  @if(app()->getLocale() === 'en')
                    Export Reports
                  @else
                    Xuất báo cáo
                  @endif
                </p>
                <p class="description">
                  @if(app()->getLocale() === 'en')
                    Choose export format (PDF/Excel)
                  @else
                    Chọn định dạng báo cáo 
                  @endif
                </p>
              </div>
            </div>
            <svg class="arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Notifications Section -->
  <div class="mt-8 backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        {{ __('app.my_notifications') }}
      </h3>
      <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
        {{ __('app.view_all') }}
      </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-white/50 dark:bg-slate-800/50 rounded-xl p-4 border border-white/30 dark:border-slate-700/30">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.total_notifications') }}</p>
            <p class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ auth()->user()->notifications()->count() }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white/50 dark:bg-slate-800/50 rounded-xl p-4 border border-white/30 dark:border-slate-700/30">
        <div class="flex items-center">
          <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.unread') }}</p>
            <p class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ auth()->user()->unread_notifications_count }}</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white/50 dark:bg-slate-800/50 rounded-xl p-4 border border-white/30 dark:border-slate-700/30">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.read') }}</p>
            <p class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ auth()->user()->notifications()->count() - auth()->user()->unread_notifications_count }}</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Recent Notifications -->
    @php
      $recentNotifications = auth()->user()->notifications()->limit(3)->get();
    @endphp
    @if($recentNotifications->count() > 0)
      <div class="space-y-3">
        @foreach($recentNotifications as $notification)
          <div class="flex items-center p-3 bg-white/30 dark:bg-slate-800/30 rounded-xl border border-white/30 dark:border-slate-700/30 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $notification->color_classes }} dark:bg-opacity-20 mr-3">
              <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">{{ $notification->title }}</p>
              <p class="text-xs text-slate-600 dark:text-slate-400">{{ $notification->time_ago }}</p>
            </div>
            @if(!$notification->pivot->is_read)
              <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
            @endif
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-8">
        <svg class="w-12 h-12 text-slate-400 dark:text-slate-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        <p class="text-slate-600 dark:text-slate-400">{{ __('app.no_notifications') }}</p>
      </div>
    @endif
  </div>

  <!-- Quick Actions -->
  <div class="mt-8 backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.quick_actions') }}</h3>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
      <a href="{{ route('admin.products.create') }}" 
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/30 border border-emerald-200/50 dark:border-emerald-700/50 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/50 dark:hover:to-green-800/50 hover:border-emerald-300 dark:hover:border-emerald-600 hover:shadow-lg hover:scale-105 transition-transform duration-200 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/20 group-hover:bg-green-200 dark:group-hover:bg-green-800/40 group-hover:scale-110 transition-transform duration-200">
          <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.add_new_product') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Add new product
            @else
              Thêm sản phẩm mới
            @endif
          </p>
        </div>
      </a>

      <a href="{{ route('admin.categories.create') }}" 
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-purple-50 to-violet-50 dark:from-purple-900/30 dark:to-violet-900/30 border border-purple-200/50 dark:border-purple-700/50 hover:from-purple-100 hover:to-violet-100 dark:hover:from-purple-800/50 dark:hover:to-violet-800/50 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg hover:scale-105 transition-transform duration-200 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/20 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/40 group-hover:scale-110 transition-transform duration-200">
          <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.add_new_category') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Add new category
            @else
              Thêm danh mục mới
            @endif
          </p>
        </div>
      </a>
      
            <a href="{{ route('admin.orders.index') }}" 
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/30 dark:to-orange-900/30 border border-yellow-200/50 dark:border-yellow-700/50 hover:from-yellow-100 hover:to-orange-100 dark:hover:from-yellow-800/50 dark:hover:to-orange-800/50 hover:border-yellow-300 dark:hover:border-yellow-600 hover:shadow-lg hover:scale-105 transition-all duration-300 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/20">
          <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.order_management') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              View orders
            @else
              Xem đơn hàng
            @endif
          </p>
        </div>
      </a>
      
      <a href="{{ route('admin.promotions.create') }}" 
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 border border-purple-200/50 dark:border-purple-700/50 hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-800/50 dark:hover:to-pink-800/50 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg hover:scale-105 transition-all duration-300 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/20">
          <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.create_promotion') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Add new promotion
            @else
              Thêm khuyến mãi mới
            @endif
          </p>
        </div>
      </a>
      
      <a href="{{ route('admin.analytics.index') }}"
         class="group flex items-center p-4 rounded-xl bg-gradient-to-br from-cyan-50 to-teal-50 dark:from-cyan-900/30 dark:to-teal-900/30 border border-cyan-200/50 dark:border-cyan-700/50 hover:from-cyan-100 hover:to-teal-100 dark:hover:from-cyan-800/50 dark:hover:to-teal-800/50 hover:border-cyan-300 dark:hover:border-cyan-600 hover:shadow-lg hover:scale-105 transition-all duration-300 backdrop-blur-sm">
        <div class="p-2 rounded-lg bg-cyan-100 dark:bg-cyan-900/20">
          <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
        </div>
        <div class="ml-3">
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.analytics_dashboard') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              View reports & analytics
            @else
              Xem báo cáo & thống kê
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
          <p class="font-medium text-slate-900 dark:text-slate-100">{{ __('app.view_website') }}</p>
          <p class="text-sm text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Check display
            @else
              Kiểm tra hiển thị
            @endif
          </p>
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

/* Optimized CSS for better performance */
.management-card {
  display: flex;
  flex-direction: column;
  height: 500px;
  min-height: 500px;
  position: relative;
  z-index: 10;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.management-card .card-header {
  flex-shrink: 0;
  padding: 1.5rem;
  border-bottom: 1px solid rgba(226, 232, 240, 0.6);
  height: 160px;
  min-height: 160px;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}

.management-card .card-header .title {
  font-size: 1.25rem;
  font-weight: 600;
  line-height: 1.25;
  color: rgb(15, 23, 42);
  margin: 0;
}

.management-card .card-header .description {
  font-size: 0.875rem;
  line-height: 1.5;
  color: rgb(71, 85, 105);
  word-wrap: break-word;
  margin-top: 0.5rem;
}

.management-card .card-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 1.5rem;
  height: 340px;
  min-height: 340px;
}

.management-card .actions-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.5rem;
  height: 100%;
  min-height: 280px;
}

.action-button {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.5rem;
  border-radius: 0.75rem;
  height: 120px;
  min-height: 120px;
  max-height: 120px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  flex: 1;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.action-button .content {
  display: flex;
  align-items: center;
  flex: 1;
  min-width: 0;
}

.action-button .icon-container {
  flex-shrink: 0;
  padding: 0.5rem;
  border-radius: 0.5rem;
  margin-right: 0.75rem;
  transition: transform 0.2s ease;
}

.action-button .text-container {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: 100%;
  padding: 0.25rem 0;
}

.action-button .title {
  font-weight: 600;
  font-size: 0.875rem;
  line-height: 1.25;
  color: rgb(15, 23, 42);
  margin: 0 0 0.75rem 0;
  word-wrap: break-word;
}

.action-button .description {
  font-size: 0.75rem;
  line-height: 1.4;
  color: rgb(71, 85, 105);
  margin: 0;
  word-wrap: break-word;
  flex: 1;
  display: flex;
  align-items: flex-start;
  padding-top: 0.25rem;
}

.action-button .arrow {
  flex-shrink: 0;
  width: 1.25rem;
  height: 1.25rem;
  color: rgb(148, 163, 184);
  transition: transform 0.2s ease, color 0.2s ease;
}

/* Dark mode styles */
.dark .management-card {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.15);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
}

.dark .management-card .card-header .title {
  color: rgb(241, 245, 249);
}

.dark .management-card .card-header .description {
  color: rgb(148, 163, 184);
}

.dark .action-button .title {
  color: rgb(241, 245, 249);
}

.dark .action-button .description {
  color: rgb(148, 163, 184);
}

.dark .action-button .arrow {
  color: rgb(148, 163, 184);
}

/* Optimized hover effects */
.action-button {
  position: relative;
  overflow: hidden;
}

.action-button::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
  transition: left 0.5s ease;
}

.action-button:hover {
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 12px 30px -8px rgba(0, 0, 0, 0.15), 0 4px 15px -3px rgba(0, 0, 0, 0.1);
}

.action-button:hover::before {
  left: 100%;
}

.action-button:hover .icon-container {
  transform: scale(1.1) rotate(5deg);
}

.action-button:hover .arrow {
  transform: translateX(0.5rem) scale(1.1);
  color: rgb(59, 130, 246);
}

.dark .action-button:hover {
  box-shadow: 0 12px 30px -8px rgba(0, 0, 0, 0.3), 0 4px 15px -3px rgba(0, 0, 0, 0.2);
}

.dark .action-button:hover .arrow {
  color: rgb(96, 165, 250);
}

/* Special hover effect for customer management */
.action-button[href*="customers"]:hover {
  background: linear-gradient(135deg, rgba(20, 184, 166, 0.1), rgba(6, 182, 212, 0.1));
  border-color: rgba(20, 184, 166, 0.3);
}

.dark .action-button[href*="customers"]:hover {
  background: linear-gradient(135deg, rgba(20, 184, 166, 0.15), rgba(6, 182, 212, 0.15));
  border-color: rgba(20, 184, 166, 0.4);
}
</style>
@endsection
