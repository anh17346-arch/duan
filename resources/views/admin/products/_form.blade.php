{{-- Modern Product Form - Synchronized with Product Detail Page --}} 

<!-- Modern Unified Background (đồng bộ với product detail) -->
<div class="min-h-screen relative overflow-hidden">
  <!-- Animated Background -->
  <div class="fixed inset-0 -z-10">
    <!-- Main Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 via-purple-50/60 to-pink-50/60 dark:from-slate-900 dark:via-blue-900/30 dark:via-purple-900/30 dark:to-pink-900/30"></div>
    
    <!-- Floating Animated Blobs -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-gradient-to-r from-blue-400/10 to-purple-400/10 dark:from-blue-400/5 dark:to-purple-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-pink-400/10 to-rose-400/10 dark:from-pink-400/5 dark:to-rose-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-32 left-1/3 w-80 h-80 bg-gradient-to-r from-cyan-400/10 to-teal-400/10 dark:from-cyan-400/5 dark:to-teal-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-4000"></div>
    
    <!-- Mesh Gradient Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.05),transparent_50%)]"></div>
    
    <!-- Subtle Grid Pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(100,116,139,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(100,116,139,0.03)_1px,transparent_1px)] bg-[size:64px_64px] dark:bg-[linear-gradient(rgba(148,163,184,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.02)_1px,transparent_1px)]"></div>
  </div>

  <div class="relative container mx-auto px-4 py-8">
    @if ($errors->any())
      <div class="mb-6 backdrop-blur-md bg-rose-50/90 dark:bg-rose-900/30 rounded-2xl border border-rose-200/80 dark:border-rose-700 text-rose-700 dark:text-rose-200 px-6 py-4 shadow-lg">
        <div class="flex items-center gap-3">
          <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-lg">{{ __('app.please_check_info') }}</h3>
            <ul class="mt-2 list-disc list-inside text-sm space-y-1">
              @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif

<div class="space-y-10">
  <!-- Thông tin cơ bản -->
  <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-shadow duration-300">
    <h3 class="text-xl font-bold mb-6 text-brand-700 dark:text-brand-300 flex items-center gap-3">
      <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      {{ __('app.basic_information') }}
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.product_name') }} <span class="text-rose-600">*</span>
        </label>
    <input name="name" value="{{ old('name', isset($product) ? $product->name : '') }}" required
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="{{ __('app.enter_product_name') }}">
        @error('name')
  <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
    <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="text-sm">{{ $message }}</span>
  </div>
@enderror
  </div>

  <!-- English Name Field -->
  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300 flex items-center gap-2">
          {{ __('app.product_name_english') }} 
          <button type="button" id="translate-name-btn" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-md transition-colors">
            🌐 {{ __('app.auto_translate') }}
          </button>
        </label>
    <input name="name_en" value="{{ old('name_en', isset($product) ? $product->name_en : '') }}" id="name_en"
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="Product name in English...">
        @error('name_en')
  <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
    <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="text-sm">{{ $message }}</span>
  </div>
@enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.brand') }}
        </label>
    <input name="brand" value="{{ old('brand', isset($product) ? $product->brand : '') }}"
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="{{ __('app.enter_brand') }}">
        @error('brand')
  <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
    <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="text-sm">{{ $message }}</span>
  </div>
@enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.gender') }} <span class="text-rose-600">*</span>
        </label>
    <select name="gender" required
                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
      <option value="male"   @selected(old('gender', isset($product) ? $product->gender : '')==='male') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.men') }}</option>
      <option value="female" @selected(old('gender', isset($product) ? $product->gender : '')==='female') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.women') }}</option>
      <option value="unisex" @selected(old('gender', isset($product) ? $product->gender : 'unisex')==='unisex') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.unisex') }}</option>
    </select>
        @error('gender')
  <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
    <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="text-sm">{{ $message }}</span>
  </div>
@enderror
      </div>
    </div>
  </div>

  <!-- Thông số sản phẩm -->
  <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-shadow duration-300">
    <h3 class="text-xl font-bold mb-6 text-emerald-700 dark:text-emerald-300 flex items-center gap-3">
      <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
      {{ __('app.product_specifications') }}
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.volume_ml') }} <span class="text-rose-600">*</span>
        </label>
        <input type="number" name="volume_ml" min="1" max="100000" step="1" id="volume_ml" required
           value="{{ old('volume_ml', $product->volume_ml ?? 50) }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
        @error('volume_ml') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.selling_price') }} <span class="text-rose-600">*</span>
        </label>
        <input type="number" name="price" min="0" max="1000000000" step="1000" id="price" required
           value="{{ old('price', $product->price ?? 0) }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
                 placeholder="0">
        @error('price') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.promotion_price') }}
        </label>
        <input type="number" name="sale_price" min="0" max="1000000000" step="1000" id="sale_price"
           value="{{ old('sale_price', $product->sale_price ?? '') }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
                 placeholder="{{ __('app.leave_empty_if_no_promotion') }}">
        @error('sale_price') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>



      {{-- Mã sản phẩm --}}
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.product_code') }} <span class="text-rose-600">*</span></label>
        <input name="sku" value="{{ old('sku', $product->sku ?? '') }}" required
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="{{ __('app.enter_product_code') }}">
        @error('sku')
          <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm">{{ $message }}</span>
          </div>
        @enderror
      </div>
      {{-- Nguồn gốc xuất xứ --}}
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.origin') }}</label>
        <input name="origin" value="{{ old('origin', $product->origin ?? '') }}"
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="{{ __('app.enter_origin') }}">
        @error('origin')
          <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm">{{ $message }}</span>
          </div>
        @enderror
      </div>

      {{-- Thông số sản phẩm --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Tình trạng bán --}}
        <div>
          <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.sale_status') }} <span class="text-rose-600">*</span></label>
          <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
            <option value="1" @selected(old('status', $product->status ?? 1)==1) class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.on_sale') }}</option>
            <option value="0" @selected(old('status', $product->status ?? 1)==0) class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.hidden') }}</option>
          </select>
          @error('status')
            <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
              <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              <span class="text-sm">{{ $message }}</span>
            </div>
          @enderror
        </div>
        {{-- Nồng độ --}}
        <div>
          <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.concentration') }} <span class="text-rose-600">*</span></label>
          <select name="concentration" required class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
            <option value="EDC" @selected(old('concentration', $product->concentration ?? '')==='EDC') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">EDC</option>
            <option value="EDT" @selected(old('concentration', $product->concentration ?? '')==='EDT') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">EDT</option>
            <option value="EDP" @selected(old('concentration', $product->concentration ?? '')==='EDP') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">EDP</option>
            <option value="Parfum" @selected(old('concentration', $product->concentration ?? '')==='Parfum') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Parfum</option>
            <option value="Extrait" @selected(old('concentration', $product->concentration ?? '')==='Extrait') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Extrait</option>
          </select>
          @error('concentration')
            <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
              <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              <span class="text-sm">{{ $message }}</span>
            </div>
          @enderror
        </div>
        {{-- Số lượng tồn kho --}}
        <div>
          <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.stock_quantity') }} <span class="text-rose-600">*</span></label>
          <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" max="100000" step="1" required
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
                 placeholder="{{ __('app.enter_stock_quantity') }}">
          @error('stock')
            <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
              <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              <span class="text-sm">{{ $message }}</span>
            </div>
          @enderror
        </div>
      </div>



      {{-- Product Metrics --}}
      <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">
          {{ __('app.product_statistics') }}
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.view_count') }}</label>
            <input type="number" name="views_count" value="{{ old('views_count', $product->views_count ?? 0) }}" min="0" max="100000000" step="1"
                   id="views_count"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
          </div>
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">{{ __('app.sold_count') }}</label>
            <input type="number" name="sold_count" value="{{ old('sold_count', $product->sold_count ?? 0) }}" min="0" max="100000000" step="1"
                   id="sold_count"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chọn danh mục cho sản phẩm -->
  <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-shadow duration-300 mt-8">
    <h3 class="text-xl font-bold mb-6 text-indigo-700 dark:text-indigo-300 flex items-center gap-3">
      <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
      {{ __('app.category_information') }}
    </h3>
    
    <div class="space-y-6">
      <!-- Danh mục sản phẩm -->
      <div>
        <label class="block text-sm font-medium mb-3 text-slate-700 dark:text-slate-300">
          {{ __('app.select_categories') }} <span class="text-slate-500 text-xs">({{ __('app.optional') }})</span>
        </label>
        <select name="category_ids[]" multiple
                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 min-h-[120px]">
          @foreach($categories as $id => $name)
            <option value="{{ $id }}" 
                    @selected(in_array($id, old('category_ids', isset($product) && $product->exists ? $product->categories->pluck('id')->toArray() : []))) 
                    class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 py-2">
              {{ $name }}
            </option>
          @endforeach
        </select>
        <p class="text-xs text-slate-500 mt-1">{{ __('app.hold_ctrl_to_select_multiple') }}</p>
        @error('category_ids')
          <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm">{{ $message }}</span>
          </div>
        @enderror
      </div>

      <!-- Cài đặt hiển thị -->
      <div>
        <h4 class="text-lg font-semibold mb-4 text-slate-800 dark:text-slate-200">{{ __('app.display_settings') }}</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Nổi bật -->
          <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition group">
            <input type="checkbox" name="is_featured" value="1"
                  @checked(old('is_featured', isset($product) ? $product->is_featured : false))
                  class="hidden peer">

            <div class="relative w-6 h-6 flex items-center justify-center rounded-md border border-slate-300 dark:border-slate-600 
                        bg-white dark:bg-slate-700 transition-all duration-300 
                        peer-checked:bg-gradient-to-r peer-checked:from-yellow-400 peer-checked:to-amber-500 peer-checked:border-yellow-500">
              <svg class="w-4 h-4 text-white opacity-0 scale-50 transition-all duration-200 peer-checked:opacity-100 peer-checked:scale-100" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
              </svg>
            </div>

            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
              {{ __('app.featured') }}
            </span>
          </label>

          <!-- Bán chạy -->
          <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition group">
            <input type="checkbox" name="is_best_seller" value="1"
                  @checked(old('is_best_seller', isset($product) ? $product->is_best_seller : false))
                  class="hidden peer">

            <div class="relative w-6 h-6 flex items-center justify-center rounded-md border border-slate-300 dark:border-slate-600 
                        bg-white dark:bg-slate-700 transition-all duration-300 
                        peer-checked:bg-gradient-to-r peer-checked:from-emerald-500 peer-checked:to-teal-500 peer-checked:border-emerald-500">
              <svg class="w-4 h-4 text-white opacity-0 scale-50 transition-all duration-200 peer-checked:opacity-100 peer-checked:scale-100" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
              </svg>
            </div>

            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
              {{ __('app.best_seller') }}
            </span>
          </label>

          <!-- Hàng mới -->
          <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition group">
            <input type="checkbox" name="is_new" value="1"
                  @checked(old('is_new', isset($product) ? $product->is_new : false))
                  class="hidden peer">

            <div class="relative w-6 h-6 flex items-center justify-center rounded-md border border-slate-300 dark:border-slate-600 
                        bg-white dark:bg-slate-700 transition-all duration-300 
                        peer-checked:bg-gradient-to-r peer-checked:from-blue-500 peer-checked:to-indigo-500 peer-checked:border-blue-500">
              <svg class="w-4 h-4 text-white opacity-0 scale-50 transition-all duration-200 peer-checked:opacity-100 peer-checked:scale-100" 
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
              </svg>
            </div>

            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
              {{ __('app.new_arrivals') }}
            </span>
          </label>
        </div>
      </div>
    </div>
  </div>

  <!-- Mô tả sản phẩm -->
  <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-shadow duration-300">
    <h3 class="text-xl font-bold mb-6 text-brand-700 dark:text-brand-300 flex items-center gap-3">
      <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
      {{ __('app.product_description') }}
    </h3>
    
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.short_description') }}
        </label>
        <textarea name="short_desc" rows="3" id="short_desc"
                  class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 resize-none"
                  placeholder="{{ __('app.enter_short_description') }}">{{ old('short_desc', $product->short_desc ?? '') }}</textarea>
        @error('short_desc') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

      <!-- English Short Description Field -->
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300 flex items-center gap-2">
          {{ __('app.short_description_english') }}
          <button type="button" id="translate-short-desc-btn" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-md transition-colors">
            🌐 {{ __('app.auto_translate') }}
          </button>
        </label>
        <textarea name="short_desc_en" rows="3" id="short_desc_en"
                  class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 resize-none"
                  placeholder="Short product description in English...">{{ old('short_desc_en', $product->short_desc_en ?? '') }}</textarea>
        @error('short_desc_en') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          {{ __('app.detailed_description') }}
        </label>
        <textarea name="description" rows="6" id="description"
                  class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 resize-none"
                  placeholder="{{ __('app.enter_detailed_description') }}">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
      </div>

      <!-- English Description Field -->
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300 flex items-center gap-2">
          {{ __('app.detailed_description_english') }}
          <button type="button" id="translate-desc-btn" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-md transition-colors">
            🌐 {{ __('app.auto_translate') }}
          </button>
        </label>
        <textarea name="description_en" rows="6" id="description_en"
                  class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 resize-none"
                  placeholder="Detailed product description in English...">{{ old('description_en', $product->description_en ?? '') }}</textarea>
        @error('description_en') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
      </div>
    </div>
  </div>

  <!-- Ảnh sản phẩm -->
  <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-3xl p-8 shadow-lg border border-white/30 dark:border-white/10 hover:shadow-xl transition-all duration-300">
    <h3 class="text-2xl font-bold mb-6 text-slate-900 dark:text-slate-100 flex items-center gap-3">
      <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
      </div>
      {{ __('app.product_images') }}
    </h3>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Ảnh đại diện -->
      <div>
        <label class="block text-sm font-medium mb-3 text-slate-700 dark:text-slate-300">
          {{ __('app.main_image') }} <span class="text-rose-600">*</span>
        </label>
        <div class="flex items-center justify-center">
          <div class="relative aspect-square w-64">
            <div class="w-full h-full rounded-xl overflow-hidden border-2 border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-700">
              @php
                $imageUrl = null;
                if (old('main_image')) {
                  $imageUrl = asset('images/product-placeholder.png');
                } elseif (isset($product) && $product->exists && $product->main_image_url) {
                  $imageUrl = $product->main_image_url;
                }
              @endphp
              @if($imageUrl)
                <img id="main-image-preview" src="{{ $imageUrl }}" 
                     alt="Ảnh đại diện"
                     class="w-full h-full object-cover">
              @else
                <div id="main-image-preview" class="w-full h-full flex items-center justify-center text-slate-400">
                  <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              @endif
            </div>
            
            <!-- Upload overlay -->
            <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-xl flex items-center justify-center cursor-pointer"
                 onclick="document.getElementById('main_image').click()">
              <div class="text-center text-white">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <p class="text-sm font-medium">Chọn ảnh</p>
              </div>
            </div>
            
            <input type="file" name="main_image" id="main_image" accept="image/*" 
                   onchange="previewMainImage(this)"
                   class="hidden">
          </div>
        </div>
        @error('main_image') <p class="text-rose-600 text-sm mt-2 text-center">{{ $message }}</p> @enderror
      </div>

      <!-- Ảnh phụ trưng bày -->
      <div>
        <label class="block text-sm font-medium mb-3 text-slate-700 dark:text-slate-300">
          {{ __('app.gallery_images') }}
        </label>
        <div class="flex items-center justify-center">
          <div class="relative aspect-square w-64">
            <input type="file" 
                   id="gallery-images" 
                   name="gallery_images[]" 
                   multiple 
                   accept="image/*"
                   onchange="handleGalleryUpload(this)"
                   class="hidden">
            
            <div id="gallery-drop-zone" 
                 onclick="document.getElementById('gallery-images').click()"
                 class="w-full h-full group relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl text-center cursor-pointer transition-all duration-300 hover:border-brand-500 hover:bg-brand-50/50 dark:hover:bg-brand-900/20 backdrop-blur-sm bg-white/50 dark:bg-slate-800/30 flex items-center justify-center">
              
              <div class="text-center">
                <div class="p-4 rounded-full bg-brand-100 dark:bg-brand-900/30 group-hover:bg-brand-200 dark:group-hover:bg-brand-800/40 transition-colors mx-auto mb-3 w-fit">
                  <svg class="w-8 h-8 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                  </svg>
                </div>
                <p class="text-lg font-semibold text-slate-900 dark:text-slate-100 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                  {{ __('app.choose_gallery_images') }}
                </p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                  {{ __('app.can_choose_multiple_images') }}
                </p>
              </div>
            </div>
            
            <!-- Upload Status (Hidden, for JS use) -->
            <div id="gallery-upload-status" class="hidden mt-4 text-sm text-center"></div>
          </div>
        </div>
      </div>
    </div>

      <!-- Image Preview Area - ngay dưới gallery upload -->
      <div id="image-preview-area" class="hidden mt-6">
        <h5 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-4 flex items-center gap-2 justify-center">
          <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
          {{ __('app.selected_images_not_saved') }}
        </h5>
        <div id="preview-images" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6"></div>
        <div class="flex gap-3 justify-center">

        </div>
      </div>
    </div>
    
    <!-- Ảnh phụ hiện tại -->
    @if(isset($product) && $product->exists && $product->images->count())
      <div class="mt-8 p-6 bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-2xl border border-green-200/50 dark:border-green-700/50">
        <div class="flex items-center justify-between mb-4">
          <h5 class="text-lg font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ __('app.current_gallery') }} ({{ $product->images->count() }} {{ __('app.images_count') }})
          </h5>
          <div class="text-xs text-slate-500 dark:text-slate-400 bg-white/50 dark:bg-slate-800/50 px-2 py-1 rounded-full">
            {{ __('app.hover_to_delete_image') }}
          </div>
        </div>
        
        <div id="current-gallery" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
          @foreach($product->images as $image)
            <div class="relative group backdrop-blur-sm bg-white/60 dark:bg-slate-800/60 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105" data-image-id="{{ $image->id }}">
              <!-- Image -->
              <div class="aspect-square overflow-hidden">
                <img src="{{ $image->image_url }}" 
                     alt="{{ $image->alt_text ?? 'Ảnh sản phẩm' }}"
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
              </div>
              
              <!-- Action Overlay - Chỉ giữ nút xóa -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                <div class="absolute top-2 right-2">
                  <button type="button" onclick="deleteImage({{ $image->id }})" 
                          class="p-2 bg-rose-600/90 hover:bg-rose-700 text-white rounded-full transition-all duration-200 hover:scale-110 shadow-lg" 
                          title="{{ __('app.delete_image') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @elseif(isset($product) && $product->exists)
      <!-- Empty State cho sản phẩm đã tạo -->
      <div class="mt-8 p-6 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border border-amber-200/50 dark:border-amber-700/50 text-center">
        <div class="flex flex-col items-center justify-center space-y-4">
          <div class="p-4 rounded-full bg-amber-100 dark:bg-amber-900/30">
            <svg class="w-12 h-12 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          
          <div>
            <h6 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">
              {{ __('app.no_gallery_images') }}
            </h6>
            <p class="text-sm text-slate-500 dark:text-slate-400">
              {{ __('app.add_images_for_customer_view') }}
            </p>
          </div>
          
          <button type="button" onclick="openImageUpload()" 
                  class="mt-4 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
            <span class="flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              {{ __('app.add_first_image') }}
            </span>
          </button>
        </div>
      </div>
    @endif
    </div>
  </div>
</div>
<!-- Nút submit động theo context -->
<div class="flex items-center justify-end pt-10">
  @if(isset($product) && $product->exists)
    <!-- Trang sửa sản phẩm -->
    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
      {{ __('app.update_product') }}
    </button>
  @else
    <!-- Trang thêm sản phẩm -->
    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
      {{ __('app.add_product') }}
    </button>
  @endif
</div>

<!-- Modal upload ảnh -->
<div id="image-upload-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="backdrop-blur-md bg-white/90 dark:bg-slate-800/90 rounded-3xl p-8 w-full max-w-lg shadow-2xl border border-white/50 dark:border-slate-700/50">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.add_images_to_gallery') }}</h3>
        </div>
        <button type="button" onclick="closeImageUpload()" class="w-10 h-10 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-xl flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition-all duration-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <div id="image-upload-form">
        @csrf
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
              {{ __('app.select_images') }}
            </label>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ __('app.can_select_multiple_images') }}</p>
          </div>

          <!-- Thông báo về ảnh chính -->
          <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
            <div class="flex items-start gap-2">
              <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium mb-1">{{ __('app.note_about_main_image') }}</p>
                <ul class="text-xs space-y-1">
                  <li>• {{ __('app.first_image_becomes_main') }}</li>
                  <li>• {{ __('app.current_main_image_wont_change') }}</li>
                  <li>• {{ __('app.can_change_main_image_after_upload') }}</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="flex gap-3">
            <button type="button" onclick="uploadImages()" class="group relative flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
              <!-- Shimmer effect -->
              <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                {{ __('app.upload_images') }}
              </span>
            </button>
            <button type="button" onclick="closeImageUpload()" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200">
              {{ __('app.cancel') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
/* Ẩn spin button mặc định */
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@endpush
@push('scripts')
<script>
function customSpin(fieldId, step) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  let currentValue = field.value === '' ? 0 : parseInt(field.value);
  if (isNaN(currentValue)) currentValue = 0;
  let newValue = currentValue + step;
  if (field.hasAttribute('min')) {
    const min = parseInt(field.getAttribute('min'));
    if (!isNaN(min)) newValue = Math.max(min, newValue);
  }
  if (field.hasAttribute('max')) {
    const max = parseInt(field.getAttribute('max'));
    if (!isNaN(max)) newValue = Math.min(max, newValue);
  }
  field.value = newValue;
  field.dispatchEvent(new Event('input', { bubbles: true }));
  field.dispatchEvent(new Event('change', { bubbles: true }));
}

// Handle gallery upload when files are selected - with immediate preview
function handleGalleryUpload(input) {
  console.log('Gallery files selected:', input.files.length);
  
  if (!input.files || input.files.length === 0) {
    hideImagePreview();
    return;
  }
  
  // Validate and show preview immediately
  const maxSize = 4 * 1024 * 1024; // 4MB
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
  const validFiles = [];
  const invalidFiles = [];
  
  Array.from(input.files).forEach((file, index) => {
    if (file.size <= maxSize && allowedTypes.includes(file.type)) {
      validFiles.push(file);
    } else {
      invalidFiles.push(file.name);
    }
  });
  
  if (validFiles.length > 0) {
    showImagePreview(validFiles);
    
    // Show status message
    const statusDiv = document.getElementById('gallery-upload-status');
    if (statusDiv) {
      let statusMessage = `✅ Đã chọn ${validFiles.length} ảnh hợp lệ`;
      if (invalidFiles.length > 0) {
        statusMessage += `<br>❌ ${invalidFiles.length} ảnh không hợp lệ: ${invalidFiles.join(', ')}`;
      }
      statusMessage += '<br><small class="text-blue-600">💡 Ảnh sẽ được lưu khi bạn lưu sản phẩm</small>';
      
      statusDiv.innerHTML = statusMessage;
      statusDiv.className = 'mt-4 text-sm text-center';
      statusDiv.classList.remove('hidden');
    }
  } else {
    hideImagePreview();
    alert('Không có ảnh hợp lệ. Vui lòng chọn ảnh JPG, PNG, WEBP dưới 4MB.');
  }
}

// Show image preview immediately
function showImagePreview(files) {
  const previewArea = document.getElementById('image-preview-area');
  const previewContainer = document.getElementById('preview-images');
  
  // Clear previous preview
  previewContainer.innerHTML = '';
  
  files.forEach((file, index) => {
    const reader = new FileReader();
    reader.onload = function(e) {
      const previewItem = document.createElement('div');
      previewItem.className = 'relative group backdrop-blur-sm bg-white/60 dark:bg-slate-800/60 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105';
      previewItem.innerHTML = `
        <div class="aspect-square overflow-hidden">
          <img src="${e.target.result}" 
               alt="Preview ${index + 1}"
               class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
        </div>
        <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-semibold shadow-lg">
          ${index + 1}
        </div>
        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
          <button type="button" onclick="removePreviewImage(${index})" 
                  class="p-1 bg-rose-600/90 hover:bg-rose-700 text-white rounded-full transition-colors shadow-lg">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div class="absolute bottom-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
          ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
        </div>
        <div class="absolute bottom-2 right-2 bg-green-600/90 text-white text-xs px-2 py-1 rounded">
          ${(file.size / 1024 / 1024).toFixed(1)}MB
        </div>
      `;
      previewContainer.appendChild(previewItem);
    };
    reader.readAsDataURL(file);
  });
  
  // Show preview area with improved styling
  previewArea.classList.remove('hidden');
  previewArea.className = 'mt-6 p-6 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl border border-blue-200/50 dark:border-blue-700/50';
}

// Hide image preview
function hideImagePreview() {
  const previewArea = document.getElementById('image-preview-area');
  previewArea.classList.add('hidden');
}

// Clear image preview
function clearImagePreview() {
  const input = document.getElementById('gallery-images');
  input.value = '';
  hideImagePreview();
}

// Remove individual preview image
function removePreviewImage(index) {
  const input = document.getElementById('gallery-images');
  const files = Array.from(input.files);
  
  // Remove file from array
  files.splice(index, 1);
  
  // Create new FileList
  const dt = new DataTransfer();
  files.forEach(file => dt.items.add(file));
  input.files = dt.files;
  
  // Update preview
  if (files.length > 0) {
    showImagePreview(files);
  } else {
    hideImagePreview();
  }
}



// Preview main image when selected - Simple preview without cropping
function previewMainImage(input) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const reader = new FileReader();
    
    reader.onload = function(e) {
      const preview = document.getElementById('main-image-preview');
      if (preview) {
        if (preview.tagName === 'IMG') {
          preview.src = e.target.result;
        } else {
          preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-xl">`;
        }
      }
    };
    
    reader.readAsDataURL(file);
  }
}

// Simple image preview functions - No complex cropping

// Clear gallery files
function clearGalleryFiles() {
  const input = document.getElementById('gallery-images');
  const statusDiv = document.getElementById('gallery-upload-status');
  
  if (input) {
    input.value = '';
  }
  
  if (statusDiv) {
    statusDiv.textContent = '';
  }
}

// Upload gallery images
async function uploadGalleryImages(files) {
  const statusDiv = document.getElementById('gallery-upload-status');
  const productId = {{ isset($product) && $product->exists ? $product->id : 'null' }};
  
  statusDiv.textContent = 'Đang upload...';
  
  try {
    // Validate files
    const maxSize = 4 * 1024 * 1024; // 4MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      
      if (file.size > maxSize) {
        alert(`Ảnh "${file.name}" quá lớn. Kích thước tối đa: 4MB`);
        statusDiv.textContent = 'Upload bị hủy';
        return;
      }
      
      if (!allowedTypes.includes(file.type)) {
        alert(`Ảnh "${file.name}" không đúng định dạng. Chỉ chấp nhận: JPG, PNG, WEBP`);
        statusDiv.textContent = 'Upload bị hủy';
        return;
      }
    }
    
    // Get CSRF token
    const csrfToken = document.querySelector('input[name="_token"]');
    if (!csrfToken) {
      throw new Error('CSRF token không tìm thấy');
    }
    
    // Create FormData
    const formData = new FormData();
    
    // Add files - sửa để đúng với validation
    Array.from(files).forEach(file => {
      formData.append('images[]', file);
    });
    
    // Add CSRF token
    formData.append('_token', csrfToken.value);
    
    // Upload
    const response = await fetch(`/admin/products/${productId}/images`, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    });
    
    const data = await response.json();
    
    if (data.success) {
      // Hide preview area
      hideImagePreview();
      
      // Reset file input
      document.getElementById('gallery-images').value = '';
      
      // Show success message briefly
      const successDiv = document.createElement('div');
      successDiv.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg z-50';
      successDiv.textContent = `Đã upload ${files.length} ảnh thành công!`;
      document.body.appendChild(successDiv);
      
      // Remove success message and reload
      setTimeout(() => {
        document.body.removeChild(successDiv);
        location.reload();
      }, 2000);
      
    } else {
      throw new Error(data.message || 'Upload thất bại');
    }
    
  } catch (error) {
    console.error('Upload error:', error);
    statusDiv.textContent = `Lỗi: ${error.message}`;
    statusDiv.className = 'text-sm text-red-600 dark:text-red-400';
  }
}

// Save product and upload gallery (for create mode)
async function saveProductAndUploadGallery(files) {
  try {
    const statusDiv = document.getElementById('gallery-upload-status');
    statusDiv.textContent = 'Đang lưu sản phẩm...';
    
    // Save product first using existing function
    await saveProductAndContinue();
    
    // After redirect, the files will be lost, so we'll handle this in the next page load
    // For now, just show message
    statusDiv.textContent = 'Sản phẩm sẽ được lưu và chuyển trang để upload ảnh';
    
  } catch (error) {
    console.error('Save and upload error:', error);
    document.getElementById('gallery-upload-status').textContent = `Lỗi: ${error.message}`;
  }
}

// Gallery functions
function openImageUpload() {
  console.log('Opening image upload modal...');
  const modal = document.getElementById('image-upload-modal');
  if (modal) {
    modal.classList.remove('hidden');
    
    // Focus on file input after a short delay
    setTimeout(() => {
      const fileInput = modal.querySelector('input[type="file"]');
      if (fileInput) {
        fileInput.focus();
      }
    }, 100);
  } else {
    console.error('Modal not found!');
    alert('Lỗi: Không tìm thấy modal upload. Vui lòng refresh trang.');
  }
}

function closeImageUpload() {
  const modal = document.getElementById('image-upload-modal');
  const form = document.getElementById('image-upload-form');
  
  if (modal) {
    modal.classList.add('hidden');
  }
  
  if (form) {
    if (typeof form.reset === 'function') {
      form.reset();
    } else {
      const fileInput = form.querySelector('input[type="file"][name="images[]"]');
      if (fileInput) {
        fileInput.value = '';
      }
    }
  }
}

// Handle image upload
async function uploadImages() {
  try {
    // Kiểm tra xem có phải đang edit sản phẩm không
    const productId = {{ isset($product) && $product->exists ? $product->id : 'null' }};
    const isEditMode = {{ isset($product) && $product->exists ? 'true' : 'false' }};
    
    if (!isEditMode) {
      // Nếu đang tạo mới, cần tạo sản phẩm trước
      const shouldCreateFirst = confirm('Để thêm ảnh phụ, cần tạo sản phẩm trước. Bạn có muốn lưu thông tin sản phẩm và tiếp tục thêm ảnh không?');
      if (!shouldCreateFirst) {
        closeImageUpload();
        return;
      }
      
      // Tự động submit form để tạo sản phẩm
      await saveProductAndContinue();
      return;
    }

    const fileInput = document.querySelector('#image-upload-modal input[name="images[]"]');
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
      alert('Vui lòng chọn ít nhất một ảnh để upload');
      return;
    }

    // Validate files before upload
    const files = Array.from(fileInput.files);
    const maxSize = 4 * 1024 * 1024; // 4MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      
      // Kiểm tra kích thước
      if (file.size > maxSize) {
        alert(`Ảnh thứ ${i + 1} (${file.name}) quá lớn. Kích thước tối đa: 4MB`);
        return;
      }
      
      // Kiểm tra định dạng
      if (!allowedTypes.includes(file.type)) {
        alert(`Ảnh thứ ${i + 1} (${file.name}) không đúng định dạng. Chỉ chấp nhận: JPG, PNG, WEBP`);
        return;
      }
    }

    // Get CSRF token from main form
    const mainForm = document.querySelector('form[method="POST"]');
    const csrfToken = mainForm ? mainForm.querySelector('input[name="_token"]') : null;
    if (!csrfToken || !csrfToken.value) {
      alert('Lỗi: CSRF token không hợp lệ');
      return;
    }

    // Disable upload button to prevent double submission
    const uploadBtn = document.querySelector('button[onclick="uploadImages()"]');
    const originalText = uploadBtn.textContent;
    uploadBtn.disabled = true;
    uploadBtn.textContent = 'Đang upload...';

    // Create FormData
    const formData = new FormData();
    
    // Add files
    for (let i = 0; i < fileInput.files.length; i++) {
      formData.append('images[]', fileInput.files[i]);
      console.log('Adding file:', fileInput.files[i].name, 'Size:', fileInput.files[i].size, 'Type:', fileInput.files[i].type);
    }
    
    // Add CSRF token
    formData.append('_token', csrfToken.value);

    console.log('Uploading to:', `/admin/products/${productId}/images`);
    console.log('Files count:', fileInput.files.length);
    console.log('CSRF token:', csrfToken.value);

    // Make the fetch request
    fetch(`/admin/products/${productId}/images`, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        let message = data.message;
        if (data.errors && data.errors.length > 0) {
          message += '\n\nMột số ảnh bị lỗi:\n' + data.errors.join('\n');
        }
        alert(message);
        closeImageUpload();
        location.reload();
      } else {
        let errorMessage = data.message || 'Không xác định';
        if (data.errors) {
          // Hiển thị lỗi validation chi tiết
          const errorDetails = [];
          Object.keys(data.errors).forEach(key => {
            if (Array.isArray(data.errors[key])) {
              errorDetails.push(`${key}: ${data.errors[key].join(', ')}`);
            } else {
              errorDetails.push(`${key}: ${data.errors[key]}`);
            }
          });
          if (errorDetails.length > 0) {
            errorMessage += '\n\nChi tiết lỗi:\n' + errorDetails.join('\n');
          }
        }
        alert('Lỗi: ' + errorMessage);
      }
    })
    .catch(error => {
      console.error('Upload error:', error);
      let errorMessage = 'Có lỗi xảy ra khi upload ảnh';
      if (error.message) {
        errorMessage += ': ' + error.message;
      }
      alert(errorMessage);
    })
    .finally(() => {
      // Re-enable upload button
      if (uploadBtn) {
        uploadBtn.disabled = false;
        uploadBtn.textContent = originalText;
      }
    });

  } catch (error) {
    alert('Lỗi nghiêm trọng: ' + error.message);
  }
}

// Function to save product and continue with image upload
async function saveProductAndContinue() {
  try {
    // Validate required fields first
    const requiredFields = [
      { name: 'name', label: 'Tên sản phẩm' },
      { name: 'price', label: 'Giá' },
      { name: 'description', label: 'Mô tả' }
    ];
    
    for (const field of requiredFields) {
      const input = document.querySelector(`[name="${field.name}"]`);
      if (!input || !input.value.trim()) {
        alert(`Vui lòng nhập ${field.label} trước khi thêm ảnh`);
        input?.focus();
        return;
      }
    }
    
    // Get the main form
    const mainForm = document.querySelector('form[method="POST"]');
    if (!mainForm) {
      alert('Không tìm thấy form sản phẩm');
      return;
    }
    
    // Show loading state
    const saveButton = document.querySelector('button[type="submit"]');
    const originalButtonText = saveButton ? saveButton.textContent : '';
    if (saveButton) {
      saveButton.disabled = true;
      saveButton.textContent = 'Đang lưu sản phẩm...';
    }
    
    // Create FormData from main form
    const formData = new FormData(mainForm);
    
    // Get CSRF token
    const csrfToken = mainForm.querySelector('input[name="_token"]');
    if (!csrfToken) {
      alert('Lỗi: CSRF token không hợp lệ');
      return;
    }
    
    // Submit the form via AJAX
    const response = await fetch(mainForm.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    });
    
    const data = await response.json();
    
    if (response.ok && data.success) {
      alert('Sản phẩm đã được tạo thành công! Bạn sẽ được chuyển đến trang edit để thêm ảnh.');
      // Redirect to edit page
      window.location.href = data.redirect_url || `/admin/products/${data.product_id}/edit`;
    } else {
      // Handle validation errors
      let errorMessage = data.message || 'Có lỗi xảy ra khi tạo sản phẩm';
      if (data.errors) {
        const errorDetails = [];
        Object.keys(data.errors).forEach(key => {
          if (Array.isArray(data.errors[key])) {
            errorDetails.push(`${key}: ${data.errors[key].join(', ')}`);
          } else {
            errorDetails.push(`${key}: ${data.errors[key]}`);
          }
        });
        if (errorDetails.length > 0) {
          errorMessage += '\n\nChi tiết lỗi:\n' + errorDetails.join('\n');
        }
      }
      alert(errorMessage);
    }
    
  } catch (error) {
    console.error('Save product error:', error);
    alert('Có lỗi xảy ra khi lưu sản phẩm: ' + error.message);
  } finally {
    // Restore button state
    const saveButton = document.querySelector('button[type="submit"]');
    if (saveButton) {
      saveButton.disabled = false;
      saveButton.textContent = originalButtonText;
    }
  }
}



function deleteImage(imageId) {
  if (!confirm('{{ __("app.confirm_delete_image") }}')) {
    return;
  }
  
  try {
    const csrfToken = document.querySelector('input[name="_token"]');
    if (!csrfToken) {
      alert('Không tìm thấy CSRF token');
      return;
    }
    
    fetch(`/admin/product-images/${imageId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload(); // Reload to show updated gallery
      } else {
        alert('Lỗi: ' + (data.message || '{{ __("app.cannot_delete_image") }}'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('{{ __("app.error_deleting_image") }}');
    });
  } catch (error) {
    console.error('Error:', error);
    alert('Có lỗi xảy ra: ' + error.message);
  }
}

// Add drag & drop functionality
document.addEventListener('DOMContentLoaded', function() {
  const dropZone = document.getElementById('gallery-drop-zone');
  const fileInput = document.getElementById('gallery-images');
  
  if (dropZone && fileInput) {
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, preventDefaults, false);
      document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }
    
    function highlight(e) {
      dropZone.classList.add('border-brand-500', 'bg-brand-50/50', 'dark:bg-brand-900/20');
    }
    
    function unhighlight(e) {
      dropZone.classList.remove('border-brand-500', 'bg-brand-50/50', 'dark:bg-brand-900/20');
    }
    
    function handleDrop(e) {
      const dt = e.dataTransfer;
      const files = dt.files;
      
      fileInput.files = files;
      handleGalleryUpload(fileInput);
    }
  }
});
</script>
@endpush

<!-- Close the main containers -->
  </div>
</div>

@push('styles')
<style>
/* Animations for the modern form */
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}

@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}

/* Modern scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.3);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 0, 0, 0.5);
}

/* Drag and drop enhancements */
.drag-over {
  border-color: #3B82F6 !important;
  background-color: rgba(59, 130, 246, 0.1) !important;
}
</style>
@endpush

@push('scripts')
<script>
// Auto Translation Functions
async function translateText(text, targetLang) {
  try {
    const response = await fetch('/api/translation/auto-translate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        text: text,
        target_lang: targetLang
      })
    });

    const data = await response.json();
    
    if (data.success) {
      return data.translated;
    } else {
      throw new Error('Translation failed');
    }
  } catch (error) {
    console.error('Translation error:', error);
    alert('Lỗi dịch văn bản. Vui lòng thử lại.');
    return text;
  }
}

// Auto-translate name
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('translate-name-btn')?.addEventListener('click', async function() {
    const vietnameseName = document.querySelector('input[name="name"]').value;
    
    if (!vietnameseName.trim()) {
      alert('Vui lòng nhập tên sản phẩm tiếng Việt trước.');
      return;
    }

    this.textContent = '🔄 Đang dịch...';
    this.disabled = true;

    try {
      const translatedName = await translateText(vietnameseName, 'en');
      document.getElementById('name_en').value = translatedName;
    } finally {
      this.textContent = '🌐 Auto Translate';
      this.disabled = false;
    }
  });

  // Auto-translate description
  document.getElementById('translate-desc-btn')?.addEventListener('click', async function() {
    const vietnameseDesc = document.getElementById('description').value;
    
    if (!vietnameseDesc.trim()) {
      alert('Vui lòng nhập mô tả tiếng Việt trước.');
      return;
    }

    this.textContent = '🔄 Đang dịch...';
    this.disabled = true;

    try {
      const translatedDesc = await translateText(vietnameseDesc, 'en');
      document.getElementById('description_en').value = translatedDesc;
    } finally {
      this.textContent = '🌐 Auto Translate';
      this.disabled = false;
    }
  });

  // Auto-translate short description
  document.getElementById('translate-short-desc-btn')?.addEventListener('click', async function() {
    const vietnameseShortDesc = document.getElementById('short_desc').value;
    
    if (!vietnameseShortDesc.trim()) {
      alert('Vui lòng nhập mô tả ngắn tiếng Việt trước.');
      return;
    }

    this.textContent = '🔄 Đang dịch...';
    this.disabled = true;

    try {
      const translatedShortDesc = await translateText(vietnameseShortDesc, 'en');
      document.getElementById('short_desc_en').value = translatedShortDesc;
    } finally {
      this.textContent = '🌐 Auto Translate';
      this.disabled = false;
    }
  });
});
</script>
@endpush
