<!doctype html>
<html lang="vi" class="h-full"
      x-data="{ dark: (localStorage.theme ?? 'light') === 'dark' }"
      x-init="
        document.documentElement.classList.toggle('dark', dark);
        $watch('dark', v => {
          localStorage.theme = v ? 'dark' : 'light';
          document.documentElement.classList.toggle('dark', v);
        });
      ">
<head>
  <meta charset="utf-8" />
  <title>@yield('title','Bảng điều khiển')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Local CSS and JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .glass { backdrop-filter: blur(8px); background: linear-gradient(180deg, rgba(255,255,255,.7), rgba(255,255,255,.5)); }
    .dark .glass { background: linear-gradient(180deg, rgba(30,41,59,.7), rgba(30,41,59,.5)); }
    
    /* Critical dark mode options fix */
    html.dark select option {
      background-color: #1e293b !important;
      color: #f1f5f9 !important;
    }
    
    html.dark select option.bg-white {
      background-color: #1e293b !important;
    }
    
    html.dark select option.text-slate-900 {
      color: #f1f5f9 !important;
    }
    
    html.dark select option.dark\:bg-slate-700 {
      background-color: #1e293b !important;
    }
    
    html.dark select option.dark\:text-slate-100 {
      color: #f1f5f9 !important;
    }
    
    /* Additional admin area select fixes */
    .admin-area select,
    .admin-area select option {
      background-color: #1e293b !important;
      color: #f1f5f9 !important;
    }
    
    .admin-area select option:hover {
      background-color: #334155 !important;
      color: #ffffff !important;
    }
    
    .admin-area select option:checked,
    .admin-area select option:selected {
      background-color: #3b82f6 !important;
      color: #ffffff !important;
    }
    
    /* Force dark mode for all select elements in admin */
    html.dark .admin-area select,
    html.dark .admin-area select option {
      background-color: #1e293b !important;
      color: #f1f5f9 !important;
    }
    
    html.dark .admin-area select option:hover {
      background-color: #334155 !important;
      color: #ffffff !important;
    }
    
    html.dark .admin-area select option:checked,
    html.dark .admin-area select option:selected {
      background-color: #3b82f6 !important;
      color: #ffffff !important;
    }
  </style>

  @stack('styles')
</head>
<style>[x-cloak]{display:none!important}</style>
<body class="h-full bg-gradient-to-b from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950 text-slate-800 dark:text-slate-100 @if(request()->is('admin*')) admin-area @endif">

  <!-- Topbar -->
  <header class="sticky top-0 z-30 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-slate-900/60">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-4">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-brand-700 dark:text-brand-100 font-semibold">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9l9-6 9 6-9 6-9-6zm0 6l9 6 9-6"/></svg>
                        <span>Perfume Luxury</span>
      </a>

      @php
        $isTrangChu = request()->routeIs('home', 'trangchu', 'categories.index');
      @endphp

      <nav class="ml-auto flex items-center gap-2" x-data="{ userOpen:false, categoriesOpen: false }" @keydown.escape.window="userOpen=false; categoriesOpen=false">
  {{-- Link trang chủ --}}
  <a href="{{ route('home') }}"
     class="px-3 py-2 rounded-xl hover:bg-slate-200/60 dark:hover:bg-slate-800/60">
    {{ __('app.home') }}
  </a>

  {{-- Categories Dropdown --}}
  <div class="relative" x-data="{ categoriesOpen: false }">
    <button type="button" 
            class="px-3 py-2 rounded-xl hover:bg-slate-200/60 dark:hover:bg-slate-800/60 flex items-center gap-1 transition-colors"
            @click="categoriesOpen = !categoriesOpen">
      <span>{{ __('app.categories') }}</span>
      <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': categoriesOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
      </svg>
    </button>

    <!-- Categories Dropdown Menu -->
    <div x-show="categoriesOpen" 
         @click.away="categoriesOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-3 w-64 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/60 dark:border-slate-700 shadow-xl shadow-slate-900/10 dark:shadow-slate-900/50 overflow-hidden z-50">
      
      <div class="p-4">
        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
          </svg>
          {{ __('app.categories') }}
        </h3>
        <div class="space-y-1">
          @php
            $categories = \App\Models\Category::active()->withCount('products')->orderBy('name')->get();
          @endphp
          @forelse($categories as $category)
            <a href="{{ route('categories.show', $category) }}" 
               class="flex items-center justify-between px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors duration-200">
              <span>{{ $category->display_name }}</span>
              <span class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-full">
                {{ $category->products_count }}
              </span>
            </a>
          @empty
            <div class="px-3 py-2.5 text-sm text-slate-500 dark:text-slate-400">
              {{ __('app.no_categories') }}
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  {{-- Settings Button (Language + Dark Mode) --}}
  <div class="relative" x-data="{ settingsOpen: false }">
    <button type="button" 
            class="p-2 rounded-xl hover:bg-slate-200/70 dark:hover:bg-slate-800/70 transition-colors duration-200"
            @click="settingsOpen = !settingsOpen">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
      </svg>
    </button>

    <!-- Settings Dropdown -->
    <div x-show="settingsOpen" 
         @click.away="settingsOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-3 w-64 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/60 dark:border-slate-700 shadow-xl shadow-slate-900/10 dark:shadow-slate-900/50 overflow-hidden z-50">
      
      <!-- Language Settings -->
      <div class="p-4">
        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
          </svg>
          {{ __('app.language') }}
        </h3>
        <div class="space-y-1">
          <a href="{{ route('language.switch', 'en') }}" 
             class="flex items-center px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors duration-200 {{ app()->getLocale() === 'en' ? 'bg-slate-100 dark:bg-slate-700/50 font-medium' : '' }}">
            <span class="mr-3 text-lg">🇺🇸</span>
            {{ __('app.english') }}
            @if(app()->getLocale() === 'en')
              <svg class="w-4 h-4 ml-auto text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
            @endif
          </a>
          <a href="{{ route('language.switch', 'vi') }}" 
             class="flex items-center px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors duration-200 {{ app()->getLocale() === 'vi' ? 'bg-slate-100 dark:bg-slate-700/50 font-medium' : '' }}">
            <span class="mr-3 text-lg">🇻🇳</span>
            {{ __('app.vietnamese') }}
            @if(app()->getLocale() === 'vi')
              <svg class="w-4 h-4 ml-auto text-brand-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
              </svg>
            @endif
          </a>
        </div>
      </div>

      <div class="border-t border-slate-200 dark:border-slate-600"></div>

      <!-- Dark Mode Toggle -->
      <div class="p-4">
        <button @click="dark = !dark"
                class="flex items-center justify-between w-full px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-colors duration-200">
          <span class="flex items-center">
            <svg x-show="!dark" class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <svg x-show="dark" class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
            <span x-text="dark ? '{{ __('app.light_mode') }}' : '{{ __('app.dark_mode') }}'"></span>
          </span>
          <!-- Toggle Switch -->
          <div class="relative">
            <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 rounded-full transition-colors duration-200" :class="{ 'bg-brand-600': dark }"></div>
            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition-transform duration-200 shadow-sm" :class="{ 'translate-x-5': dark }"></div>
          </div>
        </button>
      </div>
    </div>
  </div>

  @auth
    @php
      $u = auth()->user();
      $displayName = trim(($u->first_name ?? '').' '.($u->last_name ?? '')) ?: ($u->name ?? $u->username ?? 'User');
      $parts = preg_split('/\s+/', trim($displayName));
      $initials = mb_strtoupper(mb_substr($parts[0] ?? 'U',0,1) . mb_substr($parts[count($parts)-1] ?? '',0,1));
    @endphp
   
    {{-- Notification Dropdown --}}
    @include('components.notification-dropdown')

    {{-- Cart Icon --}}
    <a href="{{ route('cart.index') }}" class="relative group p-2 rounded-xl hover:bg-slate-200/60 dark:hover:bg-slate-800/60 transition-all duration-200">
      <div class="relative">
        <!-- Cart Icon -->
        <svg class="w-6 h-6 text-slate-700 dark:text-slate-300 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 8H6L5 9z"></path>
        </svg>
        
        <!-- Badge -->
        @if($u->cart_items_count > 0)
          <div class="absolute -top-2 -right-2 min-w-[20px] h-5 bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs rounded-full flex items-center justify-center font-bold shadow-lg shadow-rose-500/30 ring-2 ring-white dark:ring-slate-800 transform scale-100 group-hover:scale-110 transition-transform duration-200">
            <span class="px-1">{{ $u->cart_items_count > 99 ? '99+' : $u->cart_items_count }}</span>
          </div>
        @endif
      </div>
    </a>
   
  @auth
   
  @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-xl hover:bg-slate-200/60 dark:hover:bg-slate-800/60">
      {{ __('app.admin') }}
    </a>
  @endif
@endauth

    {{-- Avatar + dropdown --}}
    <div class="relative" x-data="{ userOpen: false }" x-cloak>
      <button type="button"
              class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:ring-2 hover:ring-brand-500/30 transition-all duration-200 hover:scale-105 overflow-hidden"
              @click="userOpen = !userOpen" :aria-expanded="userOpen">
        <span class="sr-only">{{ __('app.open_account_menu') }}</span>
        @if($u->avatar)
          <img src="{{ $u->avatar_url }}" alt="{{ $displayName }}" class="w-full h-full object-cover rounded-full">
        @else
          <div class="w-full h-full bg-brand-600/10 hover:bg-brand-600/20 ring-1 ring-brand-600/30 text-brand-700 dark:text-brand-100 rounded-full flex items-center justify-center">
            <span class="font-semibold text-sm">{{ $initials }}</span>
          </div>
        @endif
      </button>

      <div x-show="userOpen" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-95"
           @click.outside="userOpen = false"
           class="absolute right-0 mt-3 w-64 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/60 dark:border-slate-700 shadow-xl shadow-slate-900/10 dark:shadow-slate-900/50 overflow-hidden z-50">
        
        <!-- User Info Header -->
        <div class="px-6 py-4 bg-slate-100 dark:bg-slate-700 border-b border-slate-200/60 dark:border-slate-600">
          <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full ring-2 ring-brand-600/20 overflow-hidden flex-shrink-0">
              @if($u->avatar)
                <img src="{{ $u->avatar_url }}" alt="{{ $displayName }}" class="w-full h-full object-cover">
              @else
                <div class="w-full h-full bg-brand-600/10 flex items-center justify-center">
                  <span class="text-lg font-bold text-brand-700 dark:text-brand-300">{{ $initials }}</span>
                </div>
              @endif
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $displayName }}</p>
              <p class="text-xs text-slate-600 dark:text-slate-400 truncate">{{ $u->email }}</p>
            </div>
          </div>
        </div>

        <!-- Menu Items -->
        <div class="py-2">
          <a href="{{ route('profile.edit') }}"
             class="flex items-center px-6 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200 group">
            <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-brand-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="font-medium">{{ __('app.my_account') }}</span>
            <svg class="w-4 h-4 ml-auto text-slate-300 group-hover:text-brand-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>

          <a href="{{ route('orders.index') }}"
             class="flex items-center px-6 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200 group">
            <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-emerald-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="font-medium">{{ __('app.my_orders') }}</span>
            <svg class="w-4 h-4 ml-auto text-slate-300 group-hover:text-emerald-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>

          <a href="{{ route('notifications.index') }}"
             class="flex items-center px-6 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200 group">
            <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <span class="font-medium">Thông báo</span>
            @if(auth()->user()->unread_notifications_count > 0)
              <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 font-medium">
                {{ auth()->user()->unread_notifications_count > 99 ? '99+' : auth()->user()->unread_notifications_count }}
              </span>
            @endif
            <svg class="w-4 h-4 ml-auto text-slate-300 group-hover:text-blue-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>

          <a href="{{ route('reviews.index') }}"
             class="flex items-center px-6 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200 group">
            <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
            <span class="font-medium">Đánh giá của tôi</span>
            <svg class="w-4 h-4 ml-auto text-slate-300 group-hover:text-yellow-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </a>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center px-6 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200 group">
              <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-rose-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              <span class="font-medium">{{ __('app.logout') }}</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  @else
    <a class="px-3 py-2 rounded-xl hover:bg-slate-200/60 dark:hover:bg-slate-800/60" href="{{ route('login') }}">{{ __('app.login') }}</a>
    <a class="px-3 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white" href="{{ route('register') }}">{{ __('app.register') }}</a>
  @endauth
</nav>

    </div>
  </header>

  <!-- Page -->
  <main class="max-w-6xl mx-auto px-4 py-6">
    {{-- Flash messages (an toàn nếu file không tồn tại) --}}
    @includeIf('partials.flash')

    {{-- Nội dung trang con --}}
    @yield('content')
  </main>

  <footer class="py-8 text-center text-sm text-slate-500 dark:text-slate-400">
            © {{ date('Y') }} Perfume Luxury — Made with Laravel
  </footer>

  @stack('scripts')
</body>
</html>
