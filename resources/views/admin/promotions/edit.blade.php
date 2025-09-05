@extends('layouts.app')

@section('title', __('app.edit_promotion') . ' - Perfume Luxury')

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
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('app.edit_promotion') }}</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('app.update_promotion_info') }}</p>
                </div>
                <a href="{{ route('admin.promotions.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('app.back') }}
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}">
                        @csrf
                        @method('PUT')

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('app.select_product') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="product_id" name="product_id" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('product_id') border-red-500 @enderror [&>option]:dark:bg-gray-700 [&>option]:dark:text-white [&>option]:hover:dark:bg-gray-600 [&>option]:hover:dark:text-gray-100">
                                <option value="">{{ __('app.select_product_placeholder') }}</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ (old('product_id', $promotion->product_id) == $product->id) ? 'selected' : '' }}>
                                        {{ $product->name }} - {{ $product->brand }} ({{ number_format($product->price, 0, ',', '.') }}đ)
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount Percentage -->
                        <div class="mb-6">
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('app.discount_percentage') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="discount_percentage" name="discount_percentage" 
                                       step="0.01" min="0" max="100"
                                       value="{{ old('discount_percentage', $promotion->discount_percentage) }}"
                                       class="w-full px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('discount_percentage') border-red-500 @enderror"
                                       placeholder="{{ __('app.discount_percentage_placeholder') }}">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">%</span>
                                </div>
                            </div>
                            @error('discount_percentage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('app.discount_percentage_help') }}
                            </p>
                        </div>

                        <!-- Promotion Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('app.promotion_quantity') }}
                            </label>
                            <input type="number" id="quantity" name="quantity" 
                                   min="0"
                                   value="{{ old('quantity', $promotion->quantity) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('quantity') border-red-500 @enderror"
                                   placeholder="{{ __('app.promotion_quantity_placeholder') }}">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('app.promotion_quantity_help') }}
                            </p>
                        </div>

                        <!-- Sold Quantity Display -->
                        @if($promotion->sold_quantity > 0)
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <h3 class="text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">{{ __('app.sold_quantity_info') }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-blue-600 dark:text-blue-400">
                                    {{ __('app.sold_quantity') }}: <strong>{{ $promotion->sold_quantity }}</strong>
                                </span>
                                @if($promotion->quantity > 0)
                                <span class="text-sm text-blue-600 dark:text-blue-400">
                                    {{ __('app.remaining_quantity') }}: <strong>{{ $promotion->remaining_quantity }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Start Date -->
                        <div class="mb-6">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('app.start_date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="start_date" name="start_date" 
                                   value="{{ old('start_date', $promotion->start_date->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="mb-6">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('app.end_date') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="end_date" name="end_date" 
                                   value="{{ old('end_date', $promotion->end_date->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('end_date') border-red-500 @enderror">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Status -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('app.current_status') }}</h3>
                            <div class="flex items-center space-x-2">
                                @if($promotion->isActive())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ __('app.currently_active') }}
                                    </span>
                                @elseif($promotion->isUpcoming())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ __('app.upcoming') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ __('app.ended') }}
                                    </span>
                                @endif
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    ({{ $promotion->formatted_start_date }} - {{ $promotion->formatted_end_date }})
                                </span>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('app.promotion_preview') }}</h3>
                            <div id="promotion-preview" class="text-sm text-gray-600 dark:text-gray-400">
                                <p>{{ __('app.select_product_and_enter_info') }}</p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.promotions.index') }}" 
                               class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">
                                {{ __('app.cancel') }}
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                {{ __('app.update_promotion') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom dropdown styles for dark mode - using !important to override browser defaults */
select option {
    background-color: white !important;
    color: black !important;
}

.dark select option {
    background-color: #374151 !important; /* gray-700 */
    color: white !important;
}

.dark select option:hover {
    background-color: #4B5563 !important; /* gray-600 */
    color: #F3F4F6 !important; /* gray-100 */
}

.dark select option:checked {
    background-color: #3B82F6 !important; /* blue-500 */
    color: white !important;
}

.dark select option:focus {
    background-color: #4B5563 !important; /* gray-600 */
    color: #F3F4F6 !important; /* gray-100 */
}

/* Ensure dropdown arrow is visible in dark mode */
.dark select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Additional styling for better dropdown appearance */
select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

/* Force dark mode styling for dropdown list */
.dark select:focus option {
    background-color: #374151 !important;
    color: white !important;
}

.dark select:focus option:hover {
    background-color: #4B5563 !important;
    color: #F3F4F6 !important;
}

.dark select:focus option:checked {
    background-color: #3B82F6 !important;
    color: white !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const discountInput = document.getElementById('discount_percentage');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const previewDiv = document.getElementById('promotion-preview');

    // Force dark mode styling for dropdown options
    function applyDarkModeToDropdown() {
        if (document.documentElement.classList.contains('dark')) {
            const options = productSelect.querySelectorAll('option');
            options.forEach(option => {
                option.style.backgroundColor = '#374151';
                option.style.color = 'white';
            });
        }
    }

    // Apply styling when dropdown opens
    productSelect.addEventListener('focus', applyDarkModeToDropdown);
    productSelect.addEventListener('click', applyDarkModeToDropdown);

    function updatePreview() {
        const selectedProduct = productSelect.options[productSelect.selectedIndex];
        const discount = discountInput.value;
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        if (selectedProduct && selectedProduct.value && discount && startDate && endDate) {
            const productName = selectedProduct.text.split(' - ')[0];
            const productPrice = selectedProduct.text.match(/\(([^)]+)\)/)[1];
            const discountAmount = (parseFloat(productPrice.replace(/[^\d]/g, '')) * parseFloat(discount) / 100).toLocaleString('vi-VN');
            const finalPrice = (parseFloat(productPrice.replace(/[^\d]/g, '')) * (100 - parseFloat(discount)) / 100).toLocaleString('vi-VN');

            previewDiv.innerHTML = `
                <div class="space-y-2">
                    <p><strong>{{ __('app.product') }}:</strong> ${productName}</p>
                    <p><strong>{{ __('app.original_price') }}:</strong> ${productPrice}</p>
                    <p><strong>{{ __('app.discount') }}:</strong> ${discount}% (${discountAmount}đ)</p>
                    <p><strong>{{ __('app.price_after_discount') }}:</strong> <span class="text-red-600 font-semibold">${finalPrice}đ</span></p>
                    <p><strong>{{ __('app.time_period') }}:</strong> ${new Date(startDate).toLocaleString('vi-VN')} - ${new Date(endDate).toLocaleString('vi-VN')}</p>
                </div>
            `;
        } else {
            previewDiv.innerHTML = '<p>{{ __('app.select_product_and_enter_info') }}</p>';
        }
    }

    // Add event listeners
    productSelect.addEventListener('change', updatePreview);
    discountInput.addEventListener('input', updatePreview);
    startDateInput.addEventListener('change', updatePreview);
    endDateInput.addEventListener('change', updatePreview);

    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value <= this.value) {
            endDateInput.value = '';
        }
        updatePreview();
    });

    // Initial preview update
    updatePreview();
});
</script>
</div>
@endsection
