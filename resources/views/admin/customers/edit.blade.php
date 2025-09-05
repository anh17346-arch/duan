@extends('layouts.app')

@section('title', 'Chỉnh sửa khách hàng - Perfume Luxury')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                @if(app()->getLocale() === 'en')
                    Edit Customer
                @else
                    Chỉnh sửa khách hàng
                @endif
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
                @if(app()->getLocale() === 'en')
                    Update customer information
                @else
                    Cập nhật thông tin khách hàng
                @endif
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.customers.show', $customer) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                @if(app()->getLocale() === 'en')
                    View Details
                @else
                    Xem chi tiết
                @endif
            </a>
            <a href="{{ route('admin.customers.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path>
                </svg>
                @if(app()->getLocale() === 'en')
                    Back to Customers
                @else
                    Quay lại danh sách
                @endif
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Customer Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        @if(app()->getLocale() === 'en')
                            Full Name
                        @else
                            Họ và tên
                        @endif
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="@if(app()->getLocale() === 'en') Enter full name @else Nhập họ và tên @endif">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="@if(app()->getLocale() === 'en') Enter email address @else Nhập địa chỉ email @endif">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        @if(app()->getLocale() === 'en')
                            Phone Number
                        @else
                            Số điện thoại
                        @endif
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="@if(app()->getLocale() === 'en') Enter phone number @else Nhập số điện thoại @endif">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        @if(app()->getLocale() === 'en')
                            Status
                        @else
                            Trạng thái
                        @endif
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">@if(app()->getLocale() === 'en') Select status @else Chọn trạng thái @endif</option>
                        <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>
                            @if(app()->getLocale() === 'en') Active @else Hoạt động @endif
                        </option>
                        <option value="inactive" {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>
                            @if(app()->getLocale() === 'en') Inactive @else Không hoạt động @endif
                        </option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        @if(app()->getLocale() === 'en')
                            New Password
                        @else
                            Mật khẩu mới
                        @endif
                    </label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="@if(app()->getLocale() === 'en') Leave blank to keep current password @else Để trống để giữ mật khẩu hiện tại @endif">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        @if(app()->getLocale() === 'en')
                            Confirm New Password
                        @else
                            Xác nhận mật khẩu mới
                        @endif
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="@if(app()->getLocale() === 'en') Confirm new password @else Xác nhận mật khẩu mới @endif">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.customers.show', $customer) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition-colors duration-200">
                    @if(app()->getLocale() === 'en')
                        Cancel
                    @else
                        Hủy
                    @endif
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    @if(app()->getLocale() === 'en')
                        Update Customer
                    @else
                        Cập nhật khách hàng
                    @endif
                </button>
            </div>
        </form>
    </div>

    <!-- Information Card -->
    <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                    @if(app()->getLocale() === 'en')
                        Update Information
                    @else
                        Thông tin cập nhật
                    @endif
                </h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    <li>• @if(app()->getLocale() === 'en') Email must be unique across all customers @else Email phải là duy nhất trong tất cả khách hàng @endif</li>
                    <li>• @if(app()->getLocale() === 'en') Leave password fields blank to keep the current password @else Để trống các trường mật khẩu để giữ mật khẩu hiện tại @endif</li>
                    <li>• @if(app()->getLocale() === 'en') If you change the password, the customer will need to use the new password for login @else Nếu bạn thay đổi mật khẩu, khách hàng sẽ cần sử dụng mật khẩu mới để đăng nhập @endif</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
