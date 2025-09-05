@extends('layouts.app')
@section('title', __('app.payment') . ' - Perfume Luxury')

@section('content')
<div class="min-h-screen relative overflow-hidden">
  <div class="fixed inset-0 -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 via-purple-50/60 to-pink-50/60 dark:from-slate-900 dark:via-blue-900/30 dark:via-purple-900/30 dark:to-pink-900/30"></div>
    <div class="absolute top-20 left-10 w-64 h-64 bg-gradient-to-r from-blue-400/10 to-purple-400/10 dark:from-blue-400/5 dark:to-purple-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-pink-400/10 to-rose-400/10 dark:from-pink-400/5 dark:to-rose-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-32 left-1/3 w-80 h-80 bg-gradient-to-r from-cyan-400/10 to-teal-400/10 dark:from-cyan-400/5 dark:to-teal-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-4000"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.05),transparent_50%)]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(100,116,139,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(100,116,139,0.03)_1px,transparent_1px)] bg-[size:64px_64px] dark:bg-[linear-gradient(rgba(148,163,184,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.02)_1px,transparent_1px)]"></div>
  </div>

  <div class="relative container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">
        {{ __('app.payment') }}
      </h1>
      <p class="text-slate-600 dark:text-slate-400">
        {{ __('app.complete_your_payment') }}
      </p>
    </div>

    <!-- Transaction Info -->
    <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg mb-6">
      <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        {{ __('app.transaction_info') }}
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
          <span class="text-slate-600 dark:text-slate-400">{{ __('app.order_id') }}:</span>
          <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->order_id }}</span>
        </div>
        
        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
          <span class="text-slate-600 dark:text-slate-400">{{ __('app.transaction_id') }}:</span>
          <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->transaction_id }}</span>
        </div>
        
        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
          <span class="text-slate-600 dark:text-slate-400">{{ __('app.created_at') }}:</span>
          <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        
        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
          <span class="text-slate-600 dark:text-slate-400">{{ __('app.expires_at') }}:</span>
          <span class="font-semibold text-rose-600 dark:text-rose-400">{{ $expiresAt->format('d/m/Y H:i') }}</span>
        </div>
      </div>

      <!-- Countdown Timer -->
      @if(!$isExpired)
        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg">
          <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-blue-700 dark:text-blue-300 font-semibold">{{ __('app.time_remaining') }}:</span>
            <span id="countdown" class="text-blue-800 dark:text-blue-200 font-bold text-lg"></span>
          </div>
        </div>
      @else
        <div class="mt-4 p-4 bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-700 rounded-lg">
          <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-rose-700 dark:text-rose-300 font-semibold">{{ __('app.payment_expired') }}</span>
          </div>
        </div>
      @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left Column - Payment Methods -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Payment Method Selection -->
        <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            {{ __('app.payment_method') }}
          </h2>

          <form action="{{ route('payment.process', $order->order_id) }}" method="POST" id="payment-form">
            @csrf
            <div class="space-y-4">
              <!-- Bank Transfer -->
              <label class="flex items-center p-4 border border-slate-200 dark:border-slate-600 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <input type="radio" name="payment_method" value="bank_transfer" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500">
                <div class="ml-4 flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900 dark:text-slate-100">{{ __('app.bank_transfer') }}</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('app.direct_bank_transfer') }}</div>
                  </div>
                </div>
              </label>

              <!-- MoMo -->
              <label class="flex items-center p-4 border border-slate-200 dark:border-slate-600 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <input type="radio" name="payment_method" value="momo" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500">
                <div class="ml-4 flex items-center gap-3">
                  <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900/50 rounded-lg flex items-center justify-center">
                    <span class="text-pink-600 dark:text-pink-400 font-bold text-lg">M</span>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900 dark:text-slate-100">{{ __('app.momo_wallet') }}</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('app.fast_and_secure_payment') }}</div>
                  </div>
                </div>
              </label>

              <!-- ZaloPay -->
              <label class="flex items-center p-4 border border-slate-200 dark:border-slate-600 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <input type="radio" name="payment_method" value="zalopay" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500">
                <div class="ml-4 flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                    <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">Z</span>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900 dark:text-slate-100">{{ __('app.zalopay_wallet') }}</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('app.pay_via_zalopay') }}</div>
                  </div>
                </div>
              </label>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex gap-4">
              <button type="submit" class="flex-1 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                {{ __('app.proceed_to_payment') }}
              </button>
              
              <a href="{{ route('payment.cancel', $order->order_id) }}" 
                 class="px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors">
                {{ __('app.cancel') }}
              </a>
            </div>
          </form>
        </div>

        <!-- Customer Information -->
        <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            {{ __('app.customer_info') }}
          </h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.full_name') }}</label>
              <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg text-slate-900 dark:text-slate-100">
                {{ $order->shipping_name }}
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.phone') }}</label>
              <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg text-slate-900 dark:text-slate-100">
                {{ $order->shipping_phone }}
              </div>
            </div>
            
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.shipping_address') }}</label>
              <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg text-slate-900 dark:text-slate-100">
                {{ $order->shipping_address }}
              </div>
            </div>
            
            @if($order->shipping_note)
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">{{ __('app.note') }}</label>
              <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg text-slate-900 dark:text-slate-100">
                {{ $order->shipping_note }}
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Right Column - Order Summary -->
      <div class="space-y-6">
        <!-- Order Summary -->
        <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            {{ __('app.order_summary') }}
          </h2>

          <!-- Products List -->
          <div class="space-y-4 mb-6">
            @foreach($order->items as $item)
            <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
              <img src="{{ $item->product->main_image_url }}" 
                   alt="{{ $item->product->name }}"
                   class="w-12 h-12 object-cover rounded-lg">
              <div class="flex-1">
                <div class="font-semibold text-slate-900 dark:text-slate-100">{{ $item->product->name }}</div>
                <div class="text-sm text-slate-600 dark:text-slate-400">{{ $item->product->volume }}ml</div>
              </div>
              <div class="text-right">
                <div class="font-semibold text-slate-900 dark:text-slate-100">x{{ $item->quantity }}</div>
                <div class="text-sm text-slate-600 dark:text-slate-400">{{ number_format($item->price) }}₫</div>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Price Breakdown -->
          <div class="space-y-3 border-t border-slate-200 dark:border-slate-600 pt-4">
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.subtotal') }}</span>
              <span class="font-semibold text-slate-900 dark:text-slate-100">{{ number_format($order->subtotal) }}₫</span>
            </div>
            
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.shipping_fee') }}</span>
              <span class="font-semibold text-slate-900 dark:text-slate-100">{{ number_format($order->shipping_fee) }}₫</span>
            </div>
            
            @if($order->discount_amount > 0)
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.discount') }}</span>
              <span class="font-semibold text-green-600 dark:text-green-400">-{{ number_format($order->discount_amount) }}₫</span>
            </div>
            @endif
            
            <div class="flex justify-between text-lg font-bold border-t border-slate-200 dark:border-slate-600 pt-3">
              <span class="text-slate-900 dark:text-slate-100">{{ __('app.total') }}</span>
              <span class="text-brand-600 dark:text-brand-400">{{ number_format($order->total) }}₫</span>
            </div>
          </div>
        </div>

        <!-- Security Badge -->
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-xl p-4">
          <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span class="text-green-700 dark:text-green-300 font-semibold">{{ __('app.secure_payment') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Countdown Timer
function updateCountdown() {
  const now = new Date().getTime();
  const expiresAt = new Date('{{ $expiresAt->toISOString() }}').getTime();
  const distance = expiresAt - now;

  if (distance < 0) {
    document.getElementById('countdown').innerHTML = '{{ __("app.expired") }}';
    return;
  }

  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById('countdown').innerHTML = 
    minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown();

// Form validation
document.getElementById('payment-form').addEventListener('submit', function(e) {
  const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
  if (!selectedMethod) {
    e.preventDefault();
    alert('{{ __("app.please_select_payment_method") }}');
    return;
  }
});
</script>
@endpush

@push('styles')
<style>
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}
</style>
@endpush
