@extends('layouts.app')

@section('title', 'Phương thức thanh toán - Perfume Luxury')

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
      <a href="{{ route('admin.payment-settings.index') }}" 
         class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
          </svg>
          @if(app()->getLocale() === 'en')
            Back to Payment Settings
          @else
            Quay lại Cấu hình thanh toán
          @endif
      </a>
  </div>

  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">
        @if(app()->getLocale() === 'en')
          Payment Methods
        @else
          Phương thức thanh toán
        @endif
      </h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">
        @if(app()->getLocale() === 'en')
          View and manage all available payment methods
        @else
          Xem và quản lý tất cả phương thức thanh toán hiện có
        @endif
      </p>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.payment-settings.index') }}" 
         class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        @if(app()->getLocale() === 'en')
          Configure Settings
        @else
          Cấu hình
        @endif
      </a>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/20">
          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Total Methods
            @else
              Tổng phương thức
            @endif
          </p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ count($availableMethods) }}</p>
        </div>
      </div>
    </div>

    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900/20">
          <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Active
            @else
              Đang hoạt động
            @endif
          </p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ count($availableMethods) }}</p>
        </div>
      </div>
    </div>

    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-yellow-100 dark:bg-yellow-900/20">
          <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              Timeout
            @else
              Thời gian hết hạn
            @endif
          </p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $settings->payment_timeout_minutes }}m</p>
        </div>
      </div>
    </div>

    <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900/20">
          <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">
            @if(app()->getLocale() === 'en')
              API Connected
            @else
              API đã kết nối
            @endif
          </p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">
            {{ ($settings->momo_partner_code && $settings->zalopay_partner_code) ? '2' : (($settings->momo_partner_code || $settings->zalopay_partner_code) ? '1' : '0') }}
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Payment Methods Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    @forelse($availableMethods as $method => $details)
      <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
              <div class="p-3 rounded-xl bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 mr-4">
                @if($method === 'bank')
                  <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                  </svg>
                @elseif($method === 'momo')
                  <svg class="w-8 h-8 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                @elseif($method === 'zalopay')
                  <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                @elseif($method === 'shopeepay')
                  <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                @endif
              </div>
              <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ $details['name'] }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ $details['description'] }}</p>
              </div>
            </div>
            <div class="flex items-center">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                @if(app()->getLocale() === 'en')
                  Active
                @else
                  Hoạt động
                @endif
              </span>
            </div>
          </div>

          <!-- Method Details -->
          <div class="bg-white/50 dark:bg-slate-800/50 rounded-xl p-4 border border-white/30 dark:border-slate-700/30">
            @if($method === 'bank')
              <div class="space-y-3">
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Bank Name:
                    @else
                      Tên ngân hàng:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100">{{ $settings->bank_name }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account Number:
                    @else
                      Số tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100 font-mono">{{ $settings->bank_account_number }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account Holder:
                    @else
                      Chủ tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100">{{ $settings->bank_account_holder }}</span>
                </div>
                @if($settings->bank_branch)
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Branch:
                    @else
                      Chi nhánh:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100">{{ $settings->bank_branch }}</span>
                </div>
                @endif
              </div>
            @elseif($method === 'momo')
              <div class="space-y-3">
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Phone Number:
                    @else
                      Số điện thoại:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100 font-mono">{{ $settings->momo_phone }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account Holder:
                    @else
                      Chủ tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100">{{ $settings->momo_holder }}</span>
                </div>
              </div>
            @elseif($method === 'zalopay')
              <div class="space-y-3">
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account ID:
                    @else
                      ID tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100 font-mono">{{ $settings->zalopay_id }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account Holder:
                    @else
                      Chủ tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100">{{ $settings->zalopay_holder }}</span>
                </div>
              </div>
            @elseif($method === 'shopeepay')
              <div class="space-y-3">
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account ID:
                    @else
                      ID tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100 font-mono">{{ $settings->shopeepay_id }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    @if(app()->getLocale() === 'en')
                      Account Holder:
                    @else
                      Chủ tài khoản:
                    @endif
                  </span>
                  <span class="text-sm text-slate-900 dark:text-slate-100">{{ $settings->shopeepay_holder }}</span>
                </div>
              </div>
            @endif
          </div>

          <!-- API Status -->
          @if(in_array($method, ['momo', 'zalopay']))
            <div class="mt-4 p-3 rounded-lg {{ $method === 'momo' && $settings->momo_partner_code ? 'bg-green-50 dark:bg-green-900/20' : ($method === 'zalopay' && $settings->zalopay_partner_code ? 'bg-green-50 dark:bg-green-900/20' : 'bg-yellow-50 dark:bg-yellow-900/20') }}">
              <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 {{ $method === 'momo' && $settings->momo_partner_code ? 'text-green-600 dark:text-green-400' : ($method === 'zalopay' && $settings->zalopay_partner_code ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm {{ $method === 'momo' && $settings->momo_partner_code ? 'text-green-700 dark:text-green-300' : ($method === 'zalopay' && $settings->zalopay_partner_code ? 'text-green-700 dark:text-green-300' : 'text-yellow-700 dark:text-yellow-300') }}">
                  @if($method === 'momo' && $settings->momo_partner_code)
                    @if(app()->getLocale() === 'en')
                      MoMo API Connected
                    @else
                      API MoMo đã kết nối
                    @endif
                  @elseif($method === 'zalopay' && $settings->zalopay_partner_code)
                    @if(app()->getLocale() === 'en')
                      ZaloPay API Connected
                    @else
                      API ZaloPay đã kết nối
                    @endif
                  @else
                    @if(app()->getLocale() === 'en')
                      Manual payment only
                    @else
                      Chỉ thanh toán thủ công
                    @endif
                  @endif
                </span>
              </div>
            </div>
          @endif
        </div>
      </div>
    @empty
      <div class="col-span-full">
        <div class="bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-12 text-center">
          <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">
            @if(app()->getLocale() === 'en')
              No Payment Methods Available
            @else
              Không có phương thức thanh toán nào
            @endif
          </h3>
          <p class="text-slate-600 dark:text-slate-400 mb-6">
            @if(app()->getLocale() === 'en')
              Configure payment methods in the settings to see them here.
            @else
              Cấu hình phương thức thanh toán trong cài đặt để xem chúng ở đây.
            @endif
          </p>
          <a href="{{ route('admin.payment-settings.index') }}" 
             class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            @if(app()->getLocale() === 'en')
              Configure Settings
            @else
              Cấu hình cài đặt
            @endif
          </a>
        </div>
      </div>
    @endforelse
  </div>

  <!-- QR Code Preview Section -->
  @if($settings->qr_logo_path || $settings->qr_primary_color)
  <div class="mt-8 bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 overflow-hidden">
    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
        </svg>
        @if(app()->getLocale() === 'en')
          QR Code Settings
        @else
          Cài đặt QR Code
        @endif
      </h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white/50 dark:bg-slate-800/50 rounded-xl p-4 border border-white/30 dark:border-slate-700/30">
          <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-3">
            @if(app()->getLocale() === 'en')
              Current Settings
            @else
              Cài đặt hiện tại
            @endif
          </h4>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">
                @if(app()->getLocale() === 'en')
                  Primary Color:
                @else
                  Màu chính:
                @endif
              </span>
              <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded border border-slate-300 dark:border-slate-600" style="background-color: {{ $settings->qr_primary_color }}"></div>
                <span class="text-slate-900 dark:text-slate-100">{{ $settings->qr_primary_color }}</span>
              </div>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">
                @if(app()->getLocale() === 'en')
                  Secondary Color:
                @else
                  Màu phụ:
                @endif
              </span>
              <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded border border-slate-300 dark:border-slate-600" style="background-color: {{ $settings->qr_secondary_color }}"></div>
                <span class="text-slate-900 dark:text-slate-100">{{ $settings->qr_secondary_color }}</span>
              </div>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">
                @if(app()->getLocale() === 'en')
                  Style:
                @else
                  Kiểu dáng:
                @endif
              </span>
              <span class="text-slate-900 dark:text-slate-100 capitalize">{{ $settings->qr_style }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">
                @if(app()->getLocale() === 'en')
                  Show Logo:
                @else
                  Hiển thị logo:
                @endif
              </span>
              <span class="text-slate-900 dark:text-slate-100">
                @if($settings->qr_show_logo)
                  @if(app()->getLocale() === 'en')
                    Yes
                  @else
                    Có
                  @endif
                @else
                  @if(app()->getLocale() === 'en')
                    No
                  @else
                    Không
                  @endif
                @endif
              </span>
            </div>
          </div>
        </div>
        
        @if($settings->qr_logo_path)
        <div class="bg-white/50 dark:bg-slate-800/50 rounded-xl p-4 border border-white/30 dark:border-slate-700/30">
          <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-3">
            @if(app()->getLocale() === 'en')
              QR Logo Preview
            @else
              Xem trước logo QR
            @endif
          </h4>
          <div class="flex items-center justify-center">
            <img src="{{ $settings->qr_logo_url }}" alt="QR Logo" class="w-24 h-24 object-contain rounded-lg border border-slate-200 dark:border-slate-600">
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
  @endif
</div>
@endsection
