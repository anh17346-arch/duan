@extends('layouts.app')

@section('title', __('app.order_management') . ' - Perfume Luxury')

@push('styles')
<style>
  /* Force dark mode styling for dropdowns */
  .dark select {
    background-color: #1e293b !important;
    color: #f1f5f9 !important;
    border-color: #475569 !important;
  }
  
  .dark select option {
    background-color: #1e293b !important;
    color: #f1f5f9 !important;
  }
  
  .dark select option:hover {
    background-color: #334155 !important;
    color: #ffffff !important;
  }
  
  .dark select option:checked {
    background-color: #3b82f6 !important;
    color: #ffffff !important;
  }
</style>
@endpush

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

<div class="relative max-w-6xl mx-auto px-4 py-8">
  <!-- Back Button -->
  <div class="mb-6">
      <a href="{{ route('admin.dashboard') }}" 
         class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-2xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
          </svg>
      </a>
  </div>

  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ __('app.order_management') }}</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('app.order_management_description') }}</p>
    </div>
    <div class="flex items-center gap-4">
      <button onclick="exportOrders()" 
              class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        {{ __('app.export_excel') }}
      </button>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/20">
          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.total_orders') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($stats['total']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-yellow-100 dark:bg-yellow-900/20">
          <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.pending_orders') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($stats['pending']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900/20">
          <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.delivered_orders') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($stats['delivered']) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700">
      <div class="flex items-center">
        <div class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900/20">
          <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <div class="ml-4">
          <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('app.monthly_revenue') }}</p>
          <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($stats['monthly_revenue'], 0, ',', '.') }}đ</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Search and Filters -->
  <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200/60 dark:border-slate-700 mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Search -->
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.search') }}</label>
          <input type="text" 
                 name="search" 
                 value="{{ request('search') }}"
                 placeholder="{{ __('app.search_placeholder') }}"
                 class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.status') }}</label>
          <select name="status" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            <option value="" class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.all') }}</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.pending') }}</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.processing') }}</option>
            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.shipped') }}</option>
            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.delivered') }}</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.cancelled') }}</option>
          </select>
        </div>

        <!-- Payment Status -->
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.payment') }}</label>
          <select name="payment_status" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
            <option value="" class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.all') }}</option>
            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_pending') }}</option>
            <option value="processing" {{ request('payment_status') == 'processing' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_processing') }}</option>
            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_paid') }}</option>
            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.payment_failed') }}</option>
          </select>
        </div>

        <!-- Date Range -->
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.from_date') }}</label>
          <input type="date" 
                 name="date_from" 
                 value="{{ request('date_from') }}"
                 class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
        </div>
      </div>

      <div class="flex items-center gap-3">
        <button type="submit" 
                class="px-6 py-3 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 rounded-xl font-semibold hover:bg-slate-800 dark:hover:bg-slate-200 transition-colors">
          {{ __('app.filter') }}
        </button>
        <a href="{{ route('admin.orders.index') }}" 
           class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
          {{ __('app.clear_filters') }}
        </a>
      </div>
    </form>
  </div>

  <!-- Orders Table -->
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-slate-50 dark:bg-slate-700/50">
          <tr>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">
              <input type="checkbox" id="select-all" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
            </th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.order') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.customer') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.status') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.payment') }}</th>
            <th class="text-right px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.total_amount') }}</th>
            <th class="text-left px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.created_date') }}</th>
            <th class="text-right px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ __('app.actions') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
          @forelse($orders as $order)
            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
              <td class="px-6 py-4">
                <input type="checkbox" class="order-checkbox rounded border-slate-300 text-brand-600 focus:ring-brand-500" value="{{ $order->id }}">
              </td>
              <td class="px-6 py-4">
                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $order->order_number }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('app.products_count', ['count' => $order->items->count()]) }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $order->user->name }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $order->user->email }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ $order->shipping_phone }}</div>
              </td>
              <td class="px-6 py-4">
                @php
                  $statusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                    'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300',
                    'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                  ];
                  $statusLabels = [
                    'pending' => __('app.pending'),
                    'processing' => __('app.processing'),
                    'shipped' => __('app.shipped'),
                    'delivered' => __('app.delivered'),
                    'cancelled' => __('app.cancelled'),
                  ];
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$order->status] }}">
                  {{ $statusLabels[$order->status] }}
                </span>
              </td>
              <td class="px-6 py-4">
                @php
                  $paymentStatusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                    'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                  ];
                  $paymentStatusLabels = [
                    'pending' => __('app.payment_pending'),
                    'processing' => __('app.payment_processing'),
                    'paid' => __('app.payment_paid'),
                    'failed' => __('app.payment_failed'),
                  ];
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentStatusClasses[$order->payment_status] }}">
                  {{ $paymentStatusLabels[$order->payment_status] }}
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="text-slate-900 dark:text-slate-100 font-semibold">{{ number_format($order->total, 0, ',', '.') }}đ</div>
              </td>
              <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                {{ $order->created_at->format('d/m/Y H:i') }}
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2 justify-end">
                  <a href="{{ route('admin.orders.show', $order) }}" 
                     class="px-3 py-1.5 text-sm rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    {{ __('app.view') }}
                  </a>
                  <button onclick="showStatusModal({{ $order->id }}, '{{ $order->status }}')" 
                          class="px-3 py-1.5 text-sm rounded-lg border border-amber-300 dark:border-amber-600 text-amber-700 dark:text-amber-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                    {{ __('app.update') }}
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-6 py-12 text-center">
                <div class="text-slate-400 dark:text-slate-500">
                  <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                  </svg>
                  <p class="text-lg font-medium">{{ __('app.no_orders') }}</p>
                  <p class="mt-1">{{ __('app.no_orders_description') }}</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
        {{ $orders->links() }}
      </div>
    @endif
  </div>

  <!-- Bulk Actions -->
  <div id="bulk-actions" class="hidden mt-4 p-4 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700">
    <div class="flex items-center justify-between">
      <span class="text-sm text-slate-600 dark:text-slate-400">
        {{ __('app.selected_orders', ['count' => '<span id="selected-count">0</span>']) }}
      </span>
      <div class="flex items-center gap-3">
        <select id="bulk-status" class="px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100">
          <option value="" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.select_status') }}</option>
          <option value="pending" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.pending') }}</option>
          <option value="processing" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.processing') }}</option>
          <option value="shipped" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.shipped') }}</option>
          <option value="delivered" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.delivered') }}</option>
          <option value="cancelled" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.cancelled') }}</option>
        </select>
        <button onclick="bulkUpdateStatus()" 
                class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
          {{ __('app.update_status') }}
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Status Update Modal -->
<div id="status-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
  <div class="flex items-center justify-center min-h-screen px-4 text-center">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeStatusModal()"></div>
    <div class="relative inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-md">
      <form id="status-form" onsubmit="updateOrderStatus(event)">
        <div class="px-6 py-4">
          <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-slate-100 mb-4">
            {{ __('app.update_order_status') }}
          </h3>
          
          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.status') }}</label>
            <select name="status" id="modal-status" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
              <option value="pending" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.pending') }}</option>
              <option value="processing" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.processing') }}</option>
              <option value="shipped" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.shipped') }}</option>
              <option value="delivered" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.delivered') }}</option>
              <option value="cancelled" class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.cancelled') }}</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.notes') }} ({{ __('app.optional') }})</label>
            <textarea name="notes" rows="3" placeholder="{{ __('app.status_notes_placeholder') }}" class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
          </div>
        </div>

        <div class="px-6 py-3 bg-slate-50 dark:bg-slate-700 flex items-center justify-end gap-3">
          <button type="button" onclick="closeStatusModal()" 
                  class="px-4 py-2 bg-slate-300 hover:bg-slate-400 dark:bg-slate-600 dark:hover:bg-slate-500 text-slate-700 dark:text-slate-300 rounded-xl font-semibold transition-colors">
            {{ __('app.cancel') }}
          </button>
          <button type="submit" 
                  class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors">
            {{ __('app.update_status') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
// Function to update dropdown styling based on dark mode
function updateDropdownStyling() {
  const isDark = document.documentElement.classList.contains('dark');
  const selects = document.querySelectorAll('select');
  
  selects.forEach(select => {
    if (isDark) {
      select.style.backgroundColor = '#1e293b';
      select.style.color = '#f1f5f9';
      select.style.borderColor = '#475569';
    } else {
      select.style.backgroundColor = '#ffffff';
      select.style.color = '#1e293b';
      select.style.borderColor = '#e2e8f0';
    }
  });
}

// Update styling when page loads
document.addEventListener('DOMContentLoaded', updateDropdownStyling);

// Update styling when dark mode changes
const observer = new MutationObserver(function(mutations) {
  mutations.forEach(function(mutation) {
    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
      updateDropdownStyling();
    }
  });
});

observer.observe(document.documentElement, {
  attributes: true,
  attributeFilter: ['class']
});

// Also listen for Alpine.js dark mode changes
document.addEventListener('alpine:init', () => {
  Alpine.data('darkModeDropdown', () => ({
    init() {
      this.$watch('dark', (value) => {
        setTimeout(updateDropdownStyling, 100);
      });
    }
  }));
});

let currentOrderId = null;

// Select all checkbox functionality
document.getElementById('select-all').addEventListener('change', function() {
  const checkboxes = document.querySelectorAll('.order-checkbox');
  checkboxes.forEach(checkbox => {
    checkbox.checked = this.checked;
  });
  updateBulkActions();
});

// Individual checkbox functionality
document.addEventListener('change', function(e) {
  if (e.target.classList.contains('order-checkbox')) {
    updateBulkActions();
  }
});

function updateBulkActions() {
  const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
  const bulkActions = document.getElementById('bulk-actions');
  const selectedCount = document.getElementById('selected-count');
  
  if (checkedBoxes.length > 0) {
    bulkActions.classList.remove('hidden');
    selectedCount.textContent = checkedBoxes.length;
  } else {
    bulkActions.classList.add('hidden');
  }
}

function showStatusModal(orderId, currentStatus) {
  currentOrderId = orderId;
  document.getElementById('modal-status').value = currentStatus;
  document.getElementById('status-modal').classList.remove('hidden');
}

function closeStatusModal() {
  document.getElementById('status-modal').classList.add('hidden');
  currentOrderId = null;
  document.getElementById('status-form').reset();
}

async function updateOrderStatus(event) {
  event.preventDefault();
  
  if (!currentOrderId) return;
  
  const formData = new FormData(event.target);
  
  try {
    const response = await fetch(`/admin/orders/${currentOrderId}/status`, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        status: formData.get('status'),
        notes: formData.get('notes')
      })
    });
    
    const result = await response.json();
    
    if (result.success) {
      location.reload();
    } else {
      alert('{{ __('app.error_updating_status') }}');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('{{ __('app.error_updating_status') }}');
  }
  
  closeStatusModal();
}

async function bulkUpdateStatus() {
  const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
  const status = document.getElementById('bulk-status').value;
  
  if (!status) {
    alert('{{ __('app.please_select_status') }}');
    return;
  }
  
  if (checkedBoxes.length === 0) {
    alert('{{ __('app.please_select_orders') }}');
    return;
  }
  
  const orderIds = Array.from(checkedBoxes).map(cb => cb.value);
  
  try {
    const response = await fetch('/admin/orders/bulk-update-status', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        order_ids: orderIds,
        status: status
      })
    });
    
    const result = await response.json();
    
    if (result.success) {
      location.reload();
    } else {
      alert('{{ __('app.error_updating_status') }}');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('{{ __('app.error_updating_status') }}');
  }
}

function exportOrders() {
  const params = new URLSearchParams(window.location.search);
  const exportUrl = '/admin/orders/export?' + params.toString();
  window.open(exportUrl, '_blank');
}

// Close modal when clicking outside
document.getElementById('status-modal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeStatusModal();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeStatusModal();
  }
});
</script>
@endpush
@endsection
