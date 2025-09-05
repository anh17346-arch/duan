@extends('layouts.app')

@section('title', __('app.order_details') . ' #' . $order->order_number . ' - Perfume Luxury')

@section('content')
<div class="min-h-screen relative overflow-hidden">
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 via-purple-50/60 to-pink-50/60 dark:from-slate-900 dark:via-blue-900/30 dark:via-purple-900/30 dark:to-pink-900/30"></div>
  </div>

<div class="relative max-w-6xl mx-auto px-4 py-8">
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">
          {{ __('app.order_details') }} #{{ $order->order_number }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mt-2">
          {{ __('app.order_created_at') }} {{ $order->created_at->format('d/m/Y H:i') }}
        </p>
      </div>
      <div class="flex items-center gap-3">
        <button onclick="printOrder()" 
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors duration-200 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
          </svg>
          {{ __('app.print_order') }}
        </button>
        <a href="{{ route('admin.orders.index') }}" 
           class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-xl transition-colors duration-200">
          {{ __('app.back_to_list') }}
        </a>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
      <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10">
        <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
          <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.ordered_products') }}</h2>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            @foreach($order->items as $item)
              <div class="flex items-center gap-4 p-4 bg-white/30 dark:bg-slate-800/30 rounded-xl">
                <div class="w-16 h-16 bg-slate-200 dark:bg-slate-700 rounded-lg overflow-hidden flex-shrink-0">
                  @if($item->product->main_image_url)
                    <img src="{{ $item->product->main_image_url }}" 
                         alt="{{ $item->product->name }}"
                         class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full flex items-center justify-center">
                      <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                    </div>
                  @endif
                </div>
                <div class="flex-grow">
                  <h3 class="font-medium text-slate-900 dark:text-slate-100">{{ $item->product->name }}</h3>
                  <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ $item->product->brand }} • {{ $item->product->volume_ml }}ml
                  </p>
                  <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ __('app.quantity') }}: {{ $item->quantity }}
                  </p>
                </div>
                <div class="text-right">
                  <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ number_format($item->price, 0, ',', '.') }}đ{{ __('app.per_item') }}
                  </p>
                  <p class="font-semibold text-slate-900 dark:text-slate-100">
                    {{ number_format($item->total, 0, ',', '.') }}đ
                  </p>
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-slate-700">
            <div class="space-y-2">
              <div class="flex justify-between text-sm">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.subtotal') }}:</span>
                <span class="text-slate-900 dark:text-slate-100">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.shipping_fee') }}:</span>
                <span class="text-slate-900 dark:text-slate-100">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
              </div>
              <div class="flex justify-between text-lg font-semibold pt-2 border-t border-slate-200/60 dark:border-slate-700">
                <span class="text-slate-900 dark:text-slate-100">{{ __('app.total') }}:</span>
                <span class="text-brand-600 dark:text-brand-400">{{ number_format($order->total, 0, ',', '.') }}đ</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="space-y-6">
      <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10">
        <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
          <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.order_status') }}</h2>
        </div>
        <div class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.current_status') }}</label>
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
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$order->status] }}">
              {{ $statusLabels[$order->status] }}
            </span>
          </div>

          <form id="status-update-form" onsubmit="updateStatus(event)">
            <div class="mb-4">
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.update_status') }}</label>
              <select name="status" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.pending') }}</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.processing') }}</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.shipped') }}</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.delivered') }}</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.cancelled') }}</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.notes_optional') }}</label>
              <textarea name="notes" rows="3" placeholder="{{ __('app.status_change_notes') }}" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl bg-white/50 dark:bg-slate-800/50 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
            </div>

            <button type="submit" 
                    class="w-full px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl transition-colors duration-200">
              {{ __('app.update_order_status') }}
            </button>
          </form>
        </div>
      </div>

      <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10">
        <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
          <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.payment') }}</h2>
        </div>
        <div class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.payment_method') }}</label>
            @php
              $paymentMethods = [
                'momo' => 'MoMo',
                'zalopay' => 'ZaloPay',
                'bank_transfer' => 'Chuyển khoản',
                'cod' => 'Thanh toán khi nhận hàng',
              ];
            @endphp
            <p class="text-slate-900 dark:text-slate-100">{{ $paymentMethods[$order->payment_method] ?? $order->payment_method }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.payment_status') }}</label>
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
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $paymentStatusClasses[$order->payment_status] }}">
              {{ $paymentStatusLabels[$order->payment_status] }}
            </span>
          </div>

          <form id="payment-status-form" onsubmit="updatePaymentStatus(event)">
            <div class="mb-4">
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.update_payment_status') }}</label>
              <select name="payment_status" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.payment_pending') }}</option>
                <option value="processing" {{ $order->payment_status == 'processing' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.payment_processing') }}</option>
                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.payment_paid') }}</option>
                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }} class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">{{ __('app.payment_failed') }}</option>
              </select>
            </div>

            <button type="submit" 
                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors duration-200">
              {{ __('app.update_payment') }}
            </button>
          </form>
        </div>
      </div>

      <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl shadow-lg border border-white/30 dark:border-white/10">
        <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
          <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.customer_info') }}</h2>
        </div>
        <div class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.customer_name') }}</label>
            <p class="text-slate-900 dark:text-slate-100">{{ $order->user->name }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.email') }}</label>
            <p class="text-slate-900 dark:text-slate-100">{{ $order->user->email }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.recipient') }}</label>
            <p class="text-slate-900 dark:text-slate-100">{{ $order->shipping_name }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.phone') }}</label>
            <p class="text-slate-900 dark:text-slate-100">{{ $order->shipping_phone }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.shipping_address') }}</label>
            <p class="text-slate-900 dark:text-slate-100">
              {{ $order->shipping_address }}<br>
              {{ $order->shipping_district }}, {{ $order->shipping_city }}
            </p>
          </div>
          @if($order->notes)
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.notes') }}</label>
              <p class="text-slate-900 dark:text-slate-100 whitespace-pre-line">{{ $order->notes }}</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection

@push('styles')
<style>
  /* Enhanced select styling for dark mode */
  .dark select {
    background-color: rgb(30 41 59) !important;
    color: rgb(241 245 249) !important;
  }
  
  .dark select option {
    background-color: rgb(30 41 59) !important;
    color: rgb(241 245 249) !important;
  }
  
  .dark select option:hover {
    background-color: rgb(51 65 85) !important;
  }
  
  .dark select option:checked {
    background-color: rgb(59 130 246) !important;
    color: white !important;
  }
  
  /* Ensure proper contrast for textarea in dark mode */
  .dark textarea {
    background-color: rgb(30 41 59) !important;
    color: rgb(241 245 249) !important;
  }
</style>
@endpush

@push('scripts')
<script>
async function updateStatus(event) {
  event.preventDefault();
  
  const formData = new FormData(event.target);
  
  try {
    const response = await fetch(`/admin/orders/{{ $order->id }}/status`, {
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
      alert('Có lỗi xảy ra khi cập nhật trạng thái.');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi cập nhật trạng thái.');
  }
}

async function updatePaymentStatus(event) {
  event.preventDefault();
  
  const formData = new FormData(event.target);
  
  try {
    const response = await fetch(`/admin/orders/{{ $order->id }}/payment-status`, {
      method: 'PUT',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        payment_status: formData.get('payment_status')
      })
    });
    
    const result = await response.json();
    
    if (result.success) {
      location.reload();
    } else {
      alert('Có lỗi xảy ra khi cập nhật trạng thái thanh toán.');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Có lỗi xảy ra khi cập nhật trạng thái thanh toán.');
  }
}

function printOrder() {
  window.print();
}
</script>
@endpush
