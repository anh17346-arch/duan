@extends('layouts.app')

@section('title', __('app.edit_category') . ' - Perfume Luxury')

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

<div class="relative max-w-4xl mx-auto px-4 py-8">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.edit_category') }}</h1>
          <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('app.update_category_info') }} "{{ $category->display_name }}"</p>
  </div>

  <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
      @csrf
      @method('PUT')
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ __('app.category_name_vi') }} <span class="text-rose-500">*</span>
          </label>
          <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                 class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                 placeholder="{{ __('app.enter_vietnamese_name') }}">
          @error('name')
            <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="name_en" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ __('app.category_name_en') }}
          </label>
          <div class="relative">
            <input type="text" id="name_en" name="name_en" value="{{ old('name_en', $category->name_en) }}"
                   class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                   placeholder="{{ __('app.enter_english_name') }}">
            <button type="button" id="translate-name" 
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-brand-600 hover:bg-brand-700 text-white text-xs rounded-lg transition-colors"
                    title="{{ __('app.translate_from_vi_to_en') }}">
              {{ __('app.auto_translate') }}
            </button>
          </div>
          @error('name_en')
            <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ __('app.description_vi') }}
          </label>
          <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"
                    placeholder="{{ __('app.describe_category') }}">{{ old('description', $category->description) }}</textarea>
          @error('description')
            <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="description_en" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ __('app.description_en') }}
          </label>
          <div class="relative">
            <textarea id="description_en" name="description_en" rows="4"
                      class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"
                      placeholder="{{ __('app.describe_category_en') }}">{{ old('description_en', $category->description_en) }}</textarea>
            <button type="button" id="translate-description" 
                    class="absolute right-3 top-3 px-2 py-1 bg-brand-600 hover:bg-brand-700 text-white text-xs rounded-lg transition-colors"
                    title="{{ __('app.translate_from_vi_to_en') }}">
              {{ __('app.auto_translate') }}
            </button>
          </div>
          @error('description_en')
            <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div>
        <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
          {{ __('app.status') }} <span class="text-rose-500">*</span>
        </label>
        <select id="status" name="status" required
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
          <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.active') }}</option>
          <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.hidden') }}</option>
        </select>
        @error('status')
          <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center gap-4 pt-6">
        <button type="submit" 
                class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
          {{ __('app.update_category') }}
        </button>
        <a href="{{ route('admin.dashboard') }}" 
           class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
          ← {{ __('app.back') }}
        </a>
      </div>
    </form>
  </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto translate function using Google Translate API (free tier)
    async function translateText(text, targetLang = 'en') {
        try {
            // Using a simple translation service (you can replace with Google Translate API)
            const response = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(text)}&langpair=vi|en`);
            const data = await response.json();
            
            if (data.responseStatus === 200) {
                return data.responseData.translatedText;
            } else {
                throw new Error('Translation failed');
            }
        } catch (error) {
            console.error('Translation error:', error);
            return null;
        }
    }

    // Translate name button
    document.getElementById('translate-name').addEventListener('click', async function() {
        const vietnameseName = document.getElementById('name').value;
        if (!vietnameseName) {
            alert('{{ __("app.please_enter_vietnamese_name_first") }}');
            return;
        }

        this.disabled = true;
        this.textContent = '{{ __("app.translating") }}...';

        const translatedName = await translateText(vietnameseName);
        
        if (translatedName) {
            document.getElementById('name_en').value = translatedName;
        } else {
            alert('{{ __("app.translation_failed") }}');
        }

        this.disabled = false;
        this.textContent = '{{ __("app.auto_translate") }}';
    });

    // Translate description button
    document.getElementById('translate-description').addEventListener('click', async function() {
        const vietnameseDesc = document.getElementById('description').value;
        if (!vietnameseDesc) {
            alert('{{ __("app.please_enter_vietnamese_description_first") }}');
            return;
        }

        this.disabled = true;
        this.textContent = '{{ __("app.translating") }}...';

        const translatedDesc = await translateText(vietnameseDesc);
        
        if (translatedDesc) {
            document.getElementById('description_en').value = translatedDesc;
        } else {
            alert('{{ __("app.translation_failed") }}');
        }

        this.disabled = false;
        this.textContent = '{{ __("app.auto_translate") }}';
    });
});
</script>
@endsection
