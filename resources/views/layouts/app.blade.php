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

  <!-- Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN + Alpine -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: { sans: ['Inter','ui-sans-serif','system-ui'] },
          colors: { brand: { DEFAULT:'#6366F1',50:'#eef2ff',100:'#e0e7ff',600:'#4f46e5',700:'#4338ca' } },
          boxShadow: { soft:'0 10px 30px rgba(0,0,0,.07)' }
        }
      }
    }
  </script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
    .glass { backdrop-filter: blur(8px); background: linear-gradient(180deg, rgba(255,255,255,.7), rgba(255,255,255,.5)); }
    .dark .glass { background: linear-gradient(180deg, rgba(30,41,59,.7), rgba(30,41,59,.5)); }
  </style>

  @stack('styles')
</head>
<style>[x-cloak]{display:none!important}</style>
<body class="h-full bg-gradient-to-b from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950 text-slate-800 dark:text-slate-100">

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

      <nav class="ml-auto flex items-center gap-2" x-data="{ userOpen:false }" @keydown.escape.window="userOpen=false">
  {{-- Link trang chủ --}}
  <a href="{{ route('home') }}"
     class="px-3 py-2 rounded-xl hover:bg-slate-200/60 dark:hover:bg-slate-800/60">
    {{ __('app.home') }}
  </a>

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
        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
          </svg>
          {{ __('app.dark_mode') }}
        </h3>
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
