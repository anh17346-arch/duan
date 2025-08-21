@extends('layouts.app')
@section('title','Thêm danh mục')

@section('content')
<div class="glass rounded-2xl p-6 shadow-soft border border-slate-200/60 dark:border-slate-800 max-w-2xl">
  <h2 class="text-xl font-semibold mb-4">Thêm danh mục</h2>

  @if ($errors->any())
    <div class="mb-4 rounded-2xl p-4 border border-rose-300/60 text-rose-700 dark:text-rose-300 dark:border-rose-700/50">
      <b>Vui lòng kiểm tra lại:</b>
      <ul class="mt-2 list-disc list-inside">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Tên danh mục</label>
      <input name="name" value="{{ old('name') }}" required
             class="w-full px-3 py-2 rounded-xl bg-white/70 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700 outline-none focus:ring-2 ring-brand/40"
             placeholder="VD: Áo, Quần..." />
    </div>

    <div class="pt-2 flex items-center gap-2">
      <button class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white">Lưu</button>
      <a class="px-4 py-2 rounded-xl border border-slate-300/60 dark:border-slate-700 hover:bg-slate-100/70 dark:hover:bg-slate-900/40"
         href="{{ route('categories.index') }}">Hủy</a>
    </div>
  </form>
</div>
@endsection
