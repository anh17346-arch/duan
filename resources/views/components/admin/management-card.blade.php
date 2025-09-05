@props(['title', 'description', 'icon', 'href', 'stats' => []])

<div class="admin-card group cursor-pointer" onclick="window.location='{{ $href }}'">
  <div class="p-6">
    <div class="flex items-center mb-4">
      <div class="stats-icon bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-500 mr-4">
        {!! $icon !!}
      </div>
      <div class="flex-1">
        <h3 class="text-xl font-semibold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
          {{ $title }}
        </h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">{{ $description }}</p>
      </div>
    </div>
    
    @if(!empty($stats))
    <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
      @foreach($stats as $stat)
      <div class="text-center">
        <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $stat['value'] }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
      </div>
      @endforeach
    </div>
    @endif
    
    <div class="mt-4 flex items-center text-blue-600 dark:text-blue-400 text-sm font-medium group-hover:translate-x-1 transition-transform">
      Quản lý
      <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </div>
  </div>
</div>