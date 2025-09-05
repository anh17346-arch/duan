@extends('layouts.app')
@section('title', __('app.payment') . ' - Perfume Luxury')

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

  <div class="relative container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6 flex gap-4">
      <a href="{{ session('checkout_data.buy_now_product_id') ? route('checkout.back-buy-now') : route('checkout.back') }}" 
         class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-700 dark:to-blue-600 text-blue-700 dark:text-blue-300 rounded-xl hover:from-blue-200 hover:to-blue-300 dark:hover:from-blue-600 dark:hover:to-blue-500 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
        {{ __('app.back_to_checkout') }}
      </a>
      <a href="{{ route('cart.index') }}" 
         class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:from-slate-200 hover:to-slate-300 dark:hover:from-slate-600 dark:hover:to-slate-500 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
        </svg>
        {{ __('app.back_to_cart') }}
      </a>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left Column - Payment Details -->
      <div class="lg:col-span-2 space-y-6">
        
        <!-- 1. Transaction Info -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
          <h2 class="text-xl font-bold mb-4 text-slate-900 dark:text-slate-100 flex items-center gap-3">
            <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            {{ __('app.transaction_info') }}
          </h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
              <div class="flex justify-between items-center">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.order_id') }}:</span>
                <span class="font-semibold text-brand-600 dark:text-brand-400">{{ $order->order_code }}</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.transaction_id') }}:</span>
                <span class="font-mono text-sm text-slate-700 dark:text-slate-300">{{ $transactionId }}</span>
              </div>
            </div>
            <div class="space-y-3">
              <div class="flex justify-between items-center">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.created_at') }}:</span>
                <span class="text-slate-700 dark:text-slate-300">{{ $order->created_at->format('d/m/Y H:i') }}</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.expires_at') }}:</span>
                <span class="font-semibold text-rose-600 dark:text-rose-400" id="countdown">
                  <span id="minutes">15</span>:<span id="seconds">00</span>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Customer Info -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
          <h2 class="text-xl font-bold mb-4 text-slate-900 dark:text-slate-100 flex items-center gap-3">
            <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            {{ __('app.customer_info') }}
          </h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
              <div>
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.full_name') }}:</span>
                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->customer_name }}</p>
              </div>
              <div>
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.phone') }}:</span>
                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->customer_phone }}</p>
              </div>
              @if($order->customer_email)
              <div>
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.email') }}:</span>
                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->customer_email }}</p>
              </div>
              @endif
            </div>
            <div class="space-y-3">
              <div>
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.shipping_address') }}:</span>
                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->shipping_address }}</p>
              </div>
              @if($order->notes)
              <div>
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.notes') }}:</span>
                <p class="text-slate-700 dark:text-slate-300 italic">{{ $order->notes }}</p>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- 3. Payment Method Section -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
          <h2 class="text-xl font-bold mb-4 text-slate-900 dark:text-slate-100 flex items-center gap-3">
            <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            {{ __('app.payment_method') }}
          </h2>

          @if($paymentMethod === 'bank_transfer')
            <!-- Bank Transfer Section -->
            <div class="space-y-6">
              <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <div>
                  <h3 class="font-semibold text-blue-900 dark:text-blue-100">{{ __('app.bank_transfer') }}</h3>
                  <p class="text-sm text-blue-700 dark:text-blue-300">{{ __('app.bank_transfer_desc') }}</p>
                </div>
              </div>

              <!-- Bank Account Info -->
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-700">
                <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.bank_account_info') }}</h4>
                
                <div class="space-y-3">
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.bank_name') }}:</span>
                    <span class="font-semibold text-slate-900 dark:text-slate-100">{{ config('payment.bank_name', 'Vietcombank') }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.account_number') }}:</span>
                    <span class="font-mono font-semibold text-slate-900 dark:text-slate-100">{{ config('payment.account_number', '1234567890') }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.account_holder') }}:</span>
                    <span class="font-semibold text-slate-900 dark:text-slate-100">{{ config('payment.account_holder', 'PERFUME LUXURY') }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.amount') }}:</span>
                    <span class="font-bold text-lg text-brand-600 dark:text-brand-400">{{ number_format($order->total) }}₫</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.transfer_content') }}:</span>
                    <span class="font-mono text-sm bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">{{ $order->order_code }} - {{ $order->customer_name }}</span>
                  </div>
                </div>

                <!-- QR Code -->
                <div class="mt-6 text-center">
                  <div class="inline-block p-4 bg-white rounded-xl shadow-lg">
                    <div class="w-48 h-48 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                      <span class="text-slate-500 dark:text-slate-400">{{ __('app.qr_code_placeholder') }}</span>
                    </div>
                  </div>
                  <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">{{ __('app.scan_qr_to_pay') }}</p>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex gap-4">
                <button type="button" onclick="confirmPayment()" 
                        class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors shadow-lg flex items-center justify-center gap-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  {{ __('app.confirm_payment') }}
                </button>
                <button type="button" onclick="cancelPayment()" 
                        class="px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors">
                  {{ __('app.cancel_payment') }}
                </button>
              </div>
            </div>

          @elseif(in_array($paymentMethod, ['momo', 'zalopay']))
            <!-- E-Wallet Section -->
            <div class="space-y-6">
              <div class="flex items-center gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-200 dark:border-purple-700">
                @if($paymentMethod === 'momo')
                  <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">M</span>
                  </div>
                  <div>
                    <h3 class="font-semibold text-purple-900 dark:text-purple-100">{{ __('app.momo_wallet') }}</h3>
                    <p class="text-sm text-purple-700 dark:text-purple-300">{{ __('app.momo_desc') }}</p>
                  </div>
                @else
                  <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">Z</span>
                  </div>
                  <div>
                    <h3 class="font-semibold text-purple-900 dark:text-purple-100">{{ __('app.zalopay_wallet') }}</h3>
                    <p class="text-sm text-purple-700 dark:text-purple-300">{{ __('app.zalopay_desc') }}</p>
                  </div>
                @endif
              </div>

              <!-- Payment Info -->
              <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-700">
                <h4 class="font-semibold text-slate-900 dark:text-slate-100 mb-4">{{ __('app.payment_info') }}</h4>
                
                <div class="space-y-3">
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.amount') }}:</span>
                    <span class="font-bold text-lg text-brand-600 dark:text-brand-400">{{ number_format($order->total) }}₫</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('app.payment_content') }}:</span>
                    <span class="font-mono text-sm bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">{{ $order->order_code }}</span>
                  </div>
                </div>

                <!-- QR Code -->
                <div class="mt-6 text-center">
                  <div class="inline-block p-4 bg-white rounded-xl shadow-lg">
                    <div class="w-48 h-48 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                      <span class="text-slate-500 dark:text-slate-400">{{ __('app.qr_code_placeholder') }}</span>
                    </div>
                  </div>
                  <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">{{ __('app.scan_qr_to_pay') }}</p>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex gap-4">
                <button type="button" onclick="confirmPayment()" 
                        class="flex-1 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-semibold transition-colors shadow-lg flex items-center justify-center gap-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  {{ __('app.confirm_payment') }}
                </button>
                <button type="button" onclick="cancelPayment()" 
                        class="px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors">
                  {{ __('app.cancel_payment') }}
                </button>
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Right Column - Order Summary -->
      <div class="space-y-6">
        <!-- Order Summary -->
        <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
          <h2 class="text-xl font-bold mb-4 text-slate-900 dark:text-slate-100 flex items-center gap-3">
            <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            {{ __('app.order_summary') }}
          </h2>

          <!-- Products List -->
          <div class="space-y-3 mb-6">
            @foreach($order->items as $item)
            <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
              <img src="{{ $item->product->main_image_url }}" 
                   alt="{{ $item->product->name }}"
                   class="w-12 h-12 object-cover rounded-lg">
              <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $item->product->name }}</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $item->product->volume }}ml x {{ $item->quantity }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ number_format($item->price) }}₫</p>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Price Breakdown -->
          <div class="space-y-3 border-t border-slate-200 dark:border-slate-700 pt-4">
            <div class="flex justify-between items-center">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.subtotal') }}:</span>
              <span class="font-semibold text-slate-900 dark:text-slate-100">{{ number_format($order->subtotal) }}₫</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.shipping_fee') }}:</span>
              <span class="font-semibold text-slate-900 dark:text-slate-100">{{ number_format($order->shipping_fee) }}₫</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="flex justify-between items-center">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.discount') }}:</span>
              <span class="font-semibold text-green-600 dark:text-green-400">-{{ number_format($order->discount_amount) }}₫</span>
            </div>
            @endif
            <div class="flex justify-between items-center text-lg font-bold text-brand-600 dark:text-brand-400 border-t border-slate-200 dark:border-slate-700 pt-3">
              <span>{{ __('app.total') }}:</span>
              <span>{{ number_format($order->total) }}₫</span>
            </div>
          </div>
        </div>

        <!-- Security Badge -->
        <div class="backdrop-blur-md bg-green-50 dark:bg-green-900/20 rounded-2xl p-4 shadow-lg border border-green-200 dark:border-green-700">
          <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <div>
              <h3 class="font-semibold text-green-900 dark:text-green-100">{{ __('app.secure_payment') }}</h3>
              <p class="text-sm text-green-700 dark:text-green-300">{{ __('app.secure_payment_desc') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Status Modal -->
<div id="paymentStatusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-md w-full mx-4">
    <div class="text-center">
      <div id="statusIcon" class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center">
        <!-- Icon will be set by JavaScript -->
      </div>
      <h3 id="statusTitle" class="text-xl font-bold mb-2"></h3>
      <p id="statusMessage" class="text-slate-600 dark:text-slate-400 mb-6"></p>
      <div class="flex gap-3">
        <button id="statusActionBtn" class="flex-1 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-semibold transition-colors"></button>
        <button onclick="closeStatusModal()" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors">
          {{ __('app.close') }}
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Countdown Timer
let timeLeft = 15 * 60; // 15 minutes in seconds
const countdownElement = document.getElementById('countdown');
const minutesElement = document.getElementById('minutes');
const secondsElement = document.getElementById('seconds');

function updateCountdown() {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  
  minutesElement.textContent = minutes.toString().padStart(2, '0');
  secondsElement.textContent = seconds.toString().padStart(2, '0');
  
  if (timeLeft <= 0) {
    showPaymentStatus('expired', '{{ __("app.payment_expired") }}', '{{ __("app.payment_expired_desc") }}', '{{ __("app.back_to_cart") }}');
    return;
  }
  
  timeLeft--;
  setTimeout(updateCountdown, 1000);
}

// Start countdown
updateCountdown();

// Payment Functions
function confirmPayment() {
  // Show loading state
  showPaymentStatus('loading', '{{ __("app.processing_payment") }}', '{{ __("app.please_wait") }}', '{{ __("app.processing") }}');
  
  // Call payment confirmation API
  fetch('{{ route("payment.confirm", $order->id) }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      payment_method: '{{ $paymentMethod }}',
      transaction_id: '{{ $transactionId }}'
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showPaymentStatus('success', '{{ __("app.payment_success") }}', data.message, '{{ __("app.view_order") }}');
    } else {
      showPaymentStatus('error', 'Lỗi thanh toán', data.message, 'Thử lại');
    }
  })
  .catch(error => {
    console.error('Payment error:', error);
    showPaymentStatus('error', 'Lỗi thanh toán', 'Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.', 'Thử lại');
  });
}

function cancelPayment() {
  if (confirm('{{ __("app.confirm_cancel_payment") }}')) {
    // Call cancel payment API
    fetch('{{ route("payment.cancel", $order->id) }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => {
      if (response.ok) {
        window.location.href = '{{ route("cart.index") }}';
      } else {
        alert('Có lỗi xảy ra khi hủy thanh toán. Vui lòng thử lại.');
      }
    })
    .catch(error => {
      console.error('Cancel error:', error);
      alert('Có lỗi xảy ra khi hủy thanh toán. Vui lòng thử lại.');
    });
  }
}

function showPaymentStatus(type, title, message, actionText) {
  const modal = document.getElementById('paymentStatusModal');
  const icon = document.getElementById('statusIcon');
  const titleEl = document.getElementById('statusTitle');
  const messageEl = document.getElementById('statusMessage');
  const actionBtn = document.getElementById('statusActionBtn');
  
  // Set content based on type
  titleEl.textContent = title;
  messageEl.textContent = message;
  actionBtn.textContent = actionText;
  
  // Set icon and colors
  icon.className = 'w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center';
  
  switch(type) {
    case 'loading':
      icon.innerHTML = '<svg class="w-8 h-8 text-blue-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
      icon.classList.add('bg-blue-100', 'dark:bg-blue-900/20');
      actionBtn.className = 'flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-colors';
      break;
    case 'success':
      icon.innerHTML = '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
      icon.classList.add('bg-green-100', 'dark:bg-green-900/20');
      actionBtn.className = 'flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors';
      actionBtn.onclick = () => window.location.href = '{{ route("orders.show", $order->id) }}';
      break;
         case 'expired':
       icon.innerHTML = '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
       icon.classList.add('bg-red-100', 'dark:bg-red-900/20');
       actionBtn.className = 'flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-colors';
       actionBtn.onclick = () => window.location.href = '{{ route("cart.index") }}';
       break;
     case 'error':
       icon.innerHTML = '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
       icon.classList.add('bg-red-100', 'dark:bg-red-900/20');
       actionBtn.className = 'flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-colors';
       actionBtn.onclick = () => closeStatusModal();
       break;
  }
  
  modal.classList.remove('hidden');
}

function closeStatusModal() {
  document.getElementById('paymentStatusModal').classList.add('hidden');
}

// Prevent double submission
let isProcessing = false;

document.addEventListener('DOMContentLoaded', function() {
  // Add event listeners for payment buttons
  const confirmBtn = document.querySelector('button[onclick="confirmPayment()"]');
  if (confirmBtn) {
    confirmBtn.addEventListener('click', function(e) {
      if (isProcessing) {
        e.preventDefault();
        return;
      }
      isProcessing = true;
    });
  }
});
</script>
@endpush

@push('styles')
<style>
/* Animations for the payment page */
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

.animation-delay-6000 {
  animation-delay: 6s;
}

/* Countdown animation */
#countdown {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

/* Modal animations */
#paymentStatusModal {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
@endpush
