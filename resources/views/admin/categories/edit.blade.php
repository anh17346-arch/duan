@extends('layouts.app')

@section('title', 'Sửa danh mục - Perfume Luxury')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">Sửa danh mục</h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">Cập nhật thông tin danh mục "{{ $category->name }}"</p>
  </div>

  <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
      @csrf
      @method('PUT')
      
      <div>
        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
          Tên danh mục <span class="text-rose-500">*</span>
        </label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
               class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"
               placeholder="Nhập tên danh mục...">
        @error('name')
          <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
          Mô tả
        </label>
        <textarea id="description" name="description" rows="4"
                  class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent resize-none"
                  placeholder="Mô tả về danh mục...">{{ old('description', $category->description) }}</textarea>
        @error('description')
          <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
          Trạng thái <span class="text-rose-500">*</span>
        </label>
        <select id="status" name="status" required
                class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
          <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Hoạt động</option>
          <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Ẩn</option>
        </select>
        @error('status')
          <p class="text-rose-600 text-sm mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center gap-4 pt-6">
        <button type="submit" 
                class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
          Cập nhật danh mục
        </button>
        <a href="{{ route('admin.dashboard') }}" 
           class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
          ← Quay lại
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
