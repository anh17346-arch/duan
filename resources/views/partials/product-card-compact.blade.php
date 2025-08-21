<div class="group backdrop-blur-sm bg-white/30 dark:bg-white/10 rounded-xl overflow-hidden shadow-lg border border-white/40 dark:border-white/20 hover:shadow-2xl hover:bg-white/40 dark:hover:bg-white/15 transition-all duration-300 hover:-translate-y-1 h-full flex flex-col min-w-[280px] max-w-[300px]">
  <!-- Product Image -->
  <div class="relative aspect-square overflow-hidden">
    <img src="{{ $product->main_image_url }}" 
         alt="{{ $product->name }}"
         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
    
    <!-- Product Badges -->
    <div class="absolute top-2 left-2 flex flex-col gap-1">
      @if($product->is_new)
        <span class="px-1.5 py-0.5 bg-blue-500 text-white text-xs font-semibold rounded-md shadow-lg">
          {{ __('app.new') }}
        </span>
      @endif
      @if($product->is_on_sale)
        <span class="px-1.5 py-0.5 bg-rose-500 text-white text-xs font-semibold rounded-md shadow-lg">
          {{ __('app.sale') }}
        </span>
      @endif
      @if($product->is_featured)
        <span class="px-1.5 py-0.5 bg-yellow-500 text-white text-xs font-semibold rounded-md shadow-lg">
           NỔI BẬT
        </span>
      @endif
    </div>
    
    <!-- Quick Actions -->
    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
      <button class="w-7 h-7 bg-white/90 dark:bg-slate-800/90 rounded-full flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-slate-700 transition-colors">
        <svg class="w-3.5 h-3.5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
      </button>
    </div>
  </div>
  
  <!-- Product Info -->
  <div class="p-3 flex-grow flex flex-col">
    <!-- Category & Brand -->
    <div class="flex items-center justify-between mb-1.5 h-[1.5rem]">
      <a href="{{ route('search.category', $product->category) }}" 
         class="inline-block px-1.5 py-0.5 text-xs bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300 rounded-full font-medium hover:bg-brand-200 dark:hover:bg-brand-800/50 transition-colors">
        {{ $product->category->display_name }}
      </a>
      @if($product->brand)
        <a href="{{ route('search.brand', $product->brand) }}" 
           class="text-xs text-slate-500 dark:text-slate-400 font-medium hover:text-brand-600 dark:hover:text-brand-400 transition-colors truncate max-w-[100px]">
          {{ $product->brand }}
        </a>
      @endif
    </div>
    
    <!-- Product Name -->
    <h3 class="font-semibold text-slate-900 dark:text-slate-100 mb-1.5 line-clamp-2 text-sm leading-tight group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors h-[2rem] flex items-start">
      {{ $product->display_name }}
    </h3>
    
    <!-- Product Specs -->
    <div class="flex items-center justify-between mb-1 text-xs text-slate-500 dark:text-slate-400 h-[1rem]">
      <span>{{ $product->volume_ml }}ml</span>
      <span>
        @switch($product->gender)
          @case('male') {{ __('app.male') }} @break
          @case('female') {{ __('app.female') }} @break
          @default {{ __('app.unisex') }}
        @endswitch
      </span>
    </div>
    
    <!-- Modern Compact Stats -->
    <div class="flex items-center justify-center gap-2 mb-2 h-[1.25rem]">
      <div class="group flex items-center gap-1 px-1.5 py-0.5 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/15 dark:to-indigo-900/15 rounded-full border border-blue-100/50 dark:border-blue-800/20 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-800/25 dark:hover:to-indigo-800/25 transition-all duration-300 hover:scale-105 hover:shadow-sm">
        <svg class="w-2.5 h-2.5 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        <span class="text-xs font-semibold text-blue-700 dark:text-blue-300 group-hover:text-blue-800 dark:group-hover:text-blue-200 transition-colors duration-300">{{ $product->formatted_views }}</span>
      </div>
      <div class="group flex items-center gap-1 px-1.5 py-0.5 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/15 dark:to-green-900/15 rounded-full border border-emerald-100/50 dark:border-emerald-800/20 hover:from-emerald-100 hover:to-green-100 dark:hover:from-emerald-800/25 dark:hover:to-green-800/25 transition-all duration-300 hover:scale-105 hover:shadow-sm">
        <svg class="w-2.5 h-2.5 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
        <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-300 group-hover:text-emerald-800 dark:group-hover:text-emerald-200 transition-colors duration-300">{{ $product->formatted_sold }}</span>
      </div>
    </div>
    
    <!-- Price -->
    <div class="mb-3 min-h-[3rem] flex items-start">
      @if($product->is_on_sale)
        <div class="flex flex-col gap-0.5">
          <div class="flex items-center gap-1.5">
            <span class="text-base font-bold text-rose-600">
              @if(app()->getLocale() === 'en')
                ${{ number_format($product->final_price / 25000, 2) }}
              @else
                {{ number_format($product->final_price, 0, ',', '.') }}đ
              @endif
            </span>
            <span class="text-xs text-slate-400 line-through">
              @if(app()->getLocale() === 'en')
                ${{ number_format($product->price / 25000, 2) }}
              @else
                {{ number_format($product->price, 0, ',', '.') }}đ
              @endif
            </span>
          </div>
          @if($product->discount_percentage)
            <span class="px-1.5 py-0.5 bg-rose-100 text-rose-600 rounded-full text-xs font-semibold w-fit">
              -{{ $product->discount_percentage }}%
            </span>
          @endif
        </div>
      @else
        <span class="text-base font-bold text-slate-900 dark:text-slate-100">
          @if(app()->getLocale() === 'en')
            ${{ number_format($product->price / 25000, 2) }}
          @else
            {{ number_format($product->price, 0, ',', '.') }}đ
          @endif
        </span>
      @endif
    </div>
    
    <!-- Action Button -->
    <a href="{{ route('products.show', $product) }}" 
       class="group/btn relative w-full inline-flex items-center justify-center gap-2 px-3 py-2 bg-white/90 dark:bg-white/80 text-slate-800 dark:text-slate-900 rounded-lg font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl border border-slate-200/50 dark:border-slate-300/50 hover:bg-white dark:hover:bg-white overflow-hidden whitespace-nowrap mt-auto text-sm">
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
