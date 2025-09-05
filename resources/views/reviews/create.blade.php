@extends('layouts.app')

@section('title', 'Viết đánh giá - ' . $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                Viết đánh giá
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Chia sẻ trải nghiệm của bạn về sản phẩm này
            </p>
        </div>

        <!-- Product Info -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-8">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-700">
                    @if($product->main_image)
                        <img src="{{ $product->main_image_url }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">
                        {{ $product->name }}
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        Đơn hàng: #{{ $order->order_number }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-500">
                        Ngày mua: {{ $order->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ 
                      submitForm() {
                          const rating = this.$el.querySelector('[name=\"rating\"]').value;
                          if (!rating || rating < 1) {
                              alert('Vui lòng chọn đánh giá sao');
                              return false;
                          }
                          return true;
                      }
                  }"
                  @submit="submitForm()">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        Đánh giá của bạn <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-1" 
                         x-data="{ 
                             rating: 0,
                             hoverRating: 0,
                             setRating(value) {
                                 this.rating = value;
                                 console.log('Rating set to:', value);
                             },
                             setHoverRating(value) {
                                 this.hoverRating = value;
                             },
                             clearHoverRating() {
                                 this.hoverRating = 0;
                             },
                             getDisplayRating() {
                                 return this.hoverRating || this.rating;
                             },
                             isStarFilled(starIndex) {
                                 const displayRating = this.getDisplayRating();
                                 return displayRating >= starIndex;
                             }
                         }"
                         x-init="console.log('Rating component initialized')">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    @click="setRating({{ $i }})"
                                    @mouseenter="setHoverRating({{ $i }})"
                                    @mouseleave="clearHoverRating()"
                                    class="rating-star w-8 h-8 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"
                                    :class="isStarFilled({{ $i }}) ? 'text-yellow-400 drop-shadow-sm' : 'text-slate-300 dark:text-slate-600 hover:text-yellow-300'">
                                ★
                            </button>
                        @endfor
                        <input type="hidden" name="rating" x-model="rating" required min="1" max="5" step="1">
                        <span class="ml-3 text-sm text-slate-600 dark:text-slate-400" 
                              x-text="rating > 0 ? rating + '/5 sao' : 'Chọn số sao'"></span>
                        <div x-show="rating === 0" class="ml-3 text-sm text-red-500">
                            Vui lòng chọn đánh giá
                        </div>
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Nhận xét của bạn
                    </label>
                    <textarea id="comment" 
                              name="comment" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-slate-100"
                              placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này... (tùy chọn)"
                              maxlength="1000">{{ old('comment') }}</textarea>
                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Tối đa 1000 ký tự
                    </div>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Hình ảnh (tùy chọn)
                    </label>
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-6 text-center" 
                         x-data="{ 
                             imageFiles: [],
                             addImages(files) {
                                 for (let i = 0; i < files.length; i++) {
                                     if (files[i].type.startsWith('image/')) {
                                         this.imageFiles.push(files[i]);
                                     }
                                 }
                             },
                             removeImage(index) {
                                 this.imageFiles.splice(index, 1);
                             }
                         }">
                        <div class="space-y-4">
                            <div>
                                <svg class="mx-auto w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                                    Kéo thả hình ảnh vào đây hoặc
                                </p>
                                <label class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Chọn hình ảnh
                                    <input type="file" 
                                           name="images[]" 
                                           multiple 
                                           accept="image/*" 
                                           class="hidden"
                                           @change="addImages($event.target.files)">
                                </label>
                            </div>
                            
                            <!-- Preview Images -->
                            <div x-show="imageFiles.length > 0" class="grid grid-cols-4 gap-2">
                                <template x-for="(file, index) in imageFiles" :key="index">
                                    <div class="relative">
                                        <img :src="URL.createObjectURL(file)" 
                                             class="w-full h-20 object-cover rounded-lg">
                                        <button type="button" 
                                                @click="removeImage(index)"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs">
                                            ×
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        Hỗ trợ: JPG, PNG, GIF. Tối đa 5MB mỗi file.
                    </p>
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Video (tùy chọn)
                    </label>
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-6 text-center" 
                         x-data="{ 
                             videoFiles: [],
                             addVideos(files) {
                                 for (let i = 0; i < files.length; i++) {
                                     if (files[i].type.startsWith('video/')) {
                                         this.videoFiles.push(files[i]);
                                     }
                                 }
                             },
                             removeVideo(index) {
                                 this.videoFiles.splice(index, 1);
                             }
                         }">
                        <div class="space-y-4">
                            <div>
                                <svg class="mx-auto w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                                    Kéo thả video vào đây hoặc
                                </p>
                                <label class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Chọn video
                                    <input type="file" 
                                           name="videos[]" 
                                           multiple 
                                           accept="video/*" 
                                           class="hidden"
                                           @change="addVideos($event.target.files)">
                                </label>
                            </div>
                            
                            <!-- Preview Videos -->
                            <div x-show="videoFiles.length > 0" class="grid grid-cols-4 gap-2">
                                <template x-for="(file, index) in videoFiles" :key="index">
                                    <div class="relative">
                                        <video :src="URL.createObjectURL(file)" 
                                               class="w-full h-20 object-cover rounded-lg"
                                               controls></video>
                                        <button type="button" 
                                                @click="removeVideo(index)"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs">
                                            ×
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        Hỗ trợ: MP4, MOV, AVI. Tối đa 50MB mỗi file.
                    </p>
                    @error('videos.*')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('reviews.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Gửi đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Initialize Alpine.js data for file uploads
document.addEventListener('alpine:init', () => {
    Alpine.data('fileUpload', () => ({
        imageFiles: [],
        videoFiles: [],
        
        addImages(files) {
            for (let i = 0; i < files.length; i++) {
                if (files[i].type.startsWith('image/')) {
                    this.imageFiles.push(files[i]);
                }
            }
        },
        
        addVideos(files) {
            for (let i = 0; i < files.length; i++) {
                if (files[i].type.startsWith('video/')) {
                    this.videoFiles.push(files[i]);
                }
            }
        },
        
        removeImage(index) {
            this.imageFiles.splice(index, 1);
        },
        
        removeVideo(index) {
            this.videoFiles.splice(index, 1);
        }
    }));
});

// Ensure rating stars work properly
document.addEventListener('DOMContentLoaded', function() {
    // Add any additional initialization if needed
    console.log('Review form loaded successfully');
});
</script>
@endpush

@push('styles')
<style>
/* Custom styles for rating stars */
.rating-star {
    cursor: pointer;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

.rating-star:hover {
    transform: scale(1.1);
}

.rating-star:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
}

/* Smooth transitions for star colors */
.rating-star {
    transition: all 0.2s ease-in-out;
}

/* Ensure stars are properly sized */
.rating-star {
    font-size: 1.875rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush
@endsection
