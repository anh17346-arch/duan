@if($product->upcoming_promotion_info)
    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                Khuyến mãi sắp diễn ra
            </span>
        </div>
        <div class="text-sm text-blue-600 dark:text-blue-400">
            <div class="flex items-center gap-2 mb-1">
                <span class="font-semibold">-{{ $product->upcoming_promotion_info['discount_percentage'] }}%</span>
                <span>từ {{ $product->upcoming_promotion_info['formatted_start_date'] }}</span>
            </div>
            <div class="text-xs">
                Kết thúc: {{ $product->upcoming_promotion_info['formatted_end_date'] }}
            </div>
        </div>
    </div>
@endif
