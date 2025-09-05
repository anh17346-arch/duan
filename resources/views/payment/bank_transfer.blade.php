@extends('layouts.app')
@section('title', __('app.bank_transfer') . ' - Perfume Luxury')

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
        {{ __('app.bank_transfer') }}
      </h1>
      <p class="text-slate-600 dark:text-slate-400">
        {{ __('app.transfer_to_bank_account') }}
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Left Column - Bank Account Info -->
      <div class="space-y-6">
        <!-- Bank Account Information -->
        <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            {{ __('app.bank_account_info') }}
          </h2>
          
          <div class="space-y-4">
            <!-- Bank Name -->
            <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg">
              <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
              </div>
              <div>
                <div class="font-semibold text-slate-900 dark:text-slate-100">{{ __('app.bank_name') }}</div>
                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">Vietcombank</div>
              </div>
            </div>

            <!-- Account Number -->
            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-lg">
              <div class="flex items-center justify-between">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.account_number') }}:</span>
                <div class="flex items-center gap-2">
                  <span class="font-mono text-lg font-bold text-slate-900 dark:text-slate-100" id="account-number">1234567890</span>
                  <button onclick="copyToClipboard('account-number')" class="p-1 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- Account Holder -->
            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-lg">
              <div class="flex items-center justify-between">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.account_holder') }}:</span>
                <span class="font-semibold text-slate-900 dark:text-slate-100">CONG TY TNHH PERFUME LUXURY</span>
              </div>
            </div>

            <!-- Branch -->
            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-lg">
              <div class="flex items-center justify-between">
                <span class="text-slate-600 dark:text-slate-400">{{ __('app.branch') }}:</span>
                <span class="font-semibold text-slate-900 dark:text-slate-100">Chi nhánh Hà Nội</span>
              </div>
            </div>

            <!-- Transfer Amount -->
            <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg">
              <div class="flex items-center justify-between">
                <span class="text-green-700 dark:text-green-300 font-semibold">{{ __('app.transfer_amount') }}:</span>
                <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($order->total) }}₫</span>
              </div>
            </div>

            <!-- Transfer Content -->
            <div class="p-4 bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-700 rounded-lg">
              <div class="mb-2">
                <span class="text-amber-700 dark:text-amber-300 font-semibold">{{ __('app.transfer_content') }}:</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="font-mono text-lg font-bold text-amber-800 dark:text-amber-200" id="transfer-content">{{ $order->order_id }} - {{ $order->user->name }}</span>
                <button onclick="copyToClipboard('transfer-content')" class="p-1 text-amber-600 hover:text-amber-800 dark:hover:text-amber-400">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                  </svg>
                </button>
              </div>
              <div class="mt-2 text-sm text-amber-600 dark:text-amber-400">
                {{ __('app.transfer_content_note') }}
              </div>
            </div>
          </div>
        </div>

        <!-- Instructions -->
        <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-xl p-6">
          <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ __('app.transfer_instructions') }}
          </h3>
          <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-300">
            <li class="flex items-start gap-2">
              <span class="text-blue-600 dark:text-blue-400">1.</span>
              <span>{{ __('app.transfer_instruction_1') }}</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-600 dark:text-blue-400">2.</span>
              <span>{{ __('app.transfer_instruction_2') }}</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-600 dark:text-blue-400">3.</span>
              <span>{{ __('app.transfer_instruction_3') }}</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="text-blue-600 dark:text-blue-400">4.</span>
              <span>{{ __('app.transfer_instruction_4') }}</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Right Column - QR Code -->
      <div class="space-y-6">
        <!-- QR Code -->
        <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
            </svg>
            {{ __('app.qr_code') }}
          </h2>
          
          <div class="text-center">
            <div class="inline-block p-4 bg-white rounded-xl shadow-lg">
              <img id="qr-code" src="" alt="QR Code" class="w-64 h-64 mx-auto">
            </div>
            <p class="mt-4 text-sm text-slate-600 dark:text-slate-400">
              {{ __('app.scan_qr_code') }}
            </p>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white/80 dark:bg-slate-800/60 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-700 shadow-lg">
          <h2 class="text-xl font-bold mb-4 text-brand-700 dark:text-brand-300 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            {{ __('app.order_summary') }}
          </h2>

          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.order_id') }}</span>
              <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $order->order_id }}</span>
            </div>
            
            <div class="flex justify-between">
              <span class="text-slate-600 dark:text-slate-400">{{ __('app.total_amount') }}</span>
              <span class="font-bold text-lg text-brand-600 dark:text-brand-400">{{ number_format($order->total) }}₫</span>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
          <form action="{{ route('payment.confirm', $order->order_id) }}" method="POST">
            @csrf
            <button type="submit" class="w-full px-6 py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors shadow-lg flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              {{ __('app.confirm_payment') }}
            </button>
          </form>
          
          <div class="flex gap-4">
            <a href="{{ route('payment.show', $order->order_id) }}" 
               class="flex-1 px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-semibold transition-colors text-center">
              {{ __('app.back') }}
            </a>
            
            <a href="{{ route('payment.cancel', $order->order_id) }}" 
               class="flex-1 px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-semibold transition-colors text-center">
              {{ __('app.cancel') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Generate QR Code
function generateQRCode() {
  const qrData = {
    bank: 'VCB',
    account: '1234567890',
    amount: {{ $order->total }},
    content: '{{ $order->order_id }} - {{ $order->user->name }}'
  };
  
  // Create QR code URL (using a simple placeholder for now)
  const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=256x256&data=${encodeURIComponent(JSON.stringify(qrData))}`;
  
  document.getElementById('qr-code').src = qrCodeUrl;
}

// Copy to clipboard function
function copyToClipboard(elementId) {
  const element = document.getElementById(elementId);
  const text = element.textContent;
  
  navigator.clipboard.writeText(text).then(function() {
    // Show success message
    const button = element.nextElementSibling;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
    
    setTimeout(() => {
      button.innerHTML = originalHTML;
    }, 2000);
  });
}

// Initialize QR code when page loads
document.addEventListener('DOMContentLoaded', function() {
  generateQRCode();
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
