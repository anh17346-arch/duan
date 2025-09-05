@extends('layouts.admin')

@section('title', __('app.system_management') . ' - Perfume Luxury')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  <x-admin.page-header 
    :title="__('app.system_management')"
    :subtitle="app()->getLocale() === 'en' ? 'Important management functions for admin' : 'Các chức năng quản lý quan trọng dành cho admin'"
    :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'/></svg>'"
  />

  <!-- Quick Stats -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-admin.stats-card
      title="Tổng sản phẩm"
      :value="$totalProducts ?? 0"
      color="blue"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\'/></svg>'"
    />
    
    <x-admin.stats-card
      title="Đơn hàng mới"
      :value="$newOrders ?? 0"
      color="green"
      trend="up"
      :trendValue="'+12%'"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\'/></svg>'"
    />
    
    <x-admin.stats-card
      title="Khách hàng"
      :value="$totalCustomers ?? 0"
      color="purple"
      trend="up"
      :trendValue="'+8%'"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\'/></svg>'"
    />
    
    <x-admin.stats-card
      title="Doanh thu tháng"
      :value="number_format($monthlyRevenue ?? 0) . ' VND'"
      color="cyan"
      trend="up"
      :trendValue="'+15%'"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>'"
    />
  </div>

  <!-- Management Sections -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    <!-- Products Management -->
    <x-admin.management-card
      :title="__('app.product_management')"
      :description="app()->getLocale() === 'en' ? 'Add, edit, delete products' : 'Thêm, sửa, xóa sản phẩm'"
      :href="route('admin.products.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\'/></svg>'"
      :stats="[['value' => $totalProducts ?? 0, 'label' => 'Tổng sản phẩm'], ['value' => $activeProducts ?? 0, 'label' => 'Đang bán']]"
    />

    <!-- Categories Management -->
    <x-admin.management-card
      :title="__('app.category_management')"
      :description="app()->getLocale() === 'en' ? 'Add, edit, delete categories' : 'Thêm, sửa, xóa danh mục'"
      :href="route('admin.categories.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z\'/></svg>'"
      :stats="[['value' => $totalCategories ?? 0, 'label' => 'Tổng danh mục'], ['value' => $activeCategories ?? 0, 'label' => 'Đang hoạt động']]"
    />

    <!-- Orders Management -->
    <x-admin.management-card
      :title="__('app.order_management')"
      :description="app()->getLocale() === 'en' ? 'View and manage orders' : 'Xem và quản lý đơn hàng'"
      :href="route('admin.orders.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\'/></svg>'"
      :stats="[['value' => $totalOrders ?? 0, 'label' => 'Tổng đơn hàng'], ['value' => $pendingOrders ?? 0, 'label' => 'Chờ xử lý']]"
    />

    <!-- Customer Management -->
    <x-admin.management-card
      :title="app()->getLocale() === 'en' ? 'Customer Management' : 'Quản lý khách hàng'"
      :description="app()->getLocale() === 'en' ? 'Manage customer accounts and information' : 'Quản lý tài khoản và thông tin khách hàng'"
      :href="route('admin.customers.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\'/></svg>'"
      :stats="[['value' => $totalCustomers ?? 0, 'label' => 'Tổng khách hàng'], ['value' => $activeCustomers ?? 0, 'label' => 'Hoạt động']]"
    />

    <!-- Promotions Management -->
    <x-admin.management-card
      :title="__('app.promotion_management')"
      :description="app()->getLocale() === 'en' ? 'Manage promotion programs' : 'Quản lý chương trình khuyến mãi'"
      :href="route('admin.promotions.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1\'/></svg>'"
      :stats="[['value' => $totalPromotions ?? 0, 'label' => 'Tổng khuyến mãi'], ['value' => $activePromotions ?? 0, 'label' => 'Đang hoạt động']]"
    />

    <!-- Reviews Management -->
    <x-admin.management-card
      title="Quản lý đánh giá"
      description="Duyệt và quản lý đánh giá từ khách hàng"
      :href="route('admin.reviews.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z\'/></svg>'"
      :stats="[['value' => $totalReviews ?? 0, 'label' => 'Tổng đánh giá'], ['value' => $pendingReviews ?? 0, 'label' => 'Chờ duyệt']]"
    />

    <!-- Payment Settings -->
    <x-admin.management-card
      title="Cấu hình thanh toán"
      description="Quản lý thông tin thanh toán và cài đặt hệ thống"
      :href="route('admin.payment-settings.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'/></svg>'"
      :stats="[['value' => $paymentMethods ?? 0, 'label' => 'Phương thức'], ['value' => $activePayments ?? 0, 'label' => 'Đang hoạt động']]"
    />

    <!-- Analytics -->
    <x-admin.management-card
      :title="app()->getLocale() === 'en' ? 'Revenue Reports' : 'Báo cáo doanh thu'"
      :description="app()->getLocale() === 'en' ? 'View revenue analytics and financial reports' : 'Xem phân tích doanh thu và báo cáo tài chính'"
      :href="route('admin.analytics.index')"
      :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\'/></svg>'"
      :stats="[['value' => number_format($monthlyRevenue ?? 0), 'label' => 'Doanh thu tháng'], ['value' => number_format($yearlyRevenue ?? 0), 'label' => 'Doanh thu năm']]"
    />
  </div>

  <!-- Notifications Section -->
  <div class="admin-card p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 flex items-center">
        <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        {{ __('app.my_notifications') }}
      </h3>
      <a href="{{ route('notifications.index') }}" class="admin-btn-secondary">
        {{ __('app.view_all') }}
      </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <x-admin.stats-card
        :title="__('app.total_notifications')"
        :value="auth()->user()->notifications()->count()"
        color="blue"
        :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 17h5l-5 5v-5z\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z\'/></svg>'"
      />
      
      <x-admin.stats-card
        :title="__('app.unread')"
        :value="auth()->user()->unread_notifications_count"
        color="red"
        :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>'"
      />
      
      <x-admin.stats-card
        :title="__('app.read')"
        :value="auth()->user()->notifications()->count() - auth()->user()->unread_notifications_count"
        color="green"
        :icon="'<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>'"
      />
    </div>
    
    <!-- Recent Notifications -->
    @php
      $recentNotifications = auth()->user()->notifications()->limit(3)->get();
    @endphp
    @if($recentNotifications->count() > 0)
      <div class="space-y-3">
        @foreach($recentNotifications as $notification)
          <div class="flex items-center p-4 bg-white/30 dark:bg-slate-800/30 rounded-xl border border-white/30 dark:border-slate-700/30 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $notification->color_classes }} dark:bg-opacity-20 mr-4">
              <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">{{ $notification->title }}</p>
              <p class="text-xs text-slate-600 dark:text-slate-400">{{ $notification->time_ago }}</p>
            </div>
            @if(!$notification->pivot->is_read)
              <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
            @endif
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-8">
        <svg class="w-16 h-16 text-slate-400 dark:text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        <p class="text-lg text-slate-600 dark:text-slate-400">{{ __('app.no_notifications') }}</p>
      </div>
    @endif
  </div>

  <!-- Quick Actions -->
  <div class="admin-card p-6">
    <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-6">{{ __('app.quick_actions') }}</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
      <a href="{{ route('admin.products.create') }}" class="admin-btn-success flex-col p-6 text-center">
        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span class="text-sm font-medium">{{ __('app.add_new_product') }}</span>
      </a>

      <a href="{{ route('admin.categories.create') }}" class="admin-btn-primary flex-col p-6 text-center">
        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span class="text-sm font-medium">{{ __('app.add_new_category') }}</span>
      </a>
      
      <a href="{{ route('admin.orders.index') }}" class="admin-btn-secondary flex-col p-6 text-center">
        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
        <span class="text-sm font-medium">{{ __('app.order_management') }}</span>
      </a>
      
      <a href="{{ route('admin.promotions.create') }}" class="admin-btn-primary flex-col p-6 text-center">
        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
        </svg>
        <span class="text-sm font-medium">{{ __('app.create_promotion') }}</span>
      </a>
      
      <a href="{{ route('admin.analytics.index') }}" class="admin-btn-secondary flex-col p-6 text-center">
        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        <span class="text-sm font-medium">{{ __('app.analytics_dashboard') }}</span>
      </a>
    </div>
  </div>
</div>
@endsection