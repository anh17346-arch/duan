@extends('layouts.app')

@section('title', 'Chi tiết đánh giá')

@section('content')
<!-- Modern Unified Background -->
<div class="min-h-screen relative overflow-hidden">
  <!-- Animated Background -->
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

  <div class="relative container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
      <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.reviews.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Quay lại danh sách
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Chi tiết đánh giá</h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-1">Quản lý và xem chi tiết đánh giá từ khách hàng</p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
                @if($review->is_approved !== true)
                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors duration-200"
                            onclick="return confirm('Bạn có chắc muốn duyệt đánh giá này?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Duyệt đánh giá
                    </button>
                </form>
                @endif
                
                @if($review->is_approved !== false)
                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors duration-200"
                            onclick="return confirm('Bạn có chắc muốn từ chối đánh giá này?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Từ chối đánh giá
                    </button>
                </form>
                @endif
                
                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-xl transition-colors duration-200"
                            onclick="return confirm('Bạn có chắc muốn xóa đánh giá này? Hành động này không thể hoàn tác.')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa đánh giá
                    </button>
                </form>
            </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Review Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Review Status Card -->
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Trạng thái đánh giá</h2>
                    <div>
                        @if($review->is_approved)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300 border border-green-200 dark:border-green-800/50">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Đã duyệt
                            </span>
                        @elseif($review->is_approved === false)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 border border-red-200 dark:border-red-800/50">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Đã từ chối
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800/50">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Chờ duyệt
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 block mb-1">Ngày tạo:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($review->is_edited)
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 block mb-1">Đã chỉnh sửa:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">{{ $review->edited_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 block mb-1">Mua hàng xác thực:</span>
                        @if($review->is_verified)
                            <span class="text-green-600 dark:text-green-400 font-medium">✓ Có</span>
                        @else
                            <span class="text-red-600 dark:text-red-400 font-medium">✗ Không</span>
                        @endif
                    </div>
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 block mb-1">ID đánh giá:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">#{{ $review->id }}</span>
                    </div>
                </div>
            </div>

            <!-- Rating and Comment Card -->
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4">Đánh giá và bình luận</h2>
                
                <!-- Rating -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-3">Đánh giá sao</h3>
                    <div class="flex items-center bg-white/40 dark:bg-slate-700/50 rounded-xl p-4 border border-white/30 dark:border-slate-600/50">
                        <div class="flex text-yellow-400 space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 fill-current text-slate-300" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-4 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $review->rating }}/5</span>
                    </div>
                </div>

                <!-- Comment -->
                <div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-3">Bình luận</h3>
                    @if($review->comment)
                        <div class="bg-blue-50/80 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200/50 dark:border-blue-800/50">
                            <p class="text-slate-800 dark:text-slate-200 leading-relaxed">{{ $review->comment }}</p>
                        </div>
                    @else
                        <div class="bg-slate-50/80 dark:bg-slate-700/50 rounded-xl p-4 border border-slate-200/50 dark:border-slate-600/50">
                            <p class="text-slate-500 dark:text-slate-400 italic">Khách hàng không để lại bình luận</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Media Attachments Card -->
            @if($review->images->count() > 0)
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4">Hình ảnh và video</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($review->images as $image)
                    <div class="relative group">
                        @if($image->isVideo())
                            <video class="w-full h-32 object-cover rounded-xl cursor-pointer shadow-sm hover:shadow-lg transition-shadow duration-200" 
                                   onclick="openMediaModal('{{ $image->url }}', 'video')">
                                <source src="{{ $image->url }}" type="{{ $image->mime_type }}">
                                Your browser does not support the video tag.
                            </video>
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @else
                            <img src="{{ $image->url }}" alt="Review image" 
                                 class="w-full h-32 object-cover rounded-xl cursor-pointer shadow-sm hover:shadow-lg transition-shadow duration-200"
                                 onclick="openMediaModal('{{ $image->url }}', 'image')">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-lg border border-white/20">
                            {{ $image->getFormattedFileSizeAttribute() }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information Card -->
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4">Thông tin khách hàng</h2>
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-16 w-16">
                        @if($review->user->avatar)
                            <img class="h-16 w-16 rounded-full object-cover border-2 border-white/50 dark:border-slate-600/50" src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}">
                        @else
                            <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl border-2 border-white/50 dark:border-slate-600/50">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="text-lg font-medium text-slate-900 dark:text-slate-100">
                            {{ $review->user->name }}
                        </div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $review->user->email }}
                        </div>
                        <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                            Thành viên từ {{ $review->user->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 text-sm block mb-1">Số điện thoại:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">{{ $review->user->phone ?: 'Chưa cập nhật' }}</span>
                    </div>
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 text-sm block mb-1">Địa chỉ:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">{{ $review->user->address ?: 'Chưa cập nhật' }}</span>
                    </div>
                </div>
            </div>

            <!-- Product Information Card -->
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4">Thông tin sản phẩm</h2>
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-16 w-16">
                        @if($review->product->images->first())
                            <img class="h-16 w-16 rounded-xl object-cover border border-white/50 dark:border-slate-600/50" src="{{ asset('storage/' . $review->product->images->first()->image_path) }}" alt="{{ $review->product->name }}">
                        @else
                            <div class="h-16 w-16 rounded-xl bg-slate-200 dark:bg-slate-600 flex items-center justify-center border border-white/50 dark:border-slate-600/50">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="text-lg font-medium text-slate-900 dark:text-slate-100">
                            {{ $review->product->name }}
                        </div>
                        <div class="text-lg font-semibold text-blue-600 dark:text-blue-400">
                            {{ number_format($review->product->price) }} VNĐ
                        </div>
                    </div>
                </div>
                
                <div class="space-y-3 mb-4">
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 text-sm block mb-1">Danh mục:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">
                            {{ $review->product->categories->pluck('name')->implode(', ') }}
                        </span>
                    </div>
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 text-sm block mb-1">Đơn hàng:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">#{{ $review->order->order_number }}</span>
                    </div>
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-500 dark:text-slate-400 text-sm block mb-1">Ngày mua:</span>
                        <span class="text-slate-900 dark:text-slate-100 font-medium">{{ $review->order->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                
                <a href="{{ route('products.show', $review->product) }}" 
                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition-colors duration-200">
                    <span class="font-medium">Xem chi tiết sản phẩm</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            <!-- Review Statistics Card -->
            <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10 p-6">
                <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-4">Thống kê sản phẩm</h2>
                <div class="space-y-4">
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-600 dark:text-slate-400 text-sm block mb-2">Đánh giá trung bình:</span>
                        <div class="flex items-center justify-between">
                            <div class="flex text-yellow-400 space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->product->average_rating)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ number_format($review->product->average_rating, 1) }}/5</span>
                        </div>
                    </div>
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-600 dark:text-slate-400 text-sm block mb-1">Tổng số đánh giá:</span>
                        <span class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $review->product->reviews_count }}</span>
                    </div>
                    <div class="bg-white/40 dark:bg-slate-700/50 rounded-xl p-3 border border-white/30 dark:border-slate-600/50">
                        <span class="text-slate-600 dark:text-slate-400 text-sm block mb-1">Đánh giá đã duyệt:</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $review->product->approvedReviews()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Media Modal -->
<div id="mediaModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeMediaModal()" class="absolute top-4 right-4 text-white hover:text-slate-300 z-10 bg-black bg-opacity-50 hover:bg-black bg-opacity-70 rounded-full p-2 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div id="mediaContent" class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-xl">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<script>
function openMediaModal(url, type) {
    const modal = document.getElementById('mediaModal');
    const content = document.getElementById('mediaContent');
    
    if (type === 'video') {
        content.innerHTML = `
            <video class="max-w-full max-h-full" controls>
                <source src="${url}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
    } else {
        content.innerHTML = `<img src="${url}" alt="Review media" class="max-w-full max-h-full object-contain">`;
    }
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMediaModal() {
    const modal = document.getElementById('mediaModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('mediaModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMediaModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMediaModal();
    }
});
</script>
@endsection
