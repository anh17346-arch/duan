@extends('layouts.app')

@section('title', 'Cấu hình thanh toán')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Cấu hình thanh toán</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Quản lý thông tin thanh toán và cài đặt hệ thống</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.payment-settings.methods') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                @if(app()->getLocale() === 'en')
                    View All Methods
                @else
                    Xem tất cả phương thức
                @endif
            </a>
            <button type="button" onclick="document.getElementById('payment-form').submit()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                @if(app()->getLocale() === 'en')
                    Save Settings
                @else
                    Lưu cài đặt
                @endif
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tổng quan phương thức thanh toán -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-blue-100 dark:from-green-900/20 dark:to-blue-900/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tổng quan phương thức thanh toán</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Xem tất cả phương thức thanh toán hiện có và trạng thái hoạt động</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Tổng cộng:</span>
                    <span class="bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 text-sm font-medium px-3 py-1 rounded-full">
                        {{ count($settings->getAvailablePaymentMethods()) }} phương thức
                    </span>
                    <a href="{{ route('admin.payment-settings.methods') }}" 
                       class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-medium transition-colors duration-200">
                        @if(app()->getLocale() === 'en')
                            View Details →
                        @else
                            Xem chi tiết →
                        @endif
                    </a>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $availableMethods = $settings->getAvailablePaymentMethods();
                    $methodIcons = [
                        'bank' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
                        'momo' => '<span class="font-bold text-sm">M</span>',
                        'zalopay' => '<span class="font-bold text-sm">Z</span>',
                        'shopeepay' => '<span class="font-bold text-sm">S</span>'
                    ];
                    $methodColors = [
                        'bank' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
                        'momo' => 'bg-pink-100 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400',
                        'zalopay' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
                        'shopeepay' => 'bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400'
                    ];
                    $methodNames = [
                        'bank' => 'Chuyển khoản ngân hàng',
                        'momo' => 'MoMo',
                        'zalopay' => 'ZaloPay',
                        'shopeepay' => 'ShopeePay'
                    ];
                @endphp

                @foreach($availableMethods as $method => $details)
                    @php
                        $methodDetails = $settings->getPaymentMethodDetails($method);
                    @endphp
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 {{ $methodColors[$method] }} rounded-lg flex items-center justify-center">
                                    {!! $methodIcons[$method] !!}
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $methodNames[$method] }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        @if($method === 'bank')
                                            {{ $methodDetails['name'] ?? 'Chưa cấu hình' }}
                                        @else
                                            {{ $methodDetails['phone'] ?? $methodDetails['id'] ?? 'Chưa cấu hình' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Hoạt động
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            @if($method === 'bank')
                                @if($methodDetails['account_number'])
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Số TK:</span>
                                        <span class="font-mono text-gray-900 dark:text-white">{{ $methodDetails['account_number'] }}</span>
                                    </div>
                                @endif
                                @if($methodDetails['account_holder'])
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Chủ TK:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $methodDetails['account_holder'] }}</span>
                                    </div>
                                @endif
                            @else
                                @if($methodDetails['holder'])
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Chủ ví:</span>
                                        <span class="text-gray-900 dark:text-white">{{ $methodDetails['holder'] }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500 dark:text-gray-400">API tích hợp:</span>
                                @if($method === 'momo' && $settings->momo_partner_code)
                                    <span class="text-green-600 dark:text-green-400 font-medium">✓ Đã cấu hình</span>
                                @elseif($method === 'zalopay' && $settings->zalopay_partner_code)
                                    <span class="text-green-600 dark:text-green-400 font-medium">✓ Đã cấu hình</span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Chưa cấu hình</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(empty($availableMethods))
                    <div class="md:col-span-2 lg:col-span-3">
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Chưa có phương thức thanh toán nào</h3>
                            <p class="text-gray-500 dark:text-gray-400">Hãy cấu hình ít nhất một phương thức thanh toán bên dưới</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Thống kê nhanh -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ count($availableMethods) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Phương thức</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $settings->bank_enabled ? 1 : 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Ngân hàng</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ ($settings->momo_enabled ? 1 : 0) + ($settings->zalopay_enabled ? 1 : 0) + ($settings->shopeepay_enabled ? 1 : 0) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Ví điện tử</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                            {{ ($settings->momo_partner_code ? 1 : 0) + ($settings->zalopay_partner_code ? 1 : 0) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">API tích hợp</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="payment-form" method="POST" action="{{ route('admin.payment-settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Ngân hàng -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin ngân hàng</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cấu hình thông tin chuyển khoản ngân hàng</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="bank_enabled" class="sr-only peer" {{ $settings->bank_enabled ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Kích hoạt</span>
                    </label>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên ngân hàng</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $settings->bank_name) }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="VD: Vietcombank, MB Bank, Techcombank...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Số tài khoản</label>
                        <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $settings->bank_account_number) }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="VD: 1234567890">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên chủ tài khoản</label>
                        <input type="text" name="bank_account_holder" value="{{ old('bank_account_holder', $settings->bank_account_holder) }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="VD: CÔNG TY TNHH ABC">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Chi nhánh (tùy chọn)</label>
                        <input type="text" name="bank_branch" value="{{ old('bank_branch', $settings->bank_branch) }}" 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="VD: Chi nhánh Hà Nội">
                    </div>
                </div>
            </div>
        </div>

        <!-- Ví điện tử -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Ví điện tử
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- MoMo -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-pink-100 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                                <span class="text-pink-600 dark:text-pink-400 font-bold text-sm">M</span>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">MoMo</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="momo_enabled" class="sr-only peer" {{ $settings->momo_enabled ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 dark:peer-focus:ring-pink-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-pink-600"></div>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Số điện thoại MoMo</label>
                            <input type="text" name="momo_phone" value="{{ old('momo_phone', $settings->momo_phone) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                   placeholder="VD: 0901234567">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên chủ ví</label>
                            <input type="text" name="momo_holder" value="{{ old('momo_holder', $settings->momo_holder) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                   placeholder="VD: Nguyễn Văn A">
                        </div>
                    </div>
                </div>

                <!-- ZaloPay -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">Z</span>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">ZaloPay</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="zalopay_enabled" class="sr-only peer" {{ $settings->zalopay_enabled ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ID ZaloPay</label>
                            <input type="text" name="zalopay_id" value="{{ old('zalopay_id', $settings->zalopay_id) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="VD: 0901234567 hoặc ID tài khoản">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên chủ ví</label>
                            <input type="text" name="zalopay_holder" value="{{ old('zalopay_holder', $settings->zalopay_holder) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="VD: Nguyễn Văn A">
                        </div>
                    </div>
                </div>

                <!-- ShopeePay -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                <span class="text-orange-600 dark:text-orange-400 font-bold text-sm">S</span>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">ShopeePay</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="shopeepay_enabled" class="sr-only peer" {{ $settings->shopeepay_enabled ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600"></div>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ID ShopeePay</label>
                            <input type="text" name="shopeepay_id" value="{{ old('shopeepay_id', $settings->shopeepay_id) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="VD: 0901234567 hoặc ID tài khoản">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tên chủ ví</label>
                            <input type="text" name="shopeepay_holder" value="{{ old('shopeepay_holder', $settings->shopeepay_holder) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="VD: Nguyễn Văn A">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Keys -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    API Keys (Tích hợp thanh toán online)
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- MoMo API -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <span class="w-6 h-6 bg-pink-100 dark:bg-pink-900/20 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-pink-600 dark:text-pink-400 font-bold text-sm">M</span>
                        </span>
                        MoMo API
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner Code</label>
                            <input type="text" name="momo_partner_code" value="{{ old('momo_partner_code', $settings->momo_partner_code) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                   placeholder="Partner Code từ MoMo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Access Key</label>
                            <input type="text" name="momo_access_key" value="{{ old('momo_access_key', $settings->momo_access_key) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                   placeholder="Access Key từ MoMo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Secret Key</label>
                            <input type="password" name="momo_secret_key" value="{{ old('momo_secret_key', $settings->momo_secret_key) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                   placeholder="Secret Key từ MoMo">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Callback URL</label>
                            <input type="url" name="momo_callback_url" value="{{ old('momo_callback_url', $settings->momo_callback_url) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                   placeholder="https://yourdomain.com/api/momo/callback">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="testApiConnection('momo')" 
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm">
                            Test kết nối MoMo API
                        </button>
                    </div>
                </div>

                <!-- ZaloPay API -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <span class="w-6 h-6 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">Z</span>
                        </span>
                        ZaloPay API
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Partner Code</label>
                            <input type="text" name="zalopay_partner_code" value="{{ old('zalopay_partner_code', $settings->zalopay_partner_code) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Partner Code từ ZaloPay">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Access Key</label>
                            <input type="text" name="zalopay_access_key" value="{{ old('zalopay_access_key', $settings->zalopay_access_key) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Access Key từ ZaloPay">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Secret Key</label>
                            <input type="password" name="zalopay_secret_key" value="{{ old('zalopay_secret_key', $settings->zalopay_secret_key) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Secret Key từ ZaloPay">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Callback URL</label>
                            <input type="url" name="zalopay_callback_url" value="{{ old('zalopay_callback_url', $settings->zalopay_callback_url) }}" 
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://yourdomain.com/api/zalopay/callback">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="testApiConnection('zalopay')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 text-sm">
                            Test kết nối ZaloPay API
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                    </svg>
                    Cài đặt QR Code
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo thương hiệu</label>
                        <div class="flex items-center space-x-4">
                            @if($settings->qr_logo_path)
                                <div class="relative">
                                    <img src="{{ $settings->qr_logo_url }}" alt="QR Logo" class="w-16 h-16 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                                    <button type="button" onclick="deleteQrLogo()" 
                                            class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                        ×
                                    </button>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="qr_logo" accept="image/*" 
                                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, GIF tối đa 2MB</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Màu chính</label>
                        <input type="color" name="qr_primary_color" value="{{ old('qr_primary_color', $settings->qr_primary_color) }}" 
                               class="w-full h-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Màu phụ</label>
                        <input type="color" name="qr_secondary_color" value="{{ old('qr_secondary_color', $settings->qr_secondary_color) }}" 
                               class="w-full h-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kiểu QR Code</label>
                        <select name="qr_style" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="square" {{ $settings->qr_style == 'square' ? 'selected' : '' }}>Vuông</option>
                            <option value="rounded" {{ $settings->qr_style == 'rounded' ? 'selected' : '' }}>Bo tròn</option>
                            <option value="circle" {{ $settings->qr_style == 'circle' ? 'selected' : '' }}>Tròn</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="qr_show_logo" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ $settings->qr_show_logo ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Hiển thị logo ở giữa QR Code</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Timeout -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Thời gian hết hạn thanh toán
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Thời gian hết hạn (phút)</label>
                        <select name="payment_timeout_minutes" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="5" {{ $settings->payment_timeout_minutes == 5 ? 'selected' : '' }}>5 phút</option>
                            <option value="15" {{ $settings->payment_timeout_minutes == 15 ? 'selected' : '' }}>15 phút</option>
                            <option value="30" {{ $settings->payment_timeout_minutes == 30 ? 'selected' : '' }}>30 phút</option>
                            <option value="60" {{ $settings->payment_timeout_minutes == 60 ? 'selected' : '' }}>1 giờ</option>
                            <option value="120" {{ $settings->payment_timeout_minutes == 120 ? 'selected' : '' }}>2 giờ</option>
                            <option value="1440" {{ $settings->payment_timeout_minutes == 1440 ? 'selected' : '' }}>24 giờ</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Lưu ý</p>
                                    <p class="text-xs text-yellow-700 dark:text-yellow-300">Đơn hàng sẽ tự động hết hạn sau thời gian này nếu chưa thanh toán</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function testApiConnection(method) {
    fetch('{{ route("admin.payment-settings.test-api") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ method: method })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        alert('❌ Lỗi kết nối: ' + error.message);
    });
}

function deleteQrLogo() {
    if (confirm('Bạn có chắc muốn xóa logo QR Code?')) {
        fetch('{{ route("admin.payment-settings.delete-qr-logo") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            alert('❌ Lỗi: ' + error.message);
        });
    }
}
</script>
@endsection
