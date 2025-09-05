<div class="relative" x-data="{ open: false }">
    <!-- Notification Bell -->
    <button @click="open = !open" 
            class="relative p-2 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors">
            <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 
                    0118 14.158V11a6.002 6.002 0 
                    00-4-5.659V5a2 2 0 
                    10-4 0v.341C7.67 6.165 6 8.388 
                    6 11v3.159c0 .538-.214 
                    1.055-.595 1.436L4 17h5m6 0v1a3 
                    3 0 11-6 0v-1m6 0H9" />
            </svg>
        
        <!-- Badge -->
        @if(auth()->check() && auth()->user()->unread_notifications_count > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium shadow-lg">
                {{ auth()->user()->unread_notifications_count > 99 ? '99+' : auth()->user()->unread_notifications_count }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="open = false"
         class="absolute right-0 mt-2 w-80 bg-white/95 dark:bg-slate-800/95 rounded-2xl shadow-2xl border border-slate-200/60 dark:border-slate-700/60 backdrop-blur-xl z-50">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-slate-200/60 dark:border-slate-700/60">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                    Thông báo
                </h3>
                @if(auth()->check() && auth()->user()->unread_notifications_count > 0)
                    <button id="mark-all-read-dropdown" 
                            class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                        Đánh dấu tất cả đã đọc
                    </button>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto" id="notifications-dropdown-list">
            @if(auth()->check())
                @php
                    $recentNotifications = auth()->user()->roleNotifications()->limit(5)->get();
                @endphp
                
                @if($recentNotifications->count() > 0)
                    <div class="divide-y divide-slate-200/60 dark:divide-slate-700/60">
                        @foreach($recentNotifications as $notification)
                            <div class="notification-dropdown-item p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors cursor-pointer {{ !$notification->pivot->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}"
                                 data-notification-id="{{ $notification->id }}">
                                <div class="flex items-start space-x-3">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $notification->color_classes }} dark:bg-opacity-20">
                                            <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($notification->icon === 'bell')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                                @elseif($notification->icon === 'shopping-cart')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                                @elseif($notification->icon === 'credit-card')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                @elseif($notification->icon === 'gift')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                                @elseif($notification->icon === 'alert')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                @elseif($notification->icon === 'check')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                @elseif($notification->icon === 'x')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                @elseif($notification->icon === 'truck')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                @elseif($notification->icon === 'star')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                @elseif($notification->icon === 'heart')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                @elseif($notification->icon === 'user')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                @elseif($notification->icon === 'shield')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                @elseif($notification->icon === 'clock')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                @elseif($notification->icon === 'chart')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                                @endif
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">
                                                {{ $notification->title }}
                                            </h4>
                                            @if(!$notification->pivot->is_read)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                                    Mới
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300 line-clamp-2">
                                            {{ $notification->message }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            {{ $notification->time_ago }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center">
                        <svg class="mx-auto w-12 h-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                            Không có thông báo mới
                        </p>
                    </div>
                @endif
            @else
                <div class="p-6 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Vui lòng đăng nhập để xem thông báo
                    </p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if(auth()->check())
            <div class="px-4 py-3 border-t border-slate-200/60 dark:border-slate-700/60">
                <a href="{{ route('notifications.index') }}" 
                   class="block text-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    Xem tất cả thông báo
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark all as read from dropdown
    const markAllReadButton = document.getElementById('mark-all-read-dropdown');
    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            fetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update dropdown items
                    document.querySelectorAll('.notification-dropdown-item').forEach(item => {
                        item.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                    });
                    document.querySelectorAll('.notification-dropdown-item .bg-blue-100').forEach(badge => {
                        badge.remove();
                    });
                    
                    // Update badge
                    const badge = document.querySelector('.bg-red-500');
                    if (badge) {
                        badge.remove();
                    }
                    
                    // Update button text
                    markAllReadButton.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Mark individual notification as read from dropdown
    document.querySelectorAll('.notification-dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const notificationId = this.dataset.notificationId;
            const isUnread = this.classList.contains('bg-blue-50');
            
            if (isUnread) {
                fetch('{{ route("notifications.mark-read") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        notification_id: notificationId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
                        const badge = this.querySelector('.bg-blue-100');
                        if (badge) badge.remove();
                        
                        // Update badge count
                        const badgeElement = document.querySelector('.bg-red-500');
                        if (badgeElement) {
                            const currentCount = parseInt(badgeElement.textContent);
                            if (currentCount > 1) {
                                badgeElement.textContent = currentCount - 1;
                            } else {
                                badgeElement.remove();
                            }
                        }
                        
                        // Hide mark all read button if no unread notifications
                        const unreadItems = document.querySelectorAll('.notification-dropdown-item.bg-blue-50');
                        if (unreadItems.length === 0) {
                            const markAllReadBtn = document.getElementById('mark-all-read-dropdown');
                            if (markAllReadBtn) {
                                markAllReadBtn.style.display = 'none';
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            
            // Navigate to action URL if exists
            const actionUrl = this.querySelector('a')?.href;
            if (actionUrl) {
                window.location.href = actionUrl;
            }
        });
    });

    // Auto-refresh notifications every 30 seconds
    setInterval(function() {
        if (document.querySelector('[x-data*="open"]')) {
            fetch('{{ route("notifications.recent") }}')
            .then(response => response.json())
            .then(data => {
                // Update badge count
                const badgeElement = document.querySelector('.bg-red-500');
                if (data.unreadCount > 0) {
                    if (badgeElement) {
                        badgeElement.textContent = data.unreadCount > 99 ? '99+' : data.unreadCount;
                    } else {
                        // Create new badge
                        const button = document.querySelector('[x-data*="open"] button');
                        if (button) {
                            const badge = document.createElement('span');
                            badge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium';
                            badge.textContent = data.unreadCount > 99 ? '99+' : data.unreadCount;
                            button.appendChild(badge);
                        }
                    }
                } else {
                    if (badgeElement) {
                        badgeElement.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Error refreshing notifications:', error);
            });
        }
    }, 30000);
});
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Enhanced dark mode styling for notification dropdown */
.dark .notification-dropdown-item {
    border-color: rgba(148, 163, 184, 0.1);
}

.dark .notification-dropdown-item:hover {
    background-color: rgba(148, 163, 184, 0.1);
}

.dark .notification-dropdown-item.bg-blue-50 {
    background-color: rgba(59, 130, 246, 0.15);
}

/* Ensure proper contrast for notification content */
.dark .notification-dropdown-item h4 {
    color: #f1f5f9;
}

.dark .notification-dropdown-item p {
    color: #cbd5e1;
}

.dark .notification-dropdown-item .text-slate-500 {
    color: #94a3b8;
}
</style>
@endpush
