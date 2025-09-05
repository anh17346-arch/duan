@props(['title', 'subtitle' => '', 'icon' => '', 'breadcrumbs' => []])

<div class="admin-header">
  <!-- Breadcrumbs -->
  @if(!empty($breadcrumbs))
  <nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
      @foreach($breadcrumbs as $index => $breadcrumb)
        <li class="inline-flex items-center">
          @if($index > 0)
            <svg class="w-6 h-6 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          @endif
          @if(isset($breadcrumb['url']) && !$loop->last)
            <a href="{{ $breadcrumb['url'] }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
              {{ $breadcrumb['title'] }}
            </a>
          @else
            <span class="text-slate-900 dark:text-slate-100 font-medium">
              {{ $breadcrumb['title'] }}
            </span>
          @endif
        </li>
      @endforeach
    </ol>
  </nav>
  @endif

  <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
    <div class="space-y-3">
      <div class="flex items-center space-x-4">
        @if($icon)
        <div class="stats-icon bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-500">
          {!! $icon !!}
        </div>
        @endif
        <div>
          <h1 class="admin-title">{{ $title }}</h1>
          @if($subtitle)
          <p class="admin-subtitle">{{ $subtitle }}</p>
          @endif
        </div>
      </div>
    </div>
    
    @if(isset($actions))
    <div class="flex items-center gap-4">
      {{ $actions }}
    </div>
    @endif
  </div>
</div>