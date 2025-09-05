@extends('layouts.app')

@section('title', 'Quản lý đánh giá')

@push('styles')
<style>
    .review-card {
        position: relative;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        border-radius: 20px;
    }
    
    .review-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .review-card:hover::before {
        opacity: 1;
    }
    
    .dark .review-card {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.6) 100%);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .review-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15), 0 0 0 1px rgba(99, 102, 241, 0.2) inset;
    }
    
    .dark .review-card:hover {
        box-shadow: 0 25px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(99, 102, 241, 0.3) inset;
    }
    
    .filter-section {
        background: rgba(255,255,255,0.3);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 20px;
    }
    
    .dark .filter-section {
        background: rgba(30, 41, 59, 0.3);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .status-badge {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        font-weight: 600;
    }
    
    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s ease;
    }
    
    .status-badge:hover::before {
        left: 100%;
    }
    
    .star-rating {
        transition: all 0.3s ease;
    }
    
    .star-rating:hover {
        transform: scale(1.15);
        filter: drop-shadow(0 0 12px rgba(251, 191, 36, 0.6));
    }
    
    .action-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    
    .action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.3s ease, height 0.3s ease;
    }
    
    .action-btn:hover::before {
        width: 100%;
        height: 100%;
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
    
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    .animation-delay-6000 { animation-delay: 6s; }
    
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .modern-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }
    
    .modern-btn:hover::before {
        left: 100%;
    }
    
    .modern-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
    }
    
    .modern-avatar {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    
    .modern-avatar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    
    .modern-avatar:hover::after {
        transform: translateX(100%);
    }
    
    .modern-header {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    }
    
    .dark .modern-header {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.7) 100%);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 24px;
    }
    
    @media (max-width: 768px) {
        .reviews-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen relative overflow-hidden">
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 via-purple-50/60 to-pink-50/60 dark:from-slate-900 dark:via-blue-900/30 dark:via-purple-900/30 dark:to-pink-900/30"></div>
        <div class="absolute top-20 left-10 w-64 h-64 bg-gradient-to-r from-blue-400/10 to-purple-400/10 dark:from-blue-400/5 dark:to-purple-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-pink-400/10 to-rose-400/10 dark:from-pink-400/5 dark:to-rose-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-32 left-1/3 w-80 h-80 bg-gradient-to-r from-cyan-400/10 to-teal-400/10 dark:from-cyan-400/5 dark:to-teal-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-4000"></div>
        <div class="absolute bottom-20 right-1/4 w-56 h-56 bg-gradient-to-r from-emerald-400/10 to-green-400/10 dark:from-emerald-400/5 dark:to-green-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-6000"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.05),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(100,116,139,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(100,116,139,0.03)_1px,transparent_1px)] bg-[size:64px_64px] dark:bg-[linear-gradient(rgba(148,163,184,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.02)_1px,transparent_1px)]"></div>
    </div>

    <div class="relative">
        <!-- Back to Management Button -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <a href="{{ route('admin.dashboard') }}" class="modern-btn flex items-center inline-flex">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Quay lại quản lý
            </a>
        </div>

        <!-- Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="modern-header p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">Quản lý đánh giá</h1>
                        <p class="text-slate-600 dark:text-slate-300 text-lg">Quản lý và duyệt đánh giá từ khách hàng</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.reviews.statistics') }}" class="modern-btn flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Thống kê
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="filter-section p-8 mb-8">
                <form method="GET" action="{{ route('admin.reviews.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label for="product" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Sản phẩm</label>
                        <select name="product" id="product" class="w-full border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">Tất cả sản phẩm</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Trạng thái</label>
                        <select name="status" id="status" class="w-full border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                        </select>
                    </div>

                    <div>
                        <label for="rating" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Đánh giá</label>
                        <select name="rating" id="rating" class="w-full border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">Tất cả đánh giá</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 sao</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 sao</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 sao</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 sao</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 sao</option>
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Thời gian</label>
                        <select name="date" id="date" class="w-full border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">Tất cả thời gian</option>
                            <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Hôm nay</option>
                            <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Tuần này</option>
                            <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Tháng này</option>
                            <option value="quarter" {{ request('date') == 'quarter' ? 'selected' : '' }}>3 tháng gần đây</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 font-medium text-sm">
                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                            </svg>
                            Lọc
                        </button>
                        <a href="{{ route('admin.reviews.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 font-medium text-sm">
                            Xóa bộ lọc
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="filter-section p-6 mb-8">
                <form method="POST" action="{{ route('admin.reviews.bulk-action') }}" id="bulk-action-form">
                    @csrf
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <select name="action" id="bulk-action" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Chọn hành động</option>
                                <option value="approve">Duyệt tất cả</option>
                                <option value="reject">Từ chối tất cả</option>
                                <option value="delete">Xóa tất cả</option>
                            </select>
                            <button type="submit" id="bulk-action-btn" disabled class="bg-red-600 hover:bg-red-700 disabled:bg-slate-400 disabled:cursor-not-allowed text-white px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 font-semibold">
                                Áp dụng
                            </button>
                        </div>
                        <div class="text-sm text-slate-600 dark:text-slate-400 font-medium">
                            <span id="selected-count">0</span> đánh giá được chọn
                        </div>
                    </div>
                </form>
            </div>

            <!-- Reviews Grid -->
            <div class="reviews-grid">
                @forelse($reviews as $review)
                <div class="review-card p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="modern-avatar">
                                @if($review->user->avatar)
                                    <img class="h-12 w-12 rounded-full" src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="font-semibold text-slate-900 dark:text-white text-lg">
                                    {{ $review->user->name }}
                                </div>
                                <div class="text-slate-500 dark:text-slate-400 text-sm">
                                    {{ $review->user->email }}
                                </div>
                            </div>
                        </div>
                        <input type="checkbox" name="selected_reviews[]" value="{{ $review->id }}" class="review-checkbox w-5 h-5 rounded border-2 border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center space-x-3 mb-4">
                        <div class="modern-avatar">
                            @if($review->product->images->first())
                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $review->product->images->first()->image_path) }}" alt="{{ $review->product->name }}">
                            @else
                                <div class="h-10 w-10 rounded-lg bg-slate-200 dark:bg-slate-600 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-slate-900 dark:text-white">
                                {{ $review->product->name }}
                            </div>
                            <div class="text-slate-500 dark:text-slate-400 text-sm">
                                Đơn hàng #{{ $review->order->order_number }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 mb-4">
                        <div class="flex text-yellow-400 star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 fill-current text-slate-300" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-lg font-semibold text-slate-900 dark:text-white">{{ $review->rating }}/5</span>
                    </div>

                    <div class="mb-4">
                        <div class="text-slate-900 dark:text-white mb-2">
                            {{ $review->comment ?: 'Không có bình luận' }}
                        </div>
                        @if($review->images->count() > 0)
                            <div class="text-blue-600 dark:text-blue-400 text-sm font-medium">
                                {{ $review->images->count() }} ảnh/video
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            @if($review->is_approved)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 status-badge">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Đã duyệt
                                </span>
                            @elseif($review->is_approved === false)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 status-badge">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Đã từ chối
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 status-badge">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Chờ duyệt
                                </span>
                            @endif
                        </div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $review->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('admin.reviews.show', $review) }}" class="action-btn text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 p-3 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        
                        @if($review->is_approved !== true)
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 p-3 rounded-xl" onclick="return confirm('Bạn có chắc muốn duyệt đánh giá này?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        </form>
                        @endif
                        
                        @if($review->is_approved !== false)
                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-3 rounded-xl" onclick="return confirm('Bạn có chắc muốn từ chối đánh giá này?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-3 rounded-xl" onclick="return confirm('Bạn có chắc muốn xóa đánh giá này? Hành động này không thể hoàn tác.')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Không có đánh giá nào</h3>
                    <p class="text-slate-500 dark:text-slate-400">
                        Chưa có đánh giá nào được tạo hoặc không tìm thấy đánh giá phù hợp với bộ lọc.
                    </p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($reviews->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white dark:bg-slate-800 px-6 py-4 rounded-2xl shadow-lg">
                    {{ $reviews->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewCheckboxes = document.querySelectorAll('.review-checkbox');
    const bulkActionBtn = document.getElementById('bulk-action-btn');
    const selectedCount = document.getElementById('selected-count');
    const bulkActionForm = document.getElementById('bulk-action-form');

    // Individual checkbox functionality
    reviewCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateBulkActionButton();
        });
    });

    // Bulk action form submission
    bulkActionForm.addEventListener('submit', function(e) {
        const action = document.getElementById('bulk-action').value;
        const selectedReviews = document.querySelectorAll('.review-checkbox:checked');
        
        if (!action) {
            e.preventDefault();
            alert('Vui lòng chọn hành động');
            return;
        }
        
        if (selectedReviews.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một đánh giá');
            return;
        }

        let confirmMessage = '';
        switch(action) {
            case 'approve':
                confirmMessage = `Bạn có chắc muốn duyệt ${selectedReviews.length} đánh giá đã chọn?`;
                break;
            case 'reject':
                confirmMessage = `Bạn có chắc muốn từ chối ${selectedReviews.length} đánh giá đã chọn?`;
                break;
            case 'delete':
                confirmMessage = `Bạn có chắc muốn xóa ${selectedReviews.length} đánh giá đã chọn? Hành động này không thể hoàn tác.`;
                break;
        }

        if (!confirm(confirmMessage)) {
            e.preventDefault();
        }
    });

    function updateSelectedCount() {
        const selected = document.querySelectorAll('.review-checkbox:checked').length;
        selectedCount.textContent = selected;
    }

    function updateBulkActionButton() {
        const selected = document.querySelectorAll('.review-checkbox:checked').length;
        const action = document.getElementById('bulk-action').value;
        bulkActionBtn.disabled = selected === 0 || !action;
    }

    // Update bulk action button when action changes
    document.getElementById('bulk-action').addEventListener('change', updateBulkActionButton);
});
</script>
@endsection
