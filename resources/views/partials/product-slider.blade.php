{{--
  Product Slider Component
  
  Props:
  - $products: Collection of products
  - $section: string - unique identifier for this slider
  - $title: string - section title
  - $subtitle: string - section subtitle  
  - $icon: string - icon HTML
  - $gradient: string - background gradient classes
  - $viewAllUrl: string - URL for "View All" link
  - $titleColor: string - title color classes
--}}

<div class="backdrop-blur-md {{ $gradient ?? 'bg-white/20 dark:bg-white/5' }} rounded-3xl p-6 shadow-lg border border-white/30 dark:border-white/10" 
     x-data="productSlider('{{ $section }}')">
  
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 {{ $iconBg ?? 'bg-gradient-to-br from-yellow-400 to-orange-500' }} rounded-xl flex items-center justify-center">
        {!! $icon !!}
      </div>
      <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $title }}</h2>
        <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $subtitle }}</p>
      </div>
    </div>
    <!-- View All Link -->
    <a href="{{ $viewAllUrl }}" 
       class="{{ $titleColor ?? 'text-brand-600 hover:text-brand-700' }} font-semibold hover:scale-105 transition-transform text-sm">
      {{ __('app.view_all') }}
    </a>
  </div>
  
  <!-- Products Slider -->
  <div class="relative group">
    <!-- Scroll Container -->
    <div x-ref="slider" 
         class="flex gap-4 overflow-x-auto scrollbar-hide scroll-smooth pb-2"
         style="scrollbar-width: none; -ms-overflow-style: none;">
      @foreach($products as $product)
        <div class="flex-shrink-0">
          @include('partials.product-card-compact', [
            'product' => $product, 
            'promotionService' => $promotionService ?? null
          ])
        </div>
      @endforeach
    </div>
    
    <!-- Navigation Buttons - Positioned at center sides -->
    <!-- Previous Button -->
    <button @click="scrollLeft()" 
            x-show="canScrollLeft"
            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 dark:bg-slate-800/90 hover:bg-white dark:hover:bg-slate-800 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-white/40 dark:border-slate-700/40">
      <svg class="w-5 h-5 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
    </button>
    
    <!-- Next Button -->
    <button @click="scrollRight()" 
            x-show="canScrollRight"
            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 dark:bg-slate-800/90 hover:bg-white dark:hover:bg-slate-800 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105 backdrop-blur-sm border border-white/40 dark:border-slate-700/40">
      <svg class="w-5 h-5 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>
    
    <!-- Subtle Gradient Overlays - Match card border radius -->
    <div class="absolute top-0 left-0 w-20 h-full bg-gradient-to-r from-white/60 dark:from-slate-900/60 via-white/30 dark:via-slate-900/30 via-transparent to-transparent pointer-events-none rounded-l-xl"></div>
    <div class="absolute top-0 right-0 w-20 h-full bg-gradient-to-l from-white/60 dark:from-slate-900/60 via-white/30 dark:via-slate-900/30 via-transparent to-transparent pointer-events-none rounded-r-xl"></div>
  </div>
  
  <!-- Scroll Indicators -->
  <div class="flex justify-center mt-4">
    <div class="flex gap-2">
      <template x-for="i in Math.ceil({{ $products->count() }} / 4)" :key="i">
        <button @click="scrollToPage(i - 1)" 
                class="w-2 h-2 rounded-full transition-all duration-300"
                :class="currentPage === (i - 1) ? 'bg-slate-400 dark:bg-slate-500' : 'bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600'">
        </button>
      </template>
    </div>
  </div>
</div>

<script>
function productSlider(section) {
  return {
    currentPage: 0,
    maxPages: Math.ceil({{ $products->count() }} / 4),
    canScrollLeft: false,
    canScrollRight: true,
    
    init() {
      this.checkScrollButtons();
      
      this.$refs.slider.addEventListener('scroll', () => {
        this.checkScrollButtons();
        this.updateCurrentPage();
      });
    },
    
    checkScrollButtons() {
      const slider = this.$refs.slider;
      this.canScrollLeft = slider.scrollLeft > 5;
      this.canScrollRight = slider.scrollLeft < (slider.scrollWidth - slider.clientWidth - 5);
    },
    
    scrollLeft() {
      const slider = this.$refs.slider;
      const cardWidth = 304; // 280px width + 24px gap
      
      slider.scrollBy({ 
        left: -cardWidth * 2, 
        behavior: 'smooth' 
      });
      
      setTimeout(() => this.checkScrollButtons(), 100);
    },
    
    scrollRight() {
      const slider = this.$refs.slider;
      const cardWidth = 304; // 280px width + 24px gap  
      
      slider.scrollBy({ 
        left: cardWidth * 2, 
        behavior: 'smooth' 
      });
      
      setTimeout(() => this.checkScrollButtons(), 100);
    },
    
    scrollToPage(page) {
      const slider = this.$refs.slider;
      const cardWidth = 304; // 280px width + 24px gap
      const scrollAmount = cardWidth * 2 * page;
      
      slider.scrollTo({ 
        left: scrollAmount, 
        behavior: 'smooth' 
      });
      
      this.currentPage = page;
      
      setTimeout(() => {
        this.checkScrollButtons();
      }, 300);
    },
    
    updateCurrentPage() {
      const slider = this.$refs.slider;
      const cardWidth = 304;
      const newPage = Math.round(slider.scrollLeft / (cardWidth * 2));
      
      if (newPage !== this.currentPage) {
        this.currentPage = newPage;
      }
    }
  }
}
</script>

<style>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

.scroll-smooth {
  scroll-behavior: smooth;
}
</style>
