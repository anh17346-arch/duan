@extends('layouts.app')

@section('title', 'Chi tiết khách hàng - Perfume Luxury')

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
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">
                @if(app()->getLocale() === 'en')
                    Customer Details
                @else
                    Chi tiết khách hàng
                @endif
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mt-2">
                @if(app()->getLocale() === 'en')
                    View customer information and order history
                @else
                    Xem thông tin khách hàng và lịch sử đơn hàng
                @endif
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.customers.edit', $customer) }}" 
               class="group inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-5 h-5 mr-2 bg-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                @if(app()->getLocale() === 'en')
                    Edit Customer
                @else
                    Chỉnh sửa
                @endif
            </a>
            <a href="{{ route('admin.customers.index') }}" 
               class="group inline-flex items-center justify-center px-6 py-3 bg-white/20 dark:bg-white/5 hover:bg-white/30 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <div class="w-5 h-5 mr-2 bg-slate-400/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
                    </svg>
                </div>
                @if(app()->getLocale() === 'en')
                    Back to Customers
                @else
                    Quay lại danh sách
                @endif
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Customer Information -->
        <div class="lg:col-span-1">
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden mx-auto mb-4 shadow-lg border-2 border-white/20 dark:border-slate-600/20">
                        @if($customer->avatar)
                            <img src="{{ $customer->avatar_url }}" 
                                 alt="{{ $customer->name ?? 'Customer' }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.svg') }}'; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center\'><span class=\'text-white font-bold text-2xl\'>{{ strtoupper(substr($customer->name ?? 'NA', 0, 2)) }}</span></div>'">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center">
                                <span class="text-white font-bold text-2xl">
                                    {{ strtoupper(substr($customer->name ?? 'NA', 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $customer->name ?? 'N/A' }}</h2>
                    <p class="text-slate-600 dark:text-slate-400">ID: {{ $customer->id }}</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Email
                            @else
                                Email
                            @endif
                        </span>
                        <span class="text-sm text-slate-900 dark:text-slate-100">{{ $customer->email ?? 'N/A' }}</span>
                    </div>

                    @if($customer->phone)
                        <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                @if(app()->getLocale() === 'en')
                                    Phone
                                @else
                                    Số điện thoại
                                @endif
                            </span>
                            <span class="text-sm text-slate-900 dark:text-slate-100">{{ $customer->phone ?? 'N/A' }}</span>
                        </div>
                    @endif

                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Status
                            @else
                                Trạng thái
                            @endif
                        </span>
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
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Customer Type
                            @else
                                Phân loại
                            @endif
                        </span>
                        @php
                            $typeColors = [
                                'regular' => 'bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-400',
                                'vip' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'potential' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                'internal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'frequent_canceller' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                            ];
                            $typeLabels = [
                                'regular' => app()->getLocale() === 'en' ? 'Regular' : 'Khách hàng thường',
                                'vip' => app()->getLocale() === 'en' ? 'VIP' : 'Khách hàng VIP',
                                'potential' => app()->getLocale() === 'en' ? 'Potential' : 'Khách hàng tiềm năng',
                                'internal' => app()->getLocale() === 'en' ? 'Internal' : 'Khách hàng nội bộ',
                                'frequent_canceller' => app()->getLocale() === 'en' ? 'Frequent Canceller' : 'Thường xuyên hủy đơn'
                            ];
                            $typeIcons = [
                                'regular' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>',
                                'vip' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>',
                                'potential' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
                                'internal' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
                                'frequent_canceller' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $typeColors[$customer->customer_type ?? 'regular'] }} shadow-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $typeIcons[$customer->customer_type ?? 'regular'] !!}
                            </svg>
                            {{ $typeLabels[$customer->customer_type ?? 'regular'] }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Registration Date
                            @else
                                Ngày đăng ký
                            @endif
                        </span>
                        <span class="text-sm text-slate-900 dark:text-slate-100">{{ $customer->created_at ? $customer->created_at->format('d/m/Y H:i') : 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Total Orders
                            @else
                                Tổng đơn hàng
                            @endif
                        </span>
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                            {{ $totalOrders }} đơn
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Total Spent
                            @else
                                Tổng chi tiêu
                            @endif
                        </span>
                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                            {{ number_format($totalSpent, 0, ',', '.') }} ₫
                        </span>
                    </div>

                    @if($totalOrders > 0)
                        <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                @if(app()->getLocale() === 'en')
                                    Average Order Value
                                @else
                                    Trung bình/đơn
                                @endif
                            </span>
                            <span class="text-sm font-bold text-purple-600 dark:text-purple-400">
                                {{ number_format($totalSpent / $totalOrders, 0, ',', '.') }} ₫
                            </span>
                        </div>
                    @endif

                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            @if(app()->getLocale() === 'en')
                                Last Updated
                            @else
                                Cập nhật lần cuối
                            @endif
                        </span>
                        <span class="text-sm text-slate-900 dark:text-slate-100">{{ $customer->updated_at ? $customer->updated_at->format('d/m/Y H:i') : 'N/A' }}</span>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-slate-700">
                    <h3 class="text-sm font-medium text-slate-900 dark:text-slate-100 mb-3">
                        @if(app()->getLocale() === 'en')
                            Quick Actions
                        @else
                            Thao tác nhanh
                        @endif
                    </h3>
                    <div class="space-y-2">
                        @php
                            $confirmMessage = '';
                            if (($customer->status ?? '') === 'active') {
                                $confirmMessage = app()->getLocale() === 'en' 
                                    ? '🚫 DEACTIVATE CUSTOMER ACCOUNT\n\nAre you sure you want to deactivate this customer account?\n\nThis action will:\n• Prevent the customer from logging in\n• Block all purchase activities\n• Hide customer from active listings\n\nThis action can be reversed later.'
                                    : '🚫 VÔ HIỆU HÓA TÀI KHOẢN KHÁCH HÀNG\n\nBạn có chắc muốn vô hiệu hóa tài khoản khách hàng này?\n\nHành động này sẽ:\n• Ngăn khách hàng đăng nhập\n• Chặn tất cả hoạt động mua hàng\n• Ẩn khách hàng khỏi danh sách hoạt động\n\nHành động này có thể được hoàn tác sau này.';
                            } else {
                                $confirmMessage = app()->getLocale() === 'en'
                                    ? '✅ ACTIVATE CUSTOMER ACCOUNT\n\nAre you sure you want to activate this customer account?\n\nThis action will:\n• Restore customer login access\n• Allow purchase activities\n• Show customer in active listings\n\nThe customer will be able to use the system normally.'
                                    : '✅ KÍCH HOẠT TÀI KHOẢN KHÁCH HÀNG\n\nBạn có chắc muốn kích hoạt tài khoản khách hàng này?\n\nHành động này sẽ:\n• Khôi phục quyền đăng nhập của khách hàng\n• Cho phép hoạt động mua hàng\n• Hiển thị khách hàng trong danh sách hoạt động\n\nKhách hàng sẽ có thể sử dụng hệ thống bình thường.';
                            }
                        @endphp
                        
                        <form method="POST" action="{{ route('admin.customers.toggle-status', $customer) }}" class="w-full" onsubmit="return confirm('{{ $confirmMessage }}')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="{{ ($customer->status ?? '') === 'active' ? 'deactivate' : 'activate' }}">
                            <input type="hidden" name="confirmation" value="confirmed">
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-white/20 dark:hover:bg-white/10 transition-colors duration-200">
                                @if(($customer->status ?? '') === 'active')
                                    <span class="text-yellow-600 dark:text-yellow-400">
                                        @if(app()->getLocale() === 'en') Deactivate Account @else Vô hiệu hóa tài khoản @endif
                                    </span>
                                @else
                                    <span class="text-green-600 dark:text-green-400">
                                        @if(app()->getLocale() === 'en') Activate Account @else Kích hoạt tài khoản @endif
                                    </span>
                                @endif
                            </button>
                        </form>
                        
                        <!-- Change Customer Type -->
                        <div class="relative group">
                            <button type="button" class="w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-white/20 dark:hover:bg-white/10 transition-colors duration-200 text-blue-600 dark:text-blue-400" onclick="toggleCustomerTypeMenu()">
                                @if(app()->getLocale() === 'en')
                                    Change Customer Type
                                @else
                                    Thay đổi phân loại
                                @endif
                            </button>
                            <div id="customerTypeMenu" class="hidden absolute left-0 right-0 top-full mt-1 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 z-10">
                                @php
                                    $customerTypes = [
                                        'regular' => app()->getLocale() === 'en' ? 'Regular Customer' : 'Khách hàng thường',
                                        'vip' => app()->getLocale() === 'en' ? 'VIP Customer' : 'Khách hàng VIP',
                                        'potential' => app()->getLocale() === 'en' ? 'Potential Customer' : 'Khách hàng tiềm năng',
                                        'internal' => app()->getLocale() === 'en' ? 'Internal Customer' : 'Khách hàng nội bộ',
                                        'frequent_canceller' => app()->getLocale() === 'en' ? 'Frequent Canceller' : 'Thường xuyên hủy đơn'
                                    ];
                                @endphp
                                @foreach($customerTypes as $type => $label)
                                    <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="customer_type" value="{{ $type }}">
                                        <input type="hidden" name="name" value="{{ $customer->name }}">
                                        <input type="hidden" name="email" value="{{ $customer->email }}">
                                        <input type="hidden" name="phone" value="{{ $customer->phone }}">
                                        <input type="hidden" name="status" value="{{ $customer->status }}">
                                        <button type="submit" class="w-full text-left px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors duration-200 {{ $customer->customer_type === $type ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300' }}">
                                            @if($customer->customer_type === $type)
                                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                            {{ $label }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>

                        @if($customer->orders && $customer->orders()->count() === 0)
                            @php
                                $deleteMessage = app()->getLocale() === 'en' 
                                    ? 'Are you sure you want to delete this customer?' 
                                    : 'Bạn có chắc muốn xóa khách hàng này?';
                            @endphp
                            <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}" class="w-full" onsubmit="return confirm('{{ $deleteMessage }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-white/20 dark:hover:bg-white/10 transition-colors duration-200 text-red-600 dark:text-red-400">
                                    @if(app()->getLocale() === 'en')
                                        Delete Customer
                                    @else
                                        Xóa khách hàng
                                    @endif
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="lg:col-span-2">
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                        @if(app()->getLocale() === 'en')
                            Recent Orders
                        @else
                            Đơn hàng gần đây
                        @endif
                    </h3>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $totalOrders ?? 0 }} @if(app()->getLocale() === 'en') total orders @else tổng đơn hàng @endif
                        </span>
                        @if($totalOrders > 3)
                            <a href="{{ route('admin.customers.orders', $customer) }}" 
                               class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white text-xs font-medium rounded-lg transition-all duration-200">
                                @if(app()->getLocale() === 'en')
                                    View All
                                @else
                                    Xem tất cả
                                @endif
                            </a>
                        @endif
                    </div>
                </div>

                @if($recentOrders && $recentOrders->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                            <div class="border border-slate-200/60 dark:border-slate-700 rounded-xl p-4 hover:bg-white/10 dark:hover:bg-white/5 transition-colors duration-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-medium text-slate-900 dark:text-slate-100">
                                            #{{ $order->order_number ?? 'N/A' }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            @if(($order->status ?? '') === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @elseif(($order->status ?? '') === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif(($order->status ?? '') === 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                            @elseif(($order->status ?? '') === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @elseif(($order->status ?? '') === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                            @else bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-400 @endif shadow-sm">
                                            @if(app()->getLocale() === 'en')
                                                {{ ucfirst($order->status ?? 'unknown') }}
                                            @else
                                                @if(($order->status ?? '') === 'pending') Chờ xử lý
                                                @elseif(($order->status ?? '') === 'processing') Đang xử lý
                                                @elseif(($order->status ?? '') === 'shipped') Đã gửi hàng
                                                @elseif(($order->status ?? '') === 'delivered') Đã giao hàng
                                                @elseif(($order->status ?? '') === 'cancelled') Đã hủy
                                                @else {{ ucfirst($order->status ?? 'unknown') }} @endif
                                            @endif
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}
                                    </span>
                                </div>

                                <!-- Product Images Preview -->
                                @if($order->items && $order->items->count() > 0)
                                    <div class="flex items-center space-x-2 mb-3">
                                        @foreach($order->items->take(3) as $item)
                                            @if($item->product && $item->product->primaryImage)
                                                <div class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200/60 dark:border-slate-600/60">
                                                    <img src="{{ $item->product->primaryImage->image_url }}" 
                                                         alt="{{ $item->product->name ?? 'Product' }}" 
                                                         class="w-full h-full object-cover"
                                                         onerror="this.onerror=null; this.src='{{ asset('images/product-placeholder.png') }}'">
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                                <span class="text-xs text-slate-500 dark:text-slate-400">+{{ $order->items->count() - 3 }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-slate-600 dark:text-slate-400">
                                            {{ $order->items->count() }} @if(app()->getLocale() === 'en') items @else sản phẩm @endif
                                        </span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-600 dark:text-slate-400">
                                            {{ number_format($order->total ?? 0) }}đ
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-xs font-medium">
                                        @if(app()->getLocale() === 'en')
                                            View Details
                                        @else
                                            Xem chi tiết
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($totalOrders > 3)
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.customers.orders', $customer) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white text-sm font-medium rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                @if(app()->getLocale() === 'en')
                                    View All Orders
                                @else
                                    Xem tất cả đơn hàng
                                @endif
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-10 w-10 text-slate-400 dark:text-slate-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-base font-medium text-slate-900 dark:text-slate-100 mb-1">
                            @if(app()->getLocale() === 'en')
                                No Orders Yet
                            @else
                                Chưa có đơn hàng nào
                            @endif
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            @if(app()->getLocale() === 'en')
                                This customer hasn't placed any orders yet.
                            @else
                                Khách hàng này chưa đặt đơn hàng nào.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
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

<script>
function toggleCustomerTypeMenu() {
    const menu = document.getElementById('customerTypeMenu');
    menu.classList.toggle('hidden');
}

// Close menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('customerTypeMenu');
    const button = event.target.closest('button');
    
    if (!button || !button.onclick || button.onclick.toString().includes('toggleCustomerTypeMenu')) {
        return;
    }
    
    if (!menu.contains(event.target)) {
        menu.classList.add('hidden');
    }
});
</script>
@endsection
