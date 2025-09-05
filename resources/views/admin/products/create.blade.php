@extends('layouts.app')
@section('title', __('app.add_product') . ' - Perfume Luxury')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<div class="relative max-w-4xl mx-auto px-4 py-8">
  <!-- Back Button -->
  <div class="mb-6">
      <a href="{{ route('admin.dashboard') }}" 
         class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
          </svg>
          {{ __('app.back') }}
      </a>
  </div>

  <div class="mb-8">
    <div class="flex flex-col items-center">
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 text-center">{{ __('app.add_product') }}</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2 text-center">{{ __('app.manage_all_products') }}</p>
    </div>
  </div>

  <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @include('admin.products._form', ['product' => $product, 'categories' => $categories])


    </form>
  </div>
</div>
</div>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
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

@push('styles')
<style>
.custom-spin-btns {
  position: absolute;
  right: 0.25rem;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  gap: 1px;
  z-index: 10;
}
.custom-spin-btn {
  width: 1.25rem;
  height: 1.1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  color: #6366f1;
  border-radius: 0.25rem;
  border: none;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  font-size: 0.9rem;
  padding: 0;
}
.custom-spin-btn:hover {
  background: #6366f1;
  color: #fff;
}
.dark .custom-spin-btn {
  background: #1e293b;
  color: #a5b4fc;
}
.dark .custom-spin-btn:hover {
  background: #6366f1;
  color: #fff;
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
</script>
@endpush
