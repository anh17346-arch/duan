@extends('layouts.app')

@section('title', $product->name . ' - Perfume Luxury')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-slate-600 dark:text-slate-400">
                <li><a href="{{ route('trangchu') }}" class="hover:text-brand-600 transition-colors">{{ __('app.home') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-brand-600 transition-colors">{{ __('app.products') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('products.category', $product->category) }}" class="hover:text-brand-600 transition-colors">{{ $product->category->display_name }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-slate-900 dark:text-slate-200 font-medium">{{ $product->display_name }}</li>
            </ol>
        </nav>

        <!-- Main Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Product Image Gallery - 1 column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Main Image with navigation -->
                <div class="relative aspect-square overflow-hidden rounded-2xl shadow-2xl border border-white/40 dark:border-white/20">
                    <img id="main-product-image" src="{{ $product->main_image_url }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover cursor-zoom-in transition-transform duration-300 hover:scale-105">
                    
                    <!-- Navigation Arrows -->
                    <button type="button" aria-label="{{ __('app.previous_image') }}" onclick="galleryPrev()" 
                            class="absolute left-3 top-1/2 -translate-y-1/2 backdrop-blur-sm bg-white/80 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button" aria-label="{{ __('app.next_image') }}" onclick="galleryNext()" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 backdrop-blur-sm bg-white/80 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($product->has_gallery && ($product->images->count() > 0 || $product->main_image))
                    <div id="thumbnails" class="grid grid-cols-4 gap-3">
                        <!-- Main Image Thumbnail -->
                        @if($product->main_image)
                            <button type="button" 
                                    data-index="main"
                                    data-image-url="{{ $product->main_image_url }}"
                                    onclick="changeMainImage(this.dataset.imageUrl, this)"
                                    class="aspect-square overflow-hidden rounded-xl border-2 border-brand-500 dark:border-brand-400 hover:border-brand-600 dark:hover:border-brand-300 transition-all duration-300 hover:scale-105 shadow-lg main-image-thumb">
                                <img src="{{ $product->main_image_url }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </button>
                        @endif
                        
                        <!-- Gallery Images -->
                        @foreach($product->images as $idx => $image)
                            <button type="button" 
                                    data-index="{{ $idx }}"
                                    data-image-url="{{ $image->image_url }}"
                                    onclick="changeMainImage(this.dataset.imageUrl, this)"
                                    class="aspect-square overflow-hidden rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-500 dark:hover:border-brand-400 transition-all duration-300 hover:scale-105 shadow-lg">
                                <img src="{{ $image->thumbnail_url }}" 
                                     alt="{{ $image->alt_text ?? $product->name }}"
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info - 2 columns -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Header Section -->
                <div class="space-y-4">
                    <!-- Category & Brand -->
                    <div class="flex items-center gap-3">
                        <span class="inline-block px-4 py-2 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 rounded-full text-sm font-semibold border border-brand-200 dark:border-brand-800/50">
                            {{ $product->category->display_name }}
                        </span>
                        @if($product->brand)
                            <span class="inline-block px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full text-sm font-medium border border-slate-200 dark:border-slate-600">
                                {{ $product->brand }}
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 leading-tight">{{ $product->display_name }}</h1>

                    <!-- Price Section -->
                    <div class="space-y-2">
                        @if($product->is_on_sale)
                            <div class="flex items-center gap-4">
                                <span class="text-3xl font-bold text-rose-600">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($product->final_price / 25000, 2) }}
                                    @else
                                        {{ number_format($product->final_price, 0, ',', '.') }}đ
                                    @endif
                                </span>
                                <span class="text-xl text-slate-400 line-through">
                                    @if(app()->getLocale() === 'en')
                                        ${{ number_format($product->price / 25000, 2) }}
                                    @else
                                        {{ number_format($product->price, 0, ',', '.') }}đ
                                    @endif
                                </span>
                                <span class="px-4 py-2 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-full text-sm font-bold border border-rose-200 dark:border-rose-800/50">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            </div>
                        @else
                            <span class="text-3xl font-bold text-slate-900 dark:text-slate-100">
                                @if(app()->getLocale() === 'en')
                                    ${{ number_format($product->price / 25000, 2) }}
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                @endif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Details Grid -->
                <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-6 border border-white/40 dark:border-white/20 shadow-lg">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-200 mb-4">{{ __('app.product_details') }}</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('app.volume') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $product->volume_ml }}ml</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('app.gender') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-slate-100">
                                    @switch($product->gender)
                                        @case('male') {{ __('app.male') }} @break
                                        @case('female') {{ __('app.female') }} @break
                                        @default {{ __('app.unisex') }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('app.status') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-slate-100">
                                    @if($product->stock > 0)
                                        <span class="text-green-600">
                                            @if(app()->getLocale() === 'en')
                                                In stock ({{ $product->stock }})
                                            @else
                                                Còn hàng ({{ $product->stock }})
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-rose-600">{{ __('app.out_of_stock') }}</span>
                                    @endif
                                </span>
                            </div>
                            @if($product->origin)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-slate-500 dark:text-slate-400">{{ __('app.origin') }}</span>
                                    <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $product->origin }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Views Stats -->
                    <div class="backdrop-blur-sm bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border border-blue-100 dark:border-blue-800/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-800/30 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wide">Lượt xem</p>
                                <p class="text-2xl font-bold text-blue-800 dark:text-blue-200">{{ $product->formatted_views }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Stats -->
                    <div class="backdrop-blur-sm bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-2xl p-6 border border-emerald-100 dark:border-emerald-800/30 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-emerald-100 dark:bg-emerald-800/30 rounded-xl">
                                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wide">Đã bán</p>
                                <p class="text-2xl font-bold text-emerald-800 dark:text-emerald-200">{{ $product->formatted_sold }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-6 border border-white/40 dark:border-white/20 shadow-lg">
                    @if($product->stock > 0)
                        <form method="POST" action="{{ route('cart.add') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('app.quantity') }}:</label>
                                <div class="flex items-center border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                                    <button type="button" onclick="changeQuantity(-1)" class="px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                           class="w-16 text-center border-0 focus:ring-0 bg-transparent text-slate-900 dark:text-slate-100">
                                    <button type="button" onclick="changeQuantity(1)" class="px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-sm text-slate-500 dark:text-slate-400">/ {{ $product->stock }}</span>
                            </div>
                            
                            <button type="submit" class="w-full px-6 py-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                                🛒 {{ __('app.add_to_cart') }}
                            </button>
                        </form>
                        
                        <button class="w-full px-6 py-4 border-2 border-brand-600 text-brand-600 hover:bg-brand-600 hover:text-white rounded-xl font-semibold transition-all duration-300 mt-3 hover:scale-[1.02]">
                            ❤️ {{ __('app.add_to_wishlist') }}
                        </button>
                    @else
                        <button class="w-full px-6 py-4 bg-slate-400 text-white rounded-xl font-semibold cursor-not-allowed" disabled>
                            {{ __('app.out_of_stock') }}
                        </button>
                    @endif

                    <!-- Stock Warning -->
                    @if($product->stock <= 10 && $product->stock > 0)
                        <div class="backdrop-blur-sm bg-amber-50/80 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 mt-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-amber-800 dark:text-amber-200 text-sm font-medium">Chỉ còn {{ $product->stock }} sản phẩm!</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Description -->
        @if($product->description)
            <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-8 shadow-lg border border-white/40 dark:border-white/20 mb-12">
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-200 mb-6">{{ __('app.product_description') }}</h2>
                <div class="prose prose-slate dark:prose-invert max-w-none text-base leading-relaxed">
                    {!! nl2br(e($product->display_description)) !!}
                </div>
            </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl p-8 shadow-lg border border-white/40 dark:border-white/20">
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-200 mb-8">{{ __('app.related_products') }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-2xl overflow-hidden shadow-lg border border-white/40 dark:border-white/20 hover:shadow-2xl hover:bg-white/40 dark:hover:bg-white/15 transition-all duration-300 h-full flex flex-col group">
                            <div class="aspect-square overflow-hidden">
                                <img src="{{ $relatedProduct->main_image_url }}" 
                                     alt="{{ $relatedProduct->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            
                            <div class="p-4 flex-grow flex flex-col">
                                <div class="mb-2 h-[1.8rem] flex items-center">
                                    <span class="inline-block px-2 py-1 text-xs bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 rounded-full font-medium">
                                        {{ $relatedProduct->category->name }}
                                    </span>
                                </div>
                                
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-2 line-clamp-2 text-sm h-[2.5rem] flex items-start">
                                    {{ $relatedProduct->name }}
                                </h3>
                                
                                <div class="mb-2 h-[1.2rem] flex items-center">
                                    @if($relatedProduct->brand)
                                        <p class="text-xs text-slate-600 dark:text-slate-400">{{ $relatedProduct->brand }}</p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between mb-3 h-[1.2rem]">
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $relatedProduct->volume_ml }}ml
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        @switch($relatedProduct->gender)
                                            @case('male') Nam @break
                                            @case('female') Nữ @break
                                            @default Unisex
                                        @endswitch
                                    </div>
                                </div>
                                
                                <div class="mb-4 min-h-[3rem] flex items-start">
                                    @if($relatedProduct->is_on_sale)
                                        <div class="flex flex-col gap-1">
                                            <span class="text-lg font-bold text-brand-600">
                                                {{ number_format($relatedProduct->final_price, 0, ',', '.') }}đ
                                            </span>
                                            <span class="text-sm text-slate-400 line-through">
                                                {{ number_format($relatedProduct->price, 0, ',', '.') }}đ
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                            {{ number_format($relatedProduct->price, 0, ',', '.') }}đ
                                        </span>
                                    @endif
                                </div>
                                
                                <a href="{{ route('products.show', $relatedProduct) }}" 
                                   class="group/btn relative w-full inline-flex items-center justify-center gap-2 px-3 py-2.5 bg-white/90 dark:bg-white/80 text-slate-800 dark:text-slate-900 rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl border border-slate-200/50 dark:border-slate-300/50 hover:bg-white dark:hover:bg-white overflow-hidden whitespace-nowrap text-sm mt-auto">
                                    <!-- Shimmer effect -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                                    
                                    <svg class="w-3.5 h-3.5 group-hover/btn:scale-110 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="relative z-10 flex-shrink-0">{{ __('app.view_details') }}</span>
                                    <svg class="w-2.5 h-2.5 group-hover/btn:translate-x-1 transition-transform duration-300 relative z-10 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Build gallery list including main image
const galleryImages = [
    @if($product->main_image)
        '{{ $product->main_image_url }}',
    @endif
    @if($product->has_gallery && $product->images->count() > 0)
        @foreach($product->images as $image)
            '{{ $image->image_url }}',
        @endforeach
    @endif
];
let currentIndex = 0; // Start with main image (index 0)

function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    const newValue = Math.max(1, Math.min(currentValue + change, {{ $product->stock }}));
    input.value = newValue;
}

function changeMainImage(imageUrl, button) {
    // Thay đổi ảnh chính
    document.getElementById('main-product-image').src = imageUrl;
    const idx = galleryImages.indexOf(imageUrl);
    if (idx >= 0) currentIndex = idx;
    
    // Cập nhật border của thumbnail
    document.querySelectorAll('#thumbnails button').forEach(btn => {
        if (btn.classList.contains('main-image-thumb')) {
            // Main image thumb keeps brand color when not selected
            if (btn === button) {
                btn.classList.remove('border-brand-500', 'dark:border-brand-400');
                btn.classList.add('border-brand-600', 'dark:border-brand-300');
            } else {
                btn.classList.remove('border-brand-600', 'dark:border-brand-300');
                btn.classList.add('border-brand-500', 'dark:border-brand-400');
            }
        } else {
            // Gallery thumbnails
            btn.classList.remove('border-brand-500', 'dark:border-brand-400');
            btn.classList.add('border-slate-200', 'dark:border-slate-700');
        }
    });
    
    // Highlight selected thumbnail
    if (!button.classList.contains('main-image-thumb')) {
        button.classList.remove('border-slate-200', 'dark:border-slate-700');
        button.classList.add('border-brand-500', 'dark:border-brand-400');
    }
}

function galleryShow(index) {
    if (!galleryImages || galleryImages.length === 0) return;
    currentIndex = (index + galleryImages.length) % galleryImages.length;
    const url = galleryImages[currentIndex];
    const main = document.getElementById('main-product-image');
    if (main) main.src = url;
    // highlight thumbnail if exists
    const thumbnails = document.querySelectorAll('#thumbnails button');
    if (thumbnails.length) {
        thumbnails.forEach(btn => {
            btn.classList.remove('border-brand-500', 'dark:border-brand-400');
            btn.classList.add('border-slate-200', 'dark:border-slate-700');
        });
        if (thumbnails[currentIndex]) {
            thumbnails[currentIndex].classList.remove('border-slate-200', 'dark:border-slate-700');
            thumbnails[currentIndex].classList.add('border-brand-500', 'dark:border-brand-400');
        }
    }
}

function galleryPrev() { galleryShow(currentIndex - 1); }
function galleryNext() { galleryShow(currentIndex + 1); }

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') galleryPrev();
    if (e.key === 'ArrowRight') galleryNext();
});
</script>
@endsection
