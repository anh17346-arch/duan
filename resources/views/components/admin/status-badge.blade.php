@props(['status', 'type' => 'default'])

@php
$statusClasses = [
    'success' => 'status-badge status-success',
    'warning' => 'status-badge status-warning', 
    'danger' => 'status-badge status-danger',
    'error' => 'status-badge status-danger',
    'info' => 'status-badge status-info',
    'default' => 'status-badge bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200'
];
@endphp

<span class="{{ $statusClasses[$type] ?? $statusClasses['default'] }}">
  {{ $status }}
</span>