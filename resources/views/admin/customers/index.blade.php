@extends('layouts.app')

@section('title', 'Quản lý khách hàng - Perfume Luxury')

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
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-slate-800 via-slate-700 to-slate-600 dark:from-slate-100 dark:via-slate-200 dark:to-slate-300 bg-clip-text text-transparent">
                            @if(app()->getLocale() === 'en')
                                Customer Management
                            @else
                                Quản lý khách hàng
                            @endif
                        </h1>
                    </div>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl">
                        @if(app()->getLocale() === 'en')
                            Manage customer accounts, view detailed information, and track their order history
                        @else
                            Quản lý tài khoản khách hàng, xem thông tin chi tiết và theo dõi lịch sử đơn hàng
                        @endif
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admin.customers.create') }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-5 h-5 mr-2 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        @if(app()->getLocale() === 'en')
                            Add Customer
                        @else
                            Thêm khách hàng
                        @endif
                    </a>
                    <a href="{{ route('admin.customers.statistics') }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-5 h-5 mr-2 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        @if(app()->getLocale() === 'en')
                            Statistics
                        @else
                            Thống kê
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                Total Customers
                            @else
                                Tổng khách hàng
                            @endif
                        </p>
                        <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $customers->total() ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                Active Customers
                            @else
                                Khách hàng hoạt động
                            @endif
                        </p>
                        <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $customers->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                New This Month
                            @else
                                Mới tháng này
                            @endif
                        </p>
                        <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $customers->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10 hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                Inactive
                            @else
                                Không hoạt động
                            @endif
                        </p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $customers->where('status', 'inactive')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-8 mb-8 shadow-lg border border-white/30 dark:border-white/10">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Search Input -->
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Search Customers
                            @else
                                Tìm kiếm khách hàng
                            @endif
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="@if(app()->getLocale() === 'en') Name, email, phone... @else Tên, email, số điện thoại... @endif"
                                   class="block w-full pl-12 pr-4 py-4 border-0 bg-white/50 dark:bg-slate-700/50 rounded-2xl text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-slate-700 transition-all duration-300 shadow-sm hover:shadow-md">
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Account Status
                            @else
                                Trạng thái tài khoản
                            @endif
                        </label>
                        <select id="status" 
                                name="status" 
                                class="block w-full px-4 py-4 border-0 bg-white/50 dark:bg-slate-700/50 rounded-2xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-slate-700 transition-all duration-300 shadow-sm hover:shadow-md">
                            <option value="">@if(app()->getLocale() === 'en') All Status @else Tất cả trạng thái @endif</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Active @else Hoạt động @endif
                            </option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Inactive @else Không hoạt động @endif
                            </option>
                        </select>
                    </div>
                    
                    <!-- Sort By -->
                    <div class="space-y-2">
                        <label for="sort_by" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Sort By
                            @else
                                Sắp xếp theo
                            @endif
                        </label>
                        <select id="sort_by" 
                                name="sort_by" 
                                class="block w-full px-4 py-4 border-0 bg-white/50 dark:bg-slate-700/50 rounded-2xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-slate-700 transition-all duration-300 shadow-sm hover:shadow-md">
                            <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Registration Date @else Ngày đăng ký @endif
                            </option>
                            <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Name @else Tên @endif
                            </option>
                            <option value="email" {{ request('sort_by') === 'email' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Email @else Email @endif
                            </option>
                        </select>
                    </div>
                    
                    <!-- Sort Order -->
                    <div class="space-y-2">
                        <label for="sort_order" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Order
                            @else
                                Thứ tự
                            @endif
                        </label>
                        <select id="sort_order" 
                                name="sort_order" 
                                class="block w-full px-4 py-4 border-0 bg-white/50 dark:bg-slate-700/50 rounded-2xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-slate-700 transition-all duration-300 shadow-sm hover:shadow-md">
                            <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Newest First @else Mới nhất trước @endif
                            </option>
                            <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>
                                @if(app()->getLocale() === 'en') Oldest First @else Cũ nhất trước @endif
                            </option>
                        </select>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end gap-4">
                    <button type="submit" 
                            class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-5 h-5 mr-2 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        @if(app()->getLocale() === 'en')
                            Search
                        @else
                            Tìm kiếm
                        @endif
                    </button>
                    <a href="{{ route('admin.customers.index') }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 bg-white/50 dark:bg-slate-700/50 hover:bg-white dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-5 h-5 mr-2 bg-slate-400/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        @if(app()->getLocale() === 'en')
                            Reset
                        @else
                            Đặt lại
                        @endif
                    </a>
                </div>
            </form>
        </div>

        <!-- Customers List Section -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden">
            @if($customers && $customers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    @if(app()->getLocale() === 'en')
                                        Customer
                                    @else
                                        Khách hàng
                                    @endif
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    @if(app()->getLocale() === 'en')
                                        Contact Info
                                    @else
                                        Thông tin liên hệ
                                    @endif
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    @if(app()->getLocale() === 'en')
                                        Status
                                    @else
                                        Trạng thái
                                    @endif
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    @if(app()->getLocale() === 'en')
                                        Joined
                                    @else
                                        Tham gia
                                    @endif
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    @if(app()->getLocale() === 'en')
                                        Actions
                                    @else
                                        Thao tác
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($customers as $customer)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-all duration-300 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                @if($customer->avatar)
                                                    <div class="w-12 h-12 rounded-xl overflow-hidden mr-3 shadow-lg group-hover:scale-110 transition-transform duration-300 border-2 border-white/20 dark:border-slate-600/20">
                                                        <img src="{{ $customer->avatar_url }}" 
                                                             alt="{{ $customer->name ?? 'Customer' }}" 
                                                             class="w-full h-full object-cover"
                                                             onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.svg') }}'; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center\'><span class=\'text-white font-bold text-sm\'>{{ strtoupper(substr($customer->name ?? 'NA', 0, 2)) }}</span></div>'">
                                                    </div>
                                                @else
                                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center mr-3 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                        <span class="text-white font-bold text-sm">
                                                            {{ strtoupper(substr($customer->name ?? 'NA', 0, 2)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white dark:border-slate-800 shadow-sm"></div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-base font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200 truncate">
                                                    {{ $customer->name ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                                    ID: {{ $customer->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center text-slate-900 dark:text-white">
                                                <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-2">
                                                    <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium truncate">{{ $customer->email ?? 'N/A' }}</span>
                                            </div>
                                            @if($customer->phone)
                                                <div class="flex items-center text-slate-600 dark:text-slate-400">
                                                    <div class="w-6 h-6 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-2">
                                                        <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm font-medium truncate">{{ $customer->phone ?? 'N/A' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ ($customer->status ?? '') === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }} shadow-sm">
                                            @if(($customer->status ?? '') === 'active')
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                @if(app()->getLocale() === 'en') Active @else Hoạt động @endif
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                @if(app()->getLocale() === 'en') Inactive @else Không hoạt động @endif
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center text-slate-900 dark:text-white">
                                            <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-2">
                                                <svg class="w-3 h-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">{{ $customer->created_at ? $customer->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.customers.show', $customer) }}" 
                                               class="group relative inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-cyan-500 via-blue-500 to-indigo-600 hover:from-cyan-600 hover:via-blue-600 hover:to-indigo-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 hover:scale-110 transition-all duration-300 overflow-hidden">
                                                <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                                <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.customers.edit', $customer) }}" 
                                               class="group relative inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-400 via-orange-500 to-red-500 hover:from-amber-500 hover:via-orange-600 hover:to-red-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 hover:scale-110 transition-all duration-300 overflow-hidden">
                                                <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                                <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            @if($customer->orders && $customer->orders()->count() === 0)
                                                <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" 
                                                      class="inline" 
                                                      onsubmit="return confirm('@if(app()->getLocale() === 'en') Are you sure you want to delete this customer? @else Bạn có chắc muốn xóa khách hàng này? @endif')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="group relative inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-rose-500 via-pink-500 to-red-600 hover:from-rose-600 hover:via-pink-600 hover:to-red-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 hover:scale-110 transition-all duration-300 overflow-hidden">
                                                        <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"></div>
                                                        <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($customers && $customers->hasPages())
                    <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 border-t border-slate-200 dark:border-slate-700">
                        {{ $customers->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="relative inline-block">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-slate-200 via-slate-300 to-slate-400 dark:from-slate-800 dark:via-slate-700 dark:to-slate-600 flex items-center justify-center shadow-2xl">
                            <svg class="w-12 h-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                        @if(app()->getLocale() === 'en')
                            No Customers Found
                        @else
                            Không tìm thấy khách hàng nào
                        @endif
                    </h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-md mx-auto mb-6">
                        @if(app()->getLocale() === 'en')
                            Try adjusting your search criteria or add a new customer to get started.
                        @else
                            Hãy thử điều chỉnh tiêu chí tìm kiếm hoặc thêm khách hàng mới để bắt đầu.
                        @endif
                    </p>
                    <a href="{{ route('admin.customers.create') }}" 
                       class="group inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-4 h-4 mr-2 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        @if(app()->getLocale() === 'en')
                            Add Your First Customer
                        @else
                            Thêm khách hàng đầu tiên
                        @endif
                    </a>
                </div>
            @endif
        </div>
    </div>
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
</style>
@endsection
