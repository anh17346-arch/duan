{{-- resources/views/partials/flash.blade.php --}}
@php
  $success = session('success');
  $error   = session('error');
  $info    = session('info');
@endphp

<div
  x-data="{
    showSuccess: {{ $success ? 'true' : 'false' }},
    showError:   {{ $error   ? 'true' : 'false' }},
    showInfo:    {{ $info    ? 'true' : 'false' }},
    showErrors:  {{ $errors->any() ? 'true' : 'false' }},
  }"
  x-init="
    if (showSuccess) setTimeout(()=> showSuccess=false, 4500);
    if (showError)   setTimeout(()=> showError=false,   6000);
    if (showInfo)    setTimeout(()=> showInfo=false,    4500);
  "
  class="space-y-3"
>
  @if ($success)
    <div x-show="showSuccess" x-transition class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3">
      <div class="flex items-start gap-3">
        <div class="flex-1">{{ $success }}</div>
        <button type="button" @click="showSuccess=false">&times;</button>
      </div>
    </div>
  @endif

  @if ($error)
    <div x-show="showError" x-transition class="rounded-xl border border-rose-200 bg-rose-50 text-rose-800 px-4 py-3">
      <div class="flex items-start gap-3">
        <div class="flex-1">{{ $error }}</div>
        <button type="button" @click="showError=false">&times;</button>
      </div>
    </div>
  @endif

  @if ($info)
    <div x-show="showInfo" x-transition class="rounded-xl border border-sky-200 bg-sky-50 text-sky-800 px-4 py-3">
      <div class="flex items-start gap-3">
        <div class="flex-1">{{ $info }}</div>
        <button type="button" @click="showInfo=false">&times;</button>
      </div>
    </div>
  @endif

  @if ($errors->any())
    <div x-show="showErrors" x-transition class="rounded-xl border border-amber-200 bg-amber-50 text-amber-900 px-4 py-3">
      <div class="font-medium mb-1">Có lỗi xảy ra, vui lòng kiểm tra:</div>
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
