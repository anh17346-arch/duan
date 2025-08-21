@if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-y-[-100%] opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-[-100%] opacity-0"
         x-init="setTimeout(() => show = false, 4000)"
         class="mb-6 rounded-2xl bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 text-emerald-800 px-6 py-4 shadow-lg dark:from-emerald-900/20 dark:to-green-900/20 dark:border-emerald-700 dark:text-emerald-200">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="flex-shrink-0 ml-2 text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-y-[-100%] opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-[-100%] opacity-0"
         x-init="setTimeout(() => show = false, 5000)"
         class="mb-6 rounded-2xl bg-gradient-to-r from-rose-50 to-red-50 border border-rose-200 text-rose-800 px-6 py-4 shadow-lg dark:from-rose-900/20 dark:to-red-900/20 dark:border-rose-700 dark:text-rose-200">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="flex-shrink-0 ml-2 text-rose-600 hover:text-rose-800 dark:text-rose-400 dark:hover:text-rose-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if(session('warning'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-y-[-100%] opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-[-100%] opacity-0"
         x-init="setTimeout(() => show = false, 4500)"
         class="mb-6 rounded-2xl bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 text-amber-800 px-6 py-4 shadow-lg dark:from-amber-900/20 dark:to-yellow-900/20 dark:border-amber-700 dark:text-amber-200">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <span class="font-semibold">{{ session('warning') }}</span>
            </div>
            <button @click="show = false" class="flex-shrink-0 ml-2 text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if(session('info'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="translate-y-[-100%] opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-[-100%] opacity-0"
         x-init="setTimeout(() => show = false, 4000)"
         class="mb-6 rounded-2xl bg-gradient-to-r from-blue-50 to-sky-50 border border-blue-200 text-blue-800 px-6 py-4 shadow-lg dark:from-blue-900/20 dark:to-sky-900/20 dark:border-blue-700 dark:text-blue-200">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <span class="font-semibold">{{ session('info') }}</span>
            </div>
            <button @click="show = false" class="flex-shrink-0 ml-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif
