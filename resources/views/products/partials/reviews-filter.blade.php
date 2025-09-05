@php
    $currentRating = request('rating');
    $currentHasImages = request('has_images');
    $currentSort = request('sort', 'newest');
    
    // Get counts for tabs - we need to get these from the product model instead
    $totalReviews = isset($reviews) ? $reviews->total() : 0;
    $reviewsWithImages = isset($product) ? $product->reviews()->where('is_approved', true)->whereHas('images')->count() : 0;
@endphp

<div class="space-y-4">
    <!-- Filter Tabs -->
    <div class="border-b border-slate-200 dark:border-slate-700">
        <nav class="flex space-x-8" aria-label="Tabs">
            <a href="{{ route('products.show', $product) }}" 
               class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ !$currentRating && !$currentHasImages && $currentSort == 'newest' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300' }}">
                Tất cả ({{ $totalReviews }})
            </a>
            
            <a href="{{ route('products.show', $product, ['has_images' => '1']) }}" 
               class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $currentHasImages == '1' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300' }}">
                Có hình ảnh ({{ $reviewsWithImages }})
            </a>
            
            <a href="{{ route('products.show', $product, ['sort' => 'newest']) }}" 
               class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $currentSort == 'newest' && !$currentRating && !$currentHasImages ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300' }}">
                Mới nhất
            </a>
            
            <a href="{{ route('products.show', $product, ['sort' => 'rating_high']) }}" 
               class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $currentSort == 'rating_high' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300' }}">
                Cao nhất
            </a>
            
            <a href="{{ route('products.show', $product, ['sort' => 'rating_low']) }}" 
               class="py-2 px-1 border-b-2 font-medium text-sm transition-colors {{ $currentSort == 'rating_low' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300' }}">
                Thấp nhất
            </a>
        </nav>
    </div>

    <!-- Advanced Filters -->
    <form id="reviewsFilterForm" method="GET" class="space-y-3">
        <div class="flex flex-wrap gap-3">
            <!-- Rating Filter -->
            <div class="flex-1 min-w-[150px]">
                <select name="rating" class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-400">
                    <option value="" class="dark:bg-slate-800 dark:text-slate-200">Tất cả đánh giá</option>
                    <option value="5" {{ $currentRating == '5' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">5 sao</option>
                    <option value="4" {{ $currentRating == '4' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">4 sao</option>
                    <option value="3" {{ $currentRating == '3' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">3 sao</option>
                    <option value="2" {{ $currentRating == '2' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">2 sao</option>
                    <option value="1" {{ $currentRating == '1' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">1 sao</option>
                </select>
            </div>

            <!-- Has Images Filter -->
            <div class="flex-1 min-w-[150px]">
                <select name="has_images" class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-400">
                    <option value="" class="dark:bg-slate-800 dark:text-slate-200">Tất cả</option>
                    <option value="1" {{ $currentHasImages == '1' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">Có hình ảnh/video</option>
                </select>
            </div>

            <!-- Sort Filter -->
            <div class="flex-1 min-w-[150px]">
                <select name="sort" class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-400">
                    <option value="newest" {{ $currentSort == 'newest' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">Mới nhất</option>
                    <option value="oldest" {{ $currentSort == 'oldest' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">Cũ nhất</option>
                    <option value="rating_high" {{ $currentSort == 'rating_high' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">Đánh giá cao nhất</option>
                    <option value="rating_low" {{ $currentSort == 'rating_low' ? 'selected' : '' }} class="dark:bg-slate-800 dark:text-slate-200">Đánh giá thấp nhất</option>
                </select>
            </div>
        </div>

        <!-- Filter Actions -->
        <div class="flex items-center justify-between pt-3 border-t border-slate-200 dark:border-slate-700">
            <div class="flex items-center space-x-2">
                @if($currentRating || $currentHasImages || $currentSort != 'newest')
                    <a href="{{ route('products.show', $product) }}" 
                       class="inline-flex items-center px-3 py-1.5 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-medium rounded-md hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Xóa bộ lọc
                    </a>
                @endif
            </div>

            <div class="text-sm text-slate-600 dark:text-slate-400">
                Hiển thị {{ isset($reviews) ? ($reviews->firstItem() ?? 0) : 0 }}-{{ isset($reviews) ? ($reviews->lastItem() ?? 0) : 0 }} trong tổng số {{ isset($reviews) ? $reviews->total() : 0 }} đánh giá
            </div>
        </div>
    </form>
</div>

<style>
/* Custom styles for better dark mode support */
select option {
    background-color: white;
    color: #1f2937;
}

.dark select option {
    background-color: #1e293b;
    color: #e2e8f0;
}

.dark select {
    color: #e2e8f0;
}

.dark select:focus {
    background-color: #1e293b;
    color: #e2e8f0;
}
</style>

<script>
// Auto-submit form when filters change
document.getElementById('reviewsFilterForm').addEventListener('change', function(e) {
    if (e.target.tagName === 'SELECT') {
        this.submit();
    }
});
</script>
