@extends('layouts.app')

@section('title', 'Chỉnh sửa đánh giá - ' . $review->product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                Chỉnh sửa đánh giá
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                Cập nhật đánh giá của bạn về sản phẩm này
            </p>
            @if($review->getTimeRemainingToEdit())
                <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        ⏰ Bạn còn {{ $review->getTimeRemainingToEdit() }} để chỉnh sửa đánh giá này
                    </p>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-8">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-700">
                    @if($review->product->main_image)
                        <img src="{{ $review->product->main_image_url }}" 
                             alt="{{ $review->product->name }}"
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
                        {{ $review->product->name }}
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400">
                        Đơn hàng: #{{ $review->order->order_number }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-500">
                        Ngày mua: {{ $review->order->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <form action="{{ route('reviews.update', $review) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        Đánh giá của bạn <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-1" 
                         x-data="{ 
                             rating: {{ $review->rating }},
                             hoverRating: 0,
                             setRating(value) {
                                 this.rating = value;
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
                             isHalfStar(starIndex) {
                                 const displayRating = this.getDisplayRating();
                                 return displayRating >= starIndex - 0.5 && displayRating < starIndex;
                             },
                             isFullStar(starIndex) {
                                 const displayRating = this.getDisplayRating();
                                 return displayRating >= starIndex;
                             }
                         }">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="relative w-8 h-8">
                                <!-- Background Star (always gray) -->
                                <div class="absolute inset-0 text-3xl text-slate-300 dark:text-slate-600">☆</div>
                                
                                <!-- Half Star (left half) -->
                                <button type="button" 
                                        @click="setRating({{ $i - 0.5 }})"
                                        @mouseenter="setHoverRating({{ $i - 0.5 }})"
                                        @mouseleave="clearHoverRating()"
                                        class="absolute left-0 top-0 w-4 h-8 text-3xl transition-colors overflow-hidden"
                                        :class="isHalfStar({{ $i }}) ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600'">
                                    ★
                                </button>
                                
                                <!-- Full Star (right half) -->
                                <button type="button" 
                                        @click="setRating({{ $i }})"
                                        @mouseenter="setHoverRating({{ $i }})"
                                        @mouseleave="clearHoverRating()"
                                        class="absolute right-0 top-0 w-4 h-8 text-3xl transition-colors overflow-hidden"
                                        :class="isFullStar({{ $i }}) ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600'">
                                    ★
                                </button>
                            </div>
                        @endfor
                        <input type="hidden" name="rating" x-model="rating" required>
                        <span class="ml-3 text-sm text-slate-600 dark:text-slate-400" 
                              x-text="rating > 0 ? rating + '/5 sao' : 'Chọn số sao'"></span>
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
                              maxlength="1000">{{ old('comment', $review->comment) }}</textarea>
                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Tối đa 1000 ký tự
                    </div>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Images -->
                @if($review->images->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                            Hình ảnh hiện tại
                        </label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($review->images as $image)
                                <div class="relative group">
                                    @if($image->isImage())
                                        <img src="{{ $image->url }}" 
                                             alt="Review image"
                                             class="w-full h-20 object-cover rounded-lg border border-slate-200 dark:border-slate-600">
                                    @else
                                        <div class="w-full h-20 bg-slate-100 dark:bg-slate-700 rounded-lg border border-slate-200 dark:border-slate-600 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Delete button for existing images -->
                                    <button type="button" 
                                            onclick="deleteReviewImage({{ $review->id }}, {{ $image->id }})"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- New Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Thêm hình ảnh mới (tùy chọn)
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
                            
                            <!-- Preview New Images -->
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

                <!-- New Video Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Thêm video mới (tùy chọn)
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
                            
                            <!-- Preview New Videos -->
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cập nhật đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteReviewImage(reviewId, imageId) {
    if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
        fetch(`/reviews/${reviewId}/image`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                image_id: imageId
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page to update the view
                window.location.reload();
            } else {
                alert('Có lỗi xảy ra khi xóa hình ảnh');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa hình ảnh');
        });
    }
}
</script>
@endpush
@endsection
