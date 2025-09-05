<!-- Review Form Modal -->
<div x-show="showReviewForm" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
     @click.self="showReviewForm = false">
    
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                Viết đánh giá sản phẩm
            </h3>
            <button @click="showReviewForm = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ 
                      rating: 0, 
                      hoverRating: 0,
                      files: [],
                      hideName: false,
                      setRating(value) { this.rating = value; },
                      setHoverRating(value) { this.hoverRating = value; },
                      clearHoverRating() { this.hoverRating = 0; },
                      getDisplayRating() { return this.hoverRating || this.rating; },
                      addFiles(event) {
                          const newFiles = Array.from(event.target.files);
                          this.files = [...this.files, ...newFiles];
                      },
                      removeFile(index) {
                          this.files.splice(index, 1);
                      }
                  }">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <!-- Product Info -->
                <div class="flex items-center space-x-4 mb-6 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                    <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                    <div>
                        <h4 class="font-medium text-slate-900 dark:text-slate-100">{{ $product->name }}</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Đã mua vào {{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        Đánh giá của bạn *
                    </label>
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="relative">
                                <!-- Half Star -->
                                <button type="button" 
                                        @click="setRating({{ $i - 0.5 }})"
                                        @mouseenter="setHoverRating({{ $i - 0.5 }})"
                                        @mouseleave="clearHoverRating()"
                                        class="absolute inset-0 w-2 h-8 z-10">
                                </button>
                                <!-- Full Star -->
                                <button type="button" 
                                        @click="setRating({{ $i }})"
                                        @mouseenter="setHoverRating({{ $i }})"
                                        @mouseleave="clearHoverRating()"
                                        class="relative w-8 h-8 z-20">
                                </button>
                                <svg class="w-8 h-8 transition-colors" 
                                     :class="getDisplayRating() >= {{ $i }} ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        @endfor
                        <span class="ml-3 text-sm text-slate-600 dark:text-slate-400">
                            <span x-text="getDisplayRating() || 'Chọn số sao'"></span>/5
                        </span>
                    </div>
                    <input type="hidden" name="rating" x-model="rating" required>
                </div>

                <!-- Comment Section -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Bình luận của bạn
                    </label>
                    <textarea id="comment" name="comment" rows="4" 
                              class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-slate-100"
                              placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
                </div>

                <!-- Image Upload Section -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Thêm hình ảnh/video (tùy chọn)
                    </label>
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-6 text-center">
                        <input type="file" name="images[]" multiple accept="image/*,video/*" 
                               @change="addFiles($event)" class="hidden" id="file-upload">
                        <label for="file-upload" class="cursor-pointer">
                            <svg class="mx-auto w-12 h-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium text-blue-600 dark:text-blue-400">Click để tải lên</span> hoặc kéo thả
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">
                                PNG, JPG, MP4 tối đa 10MB mỗi file
                            </p>
                        </label>
                    </div>

                    <!-- File Preview -->
                    <div x-show="files.length > 0" class="mt-4">
                        <div class="grid grid-cols-4 gap-2">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="relative group">
                                    <img :src="URL.createObjectURL(file)" 
                                         class="w-full h-20 object-cover rounded-lg border border-slate-200 dark:border-slate-600">
                                    <button type="button" @click="removeFile(index)"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Privacy Options -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="hide_name" x-model="hideName" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">
                            Ẩn tên của tôi trong đánh giá này
                        </span>
                    </label>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <button type="button" @click="showReviewForm = false"
                            class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                        Hủy
                    </button>
                    <button type="submit" 
                            :disabled="rating === 0"
                            :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                        Gửi đánh giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
