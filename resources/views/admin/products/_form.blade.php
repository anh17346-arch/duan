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
            <h3 class="font-semibold text-lg">Vui lòng kiểm tra lại thông tin</h3>
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
      Thông tin cơ bản
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Danh mục <span class="text-rose-600">*</span>
        </label>
    <select name="category_id" required
                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
      <option value="">-- Chọn danh mục --</option>
      @foreach($categories as $id => $name)
        <option value="{{ $id }}" @selected(old('category_id', optional($product)->category_id) == $id)>
          {{ $name }}
        </option>
      @endforeach
    </select>
        @error('category_id')
  <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
    <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="text-sm">{{ $message }}</span>
  </div>
@enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Tên sản phẩm <span class="text-rose-600">*</span>
        </label>
    <input name="name" value="{{ old('name', $product->name ?? '') }}" required
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="Nhập tên sản phẩm...">
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
          Tên sản phẩm (English) 
          <button type="button" id="translate-name-btn" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-md transition-colors">
            🌐 Auto Translate
          </button>
        </label>
    <input name="name_en" value="{{ old('name_en', $product->name_en ?? '') }}" id="name_en"
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
          Thương hiệu
        </label>
    <input name="brand" value="{{ old('brand', $product->brand ?? '') }}"
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="Nhập thương hiệu...">
        @error('brand')
  <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
    <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="text-sm">{{ $message }}</span>
  </div>
@enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Giới tính <span class="text-rose-600">*</span>
        </label>
    <select name="gender" required
                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
      <option value="male"   @selected(old('gender', $product->gender ?? '')==='male')>Nam</option>
      <option value="female" @selected(old('gender', $product->gender ?? '')==='female')>Nữ</option>
      <option value="unisex" @selected(old('gender', $product->gender ?? 'unisex')==='unisex')>Unisex</option>
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
      Thông số sản phẩm
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Dung tích (ml) <span class="text-rose-600">*</span>
        </label>
        <input type="number" name="volume_ml" min="1" max="100000" step="1" id="volume_ml" required
           value="{{ old('volume_ml', $product->volume_ml ?? 50) }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
        @error('volume_ml') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Giá bán (đ) <span class="text-rose-600">*</span>
        </label>
        <input type="number" name="price" min="0" max="1000000000" step="1000" id="price" required
           value="{{ old('price', $product->price ?? 0) }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
                 placeholder="0">
        @error('price') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Giá khuyến mãi (đ)
        </label>
        <input type="number" name="sale_price" min="0" max="1000000000" step="1000" id="sale_price"
           value="{{ old('sale_price', $product->sale_price ?? '') }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
                 placeholder="Để trống nếu không có">
        @error('sale_price') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

  <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Tồn kho <span class="text-rose-600">*</span>
        </label>
        <input type="number" name="stock" min="0" max="1000000" step="1" id="stock" required
           value="{{ old('stock', $product->stock ?? 0) }}"
                 class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
        @error('stock') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
      </div>

      {{-- Mã sản phẩm --}}
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Mã sản phẩm <span class="text-rose-600">*</span></label>
        <input name="sku" value="{{ old('sku', $product->sku ?? '') }}" required
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="Nhập mã sản phẩm...">
        @error('sku')
          <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm">{{ $message }}</span>
          </div>
        @enderror
      </div>
      {{-- Nguồn gốc xuất xứ --}}
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Nguồn gốc xuất xứ</label>
        <input name="origin" value="{{ old('origin', $product->origin ?? '') }}"
               class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200"
               placeholder="Xuất xứ...">
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
          <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Tình trạng bán <span class="text-rose-600">*</span></label>
          <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
            <option value="1" @selected(old('status', $product->status ?? 1)==1)>Đang bán</option>
            <option value="0" @selected(old('status', $product->status ?? 1)==0)>Tạm ngừng</option>
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
          <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Nồng độ <span class="text-rose-600">*</span></label>
          <select name="concentration" required class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
            <option value="EDC" @selected(old('concentration', $product->concentration ?? '')==='EDC')>EDC</option>
            <option value="EDT" @selected(old('concentration', $product->concentration ?? '')==='EDT')>EDT</option>
            <option value="EDP" @selected(old('concentration', $product->concentration ?? '')==='EDP')>EDP</option>
            <option value="Parfum" @selected(old('concentration', $product->concentration ?? '')==='Parfum')>Parfum</option>
            <option value="Extrait" @selected(old('concentration', $product->concentration ?? '')==='Extrait')>Extrait</option>
          </select>
          @error('concentration')
            <div class="flex items-center gap-2 mt-2 px-3 py-2 bg-rose-50 dark:bg-rose-900/40 border border-rose-200 dark:border-rose-700 text-rose-700 dark:text-rose-200 rounded-lg shadow-sm animate-fade-in">
              <svg class="w-5 h-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              <span class="text-sm">{{ $message }}</span>
            </div>
          @enderror
        </div>
      </div>

      {{-- Sale Dates --}}
      <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">
          Thời gian giảm giá
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Ngày bắt đầu giảm giá</label>
            <input type="datetime-local" name="sale_start_date" 
                   value="{{ old('sale_start_date', isset($product) && $product->sale_start_date ? $product->sale_start_date->format('Y-m-d\TH:i') : '') }}"
                   class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-colors duration-200">
          </div>
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Ngày kết thúc giảm giá</label>
            <input type="datetime-local" name="sale_end_date" 
                   value="{{ old('sale_end_date', isset($product) && $product->sale_end_date ? $product->sale_end_date->format('Y-m-d\TH:i') : '') }}"
                   class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-colors duration-200">
          </div>
        </div>
      </div>

      {{-- Product Metrics --}}
      <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">
          Thống kê sản phẩm
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Số lượt xem</label>
            <input type="number" name="views_count" value="{{ old('views_count', $product->views_count ?? 0) }}" min="0" max="100000000" step="1"
                   id="views_count"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
          </div>
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Số lượng đã bán</label>
            <input type="number" name="sold_count" value="{{ old('sold_count', $product->sold_count ?? 0) }}" min="0" max="100000000" step="1"
                   id="sold_count"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Cài đặt sản phẩm -->
  <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-shadow duration-300 mt-8">
    <h3 class="text-xl font-bold mb-6 text-indigo-700 dark:text-indigo-300 flex items-center gap-3">
      <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Cài đặt sản phẩm
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Sản phẩm nổi bật -->
      <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))
          class="w-5 h-5 text-yellow-500 bg-slate-100 border-slate-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
        <span class="flex items-center gap-2">
          <span class="text-yellow-500">⭐</span>
          <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Nổi bật</span>
        </span>
      </label>
      <!-- Đang giảm giá -->
      <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition">
        <input type="checkbox" name="is_on_sale" value="1" @checked(old('is_on_sale', $product->is_on_sale ?? false))
          class="w-5 h-5 text-rose-500 bg-slate-100 border-slate-300 rounded focus:ring-rose-500 dark:focus:ring-rose-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
        <span class="flex items-center gap-2">
          <span class="text-rose-500">🎉</span>
          <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Đang giảm giá</span>
        </span>
      </label>
      <!-- Bán chạy -->
      <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition">
        <input type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller ?? false))
          class="w-5 h-5 text-emerald-500 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
        <span class="flex items-center gap-2">
          <span class="text-emerald-500">📈</span>
          <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Bán chạy</span>
        </span>
      </label>
      <!-- Hàng mới -->
      <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl shadow hover:shadow-md cursor-pointer transition">
        <input type="checkbox" name="is_new" value="1" @checked(old('is_new', $product->is_new ?? false))
          class="w-5 h-5 text-blue-500 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
        <span class="flex items-center gap-2">
          <span class="text-blue-500">🆕</span>
          <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Hàng mới</span>
        </span>
      </label>
    </div>
  </div>

  <!-- Mô tả sản phẩm -->
  <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-shadow duration-300">
    <h3 class="text-xl font-bold mb-6 text-brand-700 dark:text-brand-300 flex items-center gap-3">
      <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
      Mô tả sản phẩm
    </h3>
    
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Mô tả ngắn
        </label>
        <textarea name="short_desc" rows="3"
                  class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 resize-none"
                  placeholder="Mô tả ngắn gọn về sản phẩm...">{{ old('short_desc', $product->short_desc ?? '') }}</textarea>
        @error('short_desc') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
  </div>

      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">
          Mô tả chi tiết
        </label>
        <textarea name="description" rows="6" id="description"
                  class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200 resize-none"
                  placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
      </div>

      <!-- English Description Field -->
      <div>
        <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300 flex items-center gap-2">
          Mô tả chi tiết (English)
          <button type="button" id="translate-desc-btn" class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-md transition-colors">
            🌐 Auto Translate
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
      Ảnh sản phẩm
    </h3>
    
    <!-- Ảnh đại diện -->
    <div class="mb-8">
      <label class="block text-sm font-medium mb-3 text-slate-700 dark:text-slate-300">
        Ảnh đại diện <span class="text-rose-600">*</span>
      </label>
      <div class="flex items-center justify-center">
        <div class="relative aspect-square w-64">
          <div class="w-full h-full rounded-xl overflow-hidden border-2 border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-700">
            @php
              $imageUrl = old('main_image') ? asset('images/product-placeholder.png') : ($product->main_image_url ?? null);
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
    
    <!-- Gallery ảnh phụ -->
    <div class="mt-8">
      <label class="block text-sm font-medium mb-3 text-slate-700 dark:text-slate-300">
        Gallery ảnh phụ
      </label>
      <div class="flex items-center justify-center mb-6">
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
                Chọn ảnh gallery
              </p>
              <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Có thể chọn nhiều ảnh
              </p>
            </div>
          </div>
          
          <!-- Upload Status (Hidden, for JS use) -->
          <div id="gallery-upload-status" class="hidden mt-4 text-sm text-center"></div>
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
          Ảnh đã chọn (chưa lưu)
        </h5>
        <div id="preview-images" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6"></div>
        <div class="flex gap-3 justify-center">
          <button type="button" onclick="uploadSelectedImages()" 
                  class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors shadow-lg">
            <span class="flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
              </svg>
              Lưu Ảnh Gallery
            </span>
          </button>
          <button type="button" onclick="clearImagePreview()" 
                  class="px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors">
            Hủy
          </button>
        </div>
      </div>
    </div>
    
    <!-- Gallery hiện tại -->
      
      <!-- Current Gallery Display -->
      @if(isset($product) && $product->exists && $product->images->count())
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <h5 class="text-md font-medium text-slate-700 dark:text-slate-300">
              Gallery Hiện Tại ({{ $product->images->count() }} ảnh)
            </h5>
            <div class="text-xs text-slate-500 dark:text-slate-400">
              Hover để xóa ảnh
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
                            title="Xóa ảnh">
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
      @else
        <!-- Modern Empty State -->
        <div class="text-center py-12 backdrop-blur-sm bg-white/30 dark:bg-slate-800/30 rounded-2xl border border-slate-200/60 dark:border-slate-700">
          <div class="flex flex-col items-center justify-center space-y-4">
            <div class="p-4 rounded-full bg-slate-100 dark:bg-slate-700">
              <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            
            <div>
              <h6 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">
                @if(isset($product) && $product->exists)
                  Chưa có ảnh gallery nào
                @else
                  Gallery sẽ khả dụng sau khi tạo sản phẩm
                @endif
              </h6>
              <p class="text-sm text-slate-500 dark:text-slate-400">
                @if(isset($product) && $product->exists)
                  Thêm ảnh để khách hàng có thể xem chi tiết sản phẩm
                @else
                  Lưu thông tin sản phẩm trước để có thể thêm ảnh gallery
                @endif
              </p>
            </div>
            
            @if(isset($product) && $product->exists)
              <button type="button" onclick="openImageUpload()" 
                      class="mt-4 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-medium transition-colors shadow-lg hover:shadow-xl">
                <span class="flex items-center gap-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                  </svg>
                  Thêm Ảnh Đầu Tiên
                </span>
              </button>
            @endif
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
<!-- Nút lưu sản phẩm ở ngoài cùng, cuối form -->
<div class="flex items-center justify-end pt-10">
  <button type="submit" class="px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
    Lưu lại thông tin sản phẩm
  </button>
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
          <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Thêm ảnh vào gallery</h3>
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
              Chọn ảnh
            </label>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all duration-200">
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Có thể chọn nhiều ảnh cùng lúc</p>
          </div>

          <!-- Thông báo về ảnh chính -->
          <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
            <div class="flex items-start gap-2">
              <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div class="text-sm text-blue-800 dark:text-blue-200">
                <p class="font-medium mb-1">Lưu ý về ảnh chính:</p>
                <ul class="text-xs space-y-1">
                  <li>• Ảnh đầu tiên trong gallery sẽ tự động trở thành ảnh chính</li>
                  <li>• Ảnh chính hiện tại sẽ không bị thay đổi</li>
                  <li>• Bạn có thể thay đổi ảnh chính sau khi upload xong</li>
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
                Upload ảnh
              </span>
            </button>
            <button type="button" onclick="closeImageUpload()" class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200">
              Hủy
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
  
  // Validate and show preview
  const maxSize = 4 * 1024 * 1024; // 4MB
  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
  const validFiles = [];
  
  Array.from(input.files).forEach((file, index) => {
    if (file.size <= maxSize && allowedTypes.includes(file.type)) {
      validFiles.push(file);
    }
  });
  
  if (validFiles.length > 0) {
    showImagePreview(validFiles);
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
      `;
      previewContainer.appendChild(previewItem);
    };
    reader.readAsDataURL(file);
  });
  
  // Show preview area
  previewArea.classList.remove('hidden');
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

// Upload selected images
function uploadSelectedImages() {
  const input = document.getElementById('gallery-images');
  if (!input.files || input.files.length === 0) {
    alert('Không có ảnh nào được chọn');
    return;
  }
  
  // Call the existing upload function
  uploadGalleryImages(input.files);
}

// Preview main image when selected
function previewMainImage(input) {
  if (input.files && input.files[0]) {
    openImageCropper(input.files[0], 'main');
  }
}

// Image Cropper Variables
let currentImage = null;
let cropCanvas = null;
let previewCanvas = null;
let cropType = 'main'; // 'main' or 'gallery'
let imageData = {
  x: 0,
  y: 0,
  scale: 1,
  rotation: 0
};

// Open Image Cropper
function openImageCropper(file, type) {
  cropType = type;
  const modal = document.getElementById('image-cropper-modal');
  cropCanvas = document.getElementById('crop-canvas');
  previewCanvas = document.getElementById('preview-canvas');
  
  const reader = new FileReader();
  reader.onload = function(e) {
    currentImage = new Image();
    currentImage.onload = function() {
      initializeCropper();
      modal.classList.remove('hidden');
    };
    currentImage.src = e.target.result;
  };
  reader.readAsDataURL(file);
}

// Initialize Cropper
function initializeCropper() {
  const ctx = cropCanvas.getContext('2d');
  const previewCtx = previewCanvas.getContext('2d');
  
  // Set canvas size
  cropCanvas.width = 600;
  cropCanvas.height = 400;
  previewCanvas.width = 200;
  previewCanvas.height = 200;
  
  // Reset image data
  imageData = {
    x: cropCanvas.width / 2,
    y: cropCanvas.height / 2,
    scale: Math.min(cropCanvas.width / currentImage.width, cropCanvas.height / currentImage.height),
    rotation: 0
  };
  
  drawImage();
  updatePreview();
  
  // Event listeners
  setupCropperEvents();
}

// Setup Cropper Events
function setupCropperEvents() {
  let isDragging = false;
  let lastX, lastY;
  
  // Mouse events
  cropCanvas.addEventListener('mousedown', (e) => {
    isDragging = true;
    lastX = e.clientX;
    lastY = e.clientY;
  });
  
  cropCanvas.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    
    const deltaX = e.clientX - lastX;
    const deltaY = e.clientY - lastY;
    
    imageData.x += deltaX;
    imageData.y += deltaY;
    
    lastX = e.clientX;
    lastY = e.clientY;
    
    drawImage();
    updatePreview();
  });
  
  cropCanvas.addEventListener('mouseup', () => {
    isDragging = false;
  });
  
  // Wheel zoom
  cropCanvas.addEventListener('wheel', (e) => {
    e.preventDefault();
    const delta = e.deltaY > 0 ? 0.9 : 1.1;
    imageData.scale = Math.max(0.1, Math.min(5, imageData.scale * delta));
    
    // Update slider
    document.getElementById('zoom-slider').value = imageData.scale;
    
    drawImage();
    updatePreview();
  });
  
  // Zoom slider
  document.getElementById('zoom-slider').addEventListener('input', (e) => {
    imageData.scale = parseFloat(e.target.value);
    drawImage();
    updatePreview();
  });
}

// Draw Image on Canvas
function drawImage() {
  const ctx = cropCanvas.getContext('2d');
  ctx.clearRect(0, 0, cropCanvas.width, cropCanvas.height);
  
  ctx.save();
  ctx.translate(imageData.x, imageData.y);
  ctx.rotate(imageData.rotation * Math.PI / 180);
  ctx.scale(imageData.scale, imageData.scale);
  
  const drawWidth = currentImage.width;
  const drawHeight = currentImage.height;
  
  ctx.drawImage(currentImage, -drawWidth/2, -drawHeight/2, drawWidth, drawHeight);
  ctx.restore();
  
  // Draw crop overlay
  drawCropOverlay(ctx);
}

// Draw Crop Overlay
function drawCropOverlay(ctx) {
  // Fixed aspect ratio 1:1 (vuông) để đồng nhất với giao diện
  const aspectRatio = 1;
  
  // Calculate crop area
  const maxSize = Math.min(cropCanvas.width, cropCanvas.height) * 0.8;
  const cropWidth = maxSize;
  const cropHeight = maxSize; // Luôn vuông
  
  const cropX = (cropCanvas.width - cropWidth) / 2;
  const cropY = (cropCanvas.height - cropHeight) / 2;
  
  // Draw overlay
  ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
  ctx.fillRect(0, 0, cropCanvas.width, cropCanvas.height);
  
  // Clear crop area
  ctx.clearRect(cropX, cropY, cropWidth, cropHeight);
  
  // Draw crop border
  ctx.strokeStyle = '#3B82F6';
  ctx.lineWidth = 2;
  ctx.strokeRect(cropX, cropY, cropWidth, cropHeight);
  
  // Store crop area for later use
  cropCanvas.cropArea = { x: cropX, y: cropY, width: cropWidth, height: cropHeight };
}

// Update Preview
function updatePreview() {
  if (!currentImage || !cropCanvas.cropArea) return;
  
  const previewCtx = previewCanvas.getContext('2d');
  const cropArea = cropCanvas.cropArea;
  
  // Create temporary canvas for cropped image
  const tempCanvas = document.createElement('canvas');
  const tempCtx = tempCanvas.getContext('2d');
  
  tempCanvas.width = cropArea.width;
  tempCanvas.height = cropArea.height;
  
  // Draw the cropped portion
  tempCtx.save();
  tempCtx.translate(-cropArea.x + imageData.x, -cropArea.y + imageData.y);
  tempCtx.rotate(imageData.rotation * Math.PI / 180);
  tempCtx.scale(imageData.scale, imageData.scale);
  
  tempCtx.drawImage(currentImage, -currentImage.width/2, -currentImage.height/2);
  tempCtx.restore();
  
  // Draw to preview canvas
  previewCtx.clearRect(0, 0, previewCanvas.width, previewCanvas.height);
  previewCtx.drawImage(tempCanvas, 0, 0, previewCanvas.width, previewCanvas.height);
}

// Rotate Image
function rotateImage(degrees) {
  imageData.rotation += degrees;
  drawImage();
  updatePreview();
}

// Apply Crop
function applyCrop() {
  if (!currentImage || !cropCanvas.cropArea) return;
  
  const cropArea = cropCanvas.cropArea;
  
  // Create final canvas
  const finalCanvas = document.createElement('canvas');
  const finalCtx = finalCanvas.getContext('2d');
  
  finalCanvas.width = cropArea.width;
  finalCanvas.height = cropArea.height;
  
  // Draw the cropped image
  finalCtx.save();
  finalCtx.translate(-cropArea.x + imageData.x, -cropArea.y + imageData.y);
  finalCtx.rotate(imageData.rotation * Math.PI / 180);
  finalCtx.scale(imageData.scale, imageData.scale);
  
  finalCtx.drawImage(currentImage, -currentImage.width/2, -currentImage.height/2);
  finalCtx.restore();
  
  // Convert to blob and update preview
  finalCanvas.toBlob((blob) => {
    const url = URL.createObjectURL(blob);
    
    if (cropType === 'main') {
      const preview = document.getElementById('main-image-preview');
      if (preview.tagName === 'IMG') {
        preview.src = url;
      } else {
        preview.innerHTML = `<img src="${url}" alt="Cropped image" class="w-full h-full object-cover">`;
      }
      
      // Create file for form submission
      const file = new File([blob], 'cropped-image.jpg', { type: 'image/jpeg' });
      const dt = new DataTransfer();
      dt.items.add(file);
      document.getElementById('main_image').files = dt.files;
    }
    
    closeCropper();
  }, 'image/jpeg', 0.9);
}

// Close Cropper
function closeCropper() {
  const modal = document.getElementById('image-cropper-modal');
  modal.classList.add('hidden');
  currentImage = null;
}

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
  const productId = {{ $product->id ?? 'null' }};
  
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
    const productId = {{ $product->id ?? 'null' }};
    const isEditMode = {{ isset($product) && $product->id ? 'true' : 'false' }};
    
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
      { name: 'category_id', label: 'Danh mục' },
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
  if (!confirm('Bạn có chắc muốn xóa ảnh này? Hành động này không thể hoàn tác.')) {
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
        alert('Lỗi: ' + (data.message || 'Không thể xóa ảnh'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Có lỗi xảy ra khi xóa ảnh');
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

<!-- Image Cropper Modal -->
<div id="image-cropper-modal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
    <div class="p-6 border-b border-slate-200 dark:border-slate-700">
      <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 flex items-center gap-3">
        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Chỉnh sửa ảnh
      </h3>
      <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Kéo để di chuyển, cuộn chuột để zoom</p>
    </div>
    
    <div class="p-6">
      <div class="flex flex-col lg:flex-row gap-6">
        <!-- Image Canvas -->
        <div class="flex-1">
          <div class="relative bg-slate-100 dark:bg-slate-700 rounded-xl overflow-hidden" style="min-height: 400px;">
            <canvas id="crop-canvas" class="max-w-full max-h-full"></canvas>
          </div>
        </div>
        
        <!-- Controls -->
        <div class="lg:w-80 space-y-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Zoom</label>
            <input type="range" id="zoom-slider" min="0.5" max="3" step="0.1" value="1" 
                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer dark:bg-slate-700">
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Xoay</label>
            <div class="flex gap-2">
              <button type="button" onclick="rotateImage(-90)" 
                      class="flex-1 px-3 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg transition-colors">
                ↺ 90°
              </button>
              <button type="button" onclick="rotateImage(90)" 
                      class="flex-1 px-3 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg transition-colors">
                ↻ 90°
              </button>
            </div>
          </div>
          
          <!-- Preview -->
          <div>
            <label class="block text-sm font-medium mb-2 text-slate-700 dark:text-slate-300">Xem trước</label>
            <div class="aspect-square bg-slate-100 dark:bg-slate-700 rounded-lg overflow-hidden border-2 border-slate-200 dark:border-slate-600">
              <canvas id="preview-canvas" class="w-full h-full"></canvas>
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex flex-col gap-3 pt-4">
            <button type="button" onclick="applyCrop()" 
                    class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors shadow-lg">
              <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Đồng ý thêm ảnh
              </span>
            </button>
            <button type="button" onclick="closeCropper()" 
                    class="w-full px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors">
              Hủy
            </button>
          </div>
        </div>
      </div>
    </div>
    

  </div>
</div>

<!-- Close the main containers -->
  </div>
</div>

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
