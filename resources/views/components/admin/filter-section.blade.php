@props(['title' => 'Bộ lọc'])

<div class="admin-card mb-6">
  <div class="p-6">
    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ $title }}</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      {{ $slot }}
    </div>
  </div>
</div>