{{-- Modern Toast Notifications --}}
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2" style="z-index: 9999;">
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transform transition-all duration-500 ease-out"
             x-transition:enter-start="translate-x-full opacity-0 scale-95"
             x-transition:enter-end="translate-x-0 opacity-100 scale-100"
             x-transition:leave="transform transition-all duration-300 ease-in"
             x-transition:leave-start="translate-x-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-95"
             x-init="setTimeout(() => show = false, 3500)"
             class="max-w-sm bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-emerald-200 dark:border-emerald-700 overflow-hidden backdrop-blur-sm">
            
            <!-- Progress Bar -->
            <div class="h-1 bg-emerald-500 transform origin-left animate-progress" style="animation-duration: 3.5s;"></div>
            
            <div class="p-4">
                <div class="flex items-start gap-3">
                    <!-- Icon -->
                    <div class="flex-shrink-0 p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-full">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-1">
                            {{ __('app.success') }}
                        </p>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ session('success') }}
                        </p>
                    </div>
                    
                    <!-- Close Button -->
                    <button @click="show = false" 
                            class="flex-shrink-0 p-1 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transform transition-all duration-500 ease-out"
             x-transition:enter-start="translate-x-full opacity-0 scale-95"
             x-transition:enter-end="translate-x-0 opacity-100 scale-100"
             x-transition:leave="transform transition-all duration-300 ease-in"
             x-transition:leave-start="translate-x-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-95"
             x-init="setTimeout(() => show = false, 4000)"
             class="max-w-sm bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-rose-200 dark:border-rose-700 overflow-hidden backdrop-blur-sm">
            
            <!-- Progress Bar -->
            <div class="h-1 bg-rose-500 transform origin-left animate-progress" style="animation-duration: 4s;"></div>
            
            <div class="p-4">
                <div class="flex items-start gap-3">
                    <!-- Icon -->
                    <div class="flex-shrink-0 p-2 bg-rose-100 dark:bg-rose-900/30 rounded-full">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-1">
                            {{ __('app.error') }}
                        </p>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ session('error') }}
                        </p>
                    </div>
                    
                    <!-- Close Button -->
                    <button @click="show = false" 
                            class="flex-shrink-0 p-1 text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    @keyframes progress {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }
    .animate-progress {
        animation: progress linear forwards;
    }
</style>
