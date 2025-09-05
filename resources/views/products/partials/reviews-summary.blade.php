@php
    $approvedReviews = $product->reviews()->where('is_approved', true);
    $totalReviews = $approvedReviews->count();
    $averageRating = $totalReviews > 0 ? $approvedReviews->avg('rating') : 0;
    
    // Calculate rating distribution
    $ratingDistribution = [];
    for ($i = 1; $i <= 5; $i++) {
        $ratingDistribution[$i] = $product->reviews()->where('is_approved', true)->where('rating', $i)->count();
    }
    
    // Debug info
    // dd($ratingDistribution, $totalReviews, $averageRating);
    
    // Calculate additional stats
    $reviewsWithImages = $approvedReviews->whereHas('images')->count();
    $verifiedPurchases = $approvedReviews->where('is_verified', true)->count();
@endphp

<div class="space-y-6" x-data="{ showReviews: false, showReviewForm: false }">
    <!-- Header Section -->
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4"></h3>
            
            @if($totalReviews > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Average Rating -->
                    <div class="text-center">
                        <div class="flex justify-center text-yellow-400 text-4xl mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $averageRating)
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @elseif($i - $averageRating < 1)
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="partialStar">
                                                <stop offset="{{ ($averageRating - floor($averageRating)) * 100 }}%" stop-color="#fbbf24"/>
                                                <stop offset="{{ ($averageRating - floor($averageRating)) * 100 }}%" stop-color="#d1d5db"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#partialStar)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-1">
                            {{ number_format($averageRating, 1) }}
                        </p>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Dựa trên {{ $totalReviews }} đánh giá thực
                        </p>
                    </div>

                    <!-- Rating Distribution -->
                    <div class="lg:col-span-2">
                        <div class="space-y-2">
                            @for($i = 5; $i >= 1; $i--)
                                @php
                                    $count = $ratingDistribution[$i] ?? 0;
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                @endphp
                                <div class="flex items-center space-x-3">
                                    <div class="flex items-center space-x-1 w-16">
                                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ $i }}</span>
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="w-12 text-right">
                                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ $count }}</span>
                                        <!-- Debug: {{ $count }} -->
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">
                        Hãy là người đầu tiên đánh giá sản phẩm này
                    </h4>
                    <p class="text-slate-600 dark:text-slate-400 mb-4">
                        Để nhận 50 điểm thưởng 🎁
                    </p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col space-y-2 ml-6">
            @auth
                @php
                    $userHasPurchased = auth()->user()->orders()
                        ->where('status', 'delivered')
                        ->whereHas('items', function($query) use ($product) {
                            $query->where('product_id', $product->id);
                        })
                        ->exists();
                    
                    $userHasReviewed = auth()->user()->reviews()
                        ->where('product_id', $product->id)
                        ->exists();
                @endphp

                @if($userHasPurchased && !$userHasReviewed)
                    @php
                        $order = auth()->user()->orders()
                            ->where('status', 'delivered')
                            ->whereHas('items', function($query) use ($product) {
                                $query->where('product_id', $product->id);
                            })
                            ->first();
                    @endphp
                    <button @click="showReviewForm = true" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Viết đánh giá
                    </button>
                @elseif($userHasReviewed)
                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 text-sm font-medium rounded-lg">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Đã đánh giá
                    </span>
                @endif
            @endauth

            @if($totalReviews > 0)
                <button @click="showReviews = !showReviews" 
                        class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-medium rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-4 h-4 mr-2 transition-transform" :class="showReviews ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <span x-text="showReviews ? 'Ẩn đánh giá' : 'Xem đánh giá'"></span>
                </button>
            @endif
        </div>
    </div>

    @if($totalReviews > 0)
        <!-- Expandable Reviews Panel -->
        <div x-show="showReviews" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="border-t border-slate-200 dark:border-slate-700 pt-6">
            
            <!-- Reviews Filter -->
            @include('products.partials.reviews-filter')
            
            <!-- Reviews List -->
            @include('products.partials.reviews-list')
        </div>
    @endif

    <!-- Review Form Modal -->
    @auth
        @if($userHasPurchased && !$userHasReviewed)
            @include('products.partials.review-form-modal')
        @endif
    @endauth
</div>
