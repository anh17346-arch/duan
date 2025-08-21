@extends('layouts.guest')
@section('title', __('app.login'))

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-20">
  <div class="w-full max-w-xl">
    <!-- Modern Glass Card -->
    <div class="backdrop-blur-md bg-white/80 dark:bg-slate-800/80 rounded-3xl shadow-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden relative">
      <!-- Decorative Background Elements -->
      <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-gradient-to-r from-blue-400/20 to-purple-400/20 blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-gradient-to-r from-pink-400/20 to-rose-400/20 blur-3xl animate-pulse animation-delay-2000"></div>
      
      <div class="relative p-8 md:p-10" x-data="{ show:false, caps:false }">
        <!-- Header Section -->
        <div class="mb-8 text-center">
          <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white shadow-lg mb-4 hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
          </div>
          <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('app.login') }}
          </h1>
          <p class="text-slate-700 dark:text-slate-300 text-lg">
            @if(app()->getLocale() === 'en')
              Welcome back! Please sign in to your account 👋
            @else
              Chào mừng bạn quay lại! Vui lòng đăng nhập vào tài khoản của bạn 👋
            @endif
          </p>
        </div>
        
        @if (session('status'))
          <div class="mb-6 p-4 rounded-2xl bg-emerald-50/10 border border-emerald-200/20 text-emerald-300">
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6" autocomplete="off">
          @csrf

          {{-- Email --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Email <span class="text-rose-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required maxlength="255"
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

          {{-- Password --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.password') }} <span class="text-rose-500">*</span>
            </label>
            <div class="relative group">
              <input id="password" name="password" :type="show ? 'text' : 'password'"
                     required minlength="8" oncopy="return false" oncut="return false" onpaste="return false"
                     @keydown.cap="caps=$event.getModifierState && $event.getModifierState('CapsLock')"
                     @keyup.cap="caps=$event.getModifierState && $event.getModifierState('CapsLock')"
                     class="w-full px-5 py-4 pr-12 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 select-none placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
              <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors duration-200" @click="show=!show" tabindex="-1">
                <svg x-show="!show" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                </svg>
                <svg x-show="show" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M2 4l20 16-1.5 2L15 17.5A10.6 10.6 0 0112 19c-7 0-10-7-10-7a18.7 18.7 0 013.7-4.8L.5 6 2 4z"/>
                </svg>
              </button>
            </div>
            <p class="text-xs text-amber-600 mt-2 flex items-center" x-show="caps">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              @if(app()->getLocale() === 'en')
                Caps Lock is on
              @else
                Bạn đang bật Caps Lock
              @endif
            </p>
            @error('password') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Remember Me & Forgot Password --}}
          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center">
              <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
              <span class="ml-2 text-slate-800 dark:text-slate-200">{{ __('app.remember_me') }}</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium hover:underline transition-colors duration-200">
              {{ __('app.forgot_password') }}
            </a>
          </div>

          {{-- Submit Button --}}
          <div class="pt-4">
            <button class="group relative w-full px-6 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30 transition-all duration-300 hover:scale-[1.02] overflow-hidden">
              <!-- Shimmer effect -->
              <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
              
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('app.login') }}
              </span>
            </button>
            
            <p class="mt-6 text-center text-sm text-slate-700 dark:text-slate-300">
              @if(app()->getLocale() === 'en')
                Don't have an account?
              @else
                Chưa có tài khoản?
              @endif
              <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold hover:underline transition-colors duration-200 ml-1">
                {{ __('app.register_now') }}
              </a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection