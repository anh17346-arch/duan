<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full"
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
  <title>{{ config('app.name', 'Perfume Store') }} - Authentication</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

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
    body {
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }
    
    @keyframes blob {
      0% { transform: translate(0px, 0px) scale(1); }
      33% { transform: translate(30px, -50px) scale(1.1); }
      66% { transform: translate(-20px, 20px) scale(0.9); }
      100% { transform: translate(0px, 0px) scale(1); }
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
</head>
<style>[x-cloak]{display:none!important}</style>
<body class="h-full text-slate-800 dark:text-slate-100">
  <!-- Modern Unified Background -->
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

  <!-- Simple Header -->
  <header class="absolute top-0 left-0 right-0 z-50 backdrop-blur supports-[backdrop-filter]:bg-white/5 dark:supports-[backdrop-filter]:bg-slate-900/5">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-white font-semibold text-lg hover:text-slate-200 transition-colors">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 9l9-6 9 6-9 6-9-6zm0 6l9 6 9-6"/>
        </svg>
        <span>Perfume Luxury</span>
      </a>

      <!-- Settings Button (Language + Dark Mode) -->
      <div class="relative" x-data="{ settingsOpen: false }">
        <button type="button" 
                class="p-3 rounded-xl bg-white/10 hover:bg-white/20 dark:bg-slate-800/30 dark:hover:bg-slate-700/40 text-white transition-all duration-300 backdrop-blur-sm border border-white/20"
                @click="settingsOpen = !settingsOpen">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
             class="absolute right-0 mt-3 w-64 rounded-2xl bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-slate-200/60 dark:border-slate-700 shadow-xl shadow-slate-900/10 dark:shadow-slate-900/50 overflow-hidden z-50">
          
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
    </div>
  </header>

  <!-- Page Content -->
  <main class="relative z-10 min-h-screen flex flex-col justify-center items-center py-20 pt-28">
    @yield('content')
  </main>

  <footer class="relative z-10 py-8 text-center text-sm text-slate-300/60">
    © {{ date('Y') }} Perfume Luxury — Authentication
  </footer>

</body>
</html>