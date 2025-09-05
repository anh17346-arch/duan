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
  <title>@yield('title','Quản trị hệ thống - Perfume Luxury')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Local CSS and JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Modern Admin Unified Styles */
    .admin-glass { 
      backdrop-filter: blur(20px); 
      background: linear-gradient(135deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.1) 100%);
      border: 1px solid rgba(255,255,255,0.3);
    }
    
    .dark .admin-glass { 
      background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
      border: 1px solid rgba(255,255,255,0.15);
    }
    
    /* Unified Card Styles */
    .admin-card {
      @apply bg-white/80 dark:bg-white/5 rounded-2xl shadow-lg border border-white/40 dark:border-white/10 backdrop-blur-xl transition-all duration-300;
    }
    
    .admin-card:hover {
      @apply transform -translate-y-1 shadow-xl;
    }
    
    /* Unified Button Styles */
    .admin-btn-primary {
      @apply inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5;
    }
    
    .admin-btn-secondary {
      @apply inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all duration-300 font-medium;
    }
    
    .admin-btn-success {
      @apply inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-xl hover:from-emerald-600 hover:to-green-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5;
    }
    
    .admin-btn-danger {
      @apply inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-xl hover:from-red-600 hover:to-rose-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5;
    }
    
    /* Unified Input Styles */
    .admin-input {
      @apply w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-white/30 dark:border-white/20 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-300;
    }
    
    .admin-select {
      @apply w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-white/30 dark:border-white/20 rounded-xl text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm transition-all duration-300;
    }
    
    /* Dark mode select fixes */
    html.dark select,
    html.dark select option {
      background-color: #1e293b !important;
      color: #f1f5f9 !important;
    }
    
    /* Animation Classes */
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
    
    /* Table Styles */
    .admin-table {
      @apply w-full bg-white/80 dark:bg-white/5 rounded-2xl overflow-hidden shadow-lg border border-white/40 dark:border-white/10 backdrop-blur-xl;
    }
    
    .admin-table th {
      @apply px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider border-b border-slate-200 dark:border-slate-600;
    }
    
    .admin-table td {
      @apply px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100 border-b border-slate-100 dark:border-slate-700;
    }
    
    .admin-table tbody tr:hover {
      @apply bg-slate-50/50 dark:bg-slate-700/20;
    }
    
    /* Status Badge Styles */
    .status-badge {
      @apply px-3 py-1 rounded-full text-xs font-semibold;
    }
    
    .status-success {
      @apply bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300;
    }
    
    .status-warning {
      @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300;
    }
    
    .status-danger {
      @apply bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300;
    }
    
    .status-info {
      @apply bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300;
    }
    
    /* Header Styles */
    .admin-header {
      @apply mb-8;
    }
    
    .admin-title {
      @apply text-4xl lg:text-5xl font-bold bg-gradient-to-r from-slate-800 via-slate-700 to-slate-600 dark:from-slate-100 dark:via-slate-200 dark:to-slate-300 bg-clip-text text-transparent;
    }
    
    .admin-subtitle {
      @apply text-lg text-slate-600 dark:text-slate-400 mt-2;
    }
    
    /* Stats Card Styles */
    .stats-card {
      @apply bg-white/80 dark:bg-white/5 rounded-2xl shadow-lg border border-white/40 dark:border-white/10 backdrop-blur-xl p-6 transition-all duration-300;
    }
    
    .stats-card:hover {
      @apply transform -translate-y-1 shadow-xl;
    }
    
    .stats-icon {
      @apply w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg mb-4;
    }
    
    /* Loading Animation */
    .loading-spinner {
      @apply animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600;
    }
  </style>
  
  @stack('styles')
</head>

<body class="h-full bg-slate-50 dark:bg-slate-900 font-sans antialiased">
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

  <!-- Navigation -->
  <nav class="admin-glass fixed top-0 left-0 right-0 z-50 px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <span class="text-xl font-bold text-slate-900 dark:text-slate-100">Admin Panel</span>
        </a>
      </div>
      
      <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggle -->
        <button @click="dark = !dark" class="admin-btn-secondary">
          <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
          </svg>
          <svg x-show="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
        </button>
        
        <!-- Back to Site -->
        <a href="{{ route('dashboard') }}" class="admin-btn-secondary">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          Về trang chính
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="pt-20">
    @yield('content')
  </main>

  <!-- Loading Overlay -->
  <div id="loading-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center h-full">
      <div class="admin-card p-8 text-center">
        <div class="loading-spinner mx-auto mb-4"></div>
        <p class="text-slate-600 dark:text-slate-400">Đang xử lý...</p>
      </div>
    </div>
  </div>

  @stack('scripts')
  
  <!-- Common Admin Scripts -->
  <script>
    // Show loading overlay
    function showLoading() {
      document.getElementById('loading-overlay').classList.remove('hidden');
    }
    
    // Hide loading overlay
    function hideLoading() {
      document.getElementById('loading-overlay').classList.add('hidden');
    }
    
    // Auto-hide alerts
    setTimeout(() => {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.3s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
      });
    }, 5000);
  </script>
</body>
</html>