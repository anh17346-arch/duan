@extends('layouts.guest')
@section('title', __('app.forgot_password'))

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-20">
  <div class="w-full max-w-xl">
    <!-- Modern Glass Card -->
    <div class="backdrop-blur-md bg-white/80 dark:bg-slate-800/80 rounded-3xl shadow-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden relative">
      <!-- Decorative Background Elements -->
      <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-gradient-to-r from-blue-400/20 to-purple-400/20 blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-gradient-to-r from-pink-400/20 to-rose-400/20 blur-3xl animate-pulse animation-delay-2000"></div>
      
      <div class="relative p-8 md:p-10">
        <!-- Header Section -->
        <div class="mb-8 text-center">
          <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white shadow-lg mb-4 hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
          </div>
          <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('app.forgot_password') }}
          </h1>
          <p class="text-slate-700 dark:text-slate-300 text-lg">
            @if(app()->getLocale() === 'en')
              No problem! Just let us know your email address and we will email you a password reset link.
            @else
              Không sao! Chỉ cần cho chúng tôi biết địa chỉ email và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu.
            @endif
          </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
          <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300">
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
          @csrf

          <!-- Email Address -->
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Email <span class="text-rose-500">*</span>
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="name@example.com"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            @error('email') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          <!-- Submit Button -->
          <div class="pt-4">
            <button class="group relative w-full px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30 transition-all duration-300 hover:scale-[1.02] overflow-hidden">
              <!-- Shimmer effect -->
              <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
              
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                {{ __('app.email_password_reset_link') }}
              </span>
            </button>
            
            <p class="mt-6 text-center text-sm text-slate-700 dark:text-slate-300">
              @if(app()->getLocale() === 'en')
                Remember your password?
              @else
                Nhớ mật khẩu của bạn?
              @endif
              <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300 font-semibold hover:underline transition-colors duration-200 ml-1">
                {{ __('app.back_to_login') }}
              </a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
