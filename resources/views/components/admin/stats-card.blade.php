@props(['title', 'value', 'icon', 'trend' => null, 'trendValue' => null, 'color' => 'blue'])

@php
$colorClasses = [
    'blue' => 'from-blue-500 to-blue-600',
    'green' => 'from-green-500 to-green-600', 
    'purple' => 'from-purple-500 to-purple-600',
    'red' => 'from-red-500 to-red-600',
    'yellow' => 'from-yellow-500 to-yellow-600',
    'indigo' => 'from-indigo-500 to-indigo-600',
    'pink' => 'from-pink-500 to-pink-600',
    'cyan' => 'from-cyan-500 to-cyan-600'
];
@endphp

<div class="stats-card">
  <div class="flex items-center justify-between">
    <div class="flex-1">
      <div class="stats-icon bg-gradient-to-br {{ $colorClasses[$color] ?? $colorClasses['blue'] }}">
        {!! $icon !!}
      </div>
      
      <h3 class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">{{ $title }}</h3>
      
      <div class="flex items-baseline space-x-2">
        <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $value }}</p>
        
        @if($trend && $trendValue)
        <div class="flex items-center space-x-1">
          @if($trend === 'up')
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span class="text-sm font-medium text-green-600 dark:text-green-400">+{{ $trendValue }}</span>
          @elseif($trend === 'down')
            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
            </svg>
            <span class="text-sm font-medium text-red-600 dark:text-red-400">-{{ $trendValue }}</span>
          @else
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path>
            </svg>
            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $trendValue }}</span>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>
</div>