@extends('layouts.guest')
@section('title',__('app.register'))

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-20">
  <div class="w-full max-w-4xl">
    <!-- Modern Glass Card -->
    <div class="backdrop-blur-md bg-white/80 dark:bg-slate-800/80 rounded-3xl shadow-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden relative">
      <!-- Decorative Background Elements -->
      <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-gradient-to-r from-blue-400/20 to-purple-400/20 blur-3xl animate-pulse"></div>
      <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-gradient-to-r from-pink-400/20 to-rose-400/20 blur-3xl animate-pulse animation-delay-2000"></div>
      
      <div class="relative p-8 md:p-10" x-data="{ show:false, show2:false, caps:false, disabled:false, read:false }">
        <!-- Header Section -->
        <div class="mb-8 text-center">
          <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg mb-4 hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
          </div>
          <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('app.create_account') }}
          </h1>
          <p class="text-slate-700 dark:text-slate-300 text-lg">
            @if(app()->getLocale() === 'en')
              Fill in the information below to get started ✨
            @else
              Điền thông tin bên dưới để bắt đầu ✨
            @endif
          </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6"
              x-on:submit="disabled=true" autocomplete="off">
          @csrf

          {{-- Username * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Username <span class="text-rose-500">*</span>
            </label>
            <input tabindex="1" name="username" value="{{ old('username') }}" required minlength="5" maxlength="20"
                   pattern="[A-Za-z0-9]+"
                   placeholder="vd: anhle2004"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            @error('username') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Email * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Email <span class="text-rose-500">*</span>
            </label>
            <input tabindex="2" type="email" name="email" value="{{ old('email') }}" required maxlength="255"
                   placeholder="name@example.com"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            @error('email') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- First name * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.first_name') }} <span class="text-rose-500">*</span>
            </label>
            <input tabindex="3" name="first_name" value="{{ old('first_name') }}" required minlength="2" maxlength="20"
                   pattern="[\p{L}\s]+"
                   placeholder="Nguyễn"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            @error('first_name') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Last name * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.last_name') }} <span class="text-rose-500">*</span>
            </label>
            <input tabindex="4" name="last_name" value="{{ old('last_name') }}" required minlength="2" maxlength="20"
                   pattern="[\p{L}\s]+"
                   placeholder="Văn A"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            @error('last_name') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Phone * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.phone') }} <span class="text-rose-500">*</span>
            </label>
            <input tabindex="5" name="phone" value="{{ old('phone') }}" inputmode="numeric" pattern="\d{10,11}"
                   maxlength="11" required placeholder="0901234567"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            <p class="text-xs text-slate-500 mt-2">
              @if(app()->getLocale() === 'en')
                Numbers only, 10-11 digits.
              @else
                Chỉ nhập số, 10–11 chữ số.
              @endif
            </p>
            @error('phone') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Gender * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.gender') }} <span class="text-rose-500">*</span>
            </label>
            <select tabindex="6" name="gender" required
                    class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-900 dark:text-slate-100">
              <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{ __('app.select') }}</option>
              <option value="male"   @selected(old('gender')==='male')>{{ __('app.male') }}</option>
              <option value="female" @selected(old('gender')==='female')>{{ __('app.female') }}</option>
              <option value="other"  @selected(old('gender')==='other')>{{ __('app.other') }}</option>
            </select>
            @error('gender') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Address * --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.address') }} <span class="text-rose-500">*</span>
            </label>
            <input tabindex="7" name="address" value="{{ old('address') }}" required minlength="5" maxlength="150"
                   pattern="[\p{L}\p{N}\s,.\-\/#]+"
                   placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
            @error('address') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Password * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.password') }} <span class="text-rose-500">*</span>
            </label>
            <div class="relative group">
              <input tabindex="8" id="password" name="password" :type="show ? 'text' : 'password'"
                     required minlength="8" oncopy="return false" oncut="return false" onpaste="return false"
                     @keydown.cap="caps=$event.getModifierState && $event.getModifierState('CapsLock')"
                     @keyup.cap="caps=$event.getModifierState && $event.getModifierState('CapsLock')"
                     class="w-full px-5 py-4 pr-12 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 select-none placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
              <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors duration-200" @click="show=!show" tabindex="-1">
                <svg x-show="!show" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                </svg>
                <svg x-show="show" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M2 4l20 16-1.5 2L15 17.5A10.6 10.6 0 0112 19c-7 0-10-7-10-7a18.7 18.7 0 013.7-4.8L.5 6 2 4z"/>
                </svg>
              </button>
            </div>
            <p class="text-xs text-amber-600 mt-2 flex items-center" x-show="caps">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              @if(app()->getLocale() === 'en')
                Caps Lock is on
              @else
                Bạn đang bật Caps Lock
              @endif
            </p>
            @error('password') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Confirm Password * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              {{ __('app.confirm_password') }} <span class="text-rose-500">*</span>
            </label>
            <div class="relative group">
              <input tabindex="9" id="password_confirmation" name="password_confirmation" :type="show2 ? 'text' : 'password'"
                     required minlength="8" oncopy="return false" oncut="return false" onpaste="return false"
                     class="w-full px-5 py-4 pr-12 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 select-none placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100">
              <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors duration-200" @click="show2=!show2" tabindex="-1">
                <svg x-show="!show2" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                </svg>
                <svg x-show="show2" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M2 4l20 16-1.5 2L15 17.5A10.6 10.6 0 0112 19c-7 0-10-7-10-7a18.7 18.7 0 013.7-4.8L.5 6 2 4z"/>
                </svg>
              </button>
            </div>
          </div>

          {{-- Terms & conditions (modal bắt đọc) * --}}
          <div class="md:col-span-2">
            <div class="flex items-start gap-3 p-4 rounded-2xl bg-white/70 dark:bg-slate-700/70 border border-slate-300 dark:border-slate-600">
              <input tabindex="10" id="terms" name="terms" type="checkbox" :disabled="!read" required 
                     class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
              <label for="terms" class="text-sm text-slate-800 dark:text-slate-200">
                @if(app()->getLocale() === 'en')
                  I have read and agree to the <button type="button" class="underline text-blue-600 hover:text-blue-700 font-medium" @click="$refs.modal.showModal()">Terms & Conditions</button> <span class="text-rose-500">*</span>
                @else
                  Tôi đã đọc và đồng ý với <button type="button" class="underline text-blue-600 hover:text-blue-700 font-medium" @click="$refs.modal.showModal()">Điều khoản & Điều kiện</button> <span class="text-rose-500">*</span>
                @endif
              </label>
            </div>
            @error('terms') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror

            <dialog x-ref="modal" class="backdrop:bg-black/40 rounded-2xl p-0 w-[min(90vw,700px)]">
              <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl">
                <h3 class="text-lg font-semibold mb-3 text-slate-800 dark:text-slate-200">{{ __('app.terms_conditions') }}</h3>
                <div class="h-56 overflow-y-auto pr-2" @scroll.passive="(e)=>{ const el=e.target; if(el.scrollTop + el.clientHeight >= el.scrollHeight) read=true; }">
                  <p class="text-sm text-slate-600 dark:text-slate-300">
                    (Nội dung điều khoản giả lập)… Vui lòng kéo xuống đọc hết. Khi kéo đến cuối, checkbox sẽ được bật.
                  </p>
                  <div class="h-96"></div> {{-- nội dung dài --}}
                </div>
                <div class="mt-4 flex justify-end gap-2">
                  <button type="button" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200" @click="$refs.modal.close()">{{ __('app.close') }}</button>
                </div>
              </div>
            </dialog>
            <p class="text-xs mt-2" :class="read ? 'text-emerald-600' : 'text-amber-600'">
              {{ __('Hãy đọc đến cuối điều khoản để bật checkbox.') }}
            </p>
          </div>

          {{-- Submit Button --}}
          <div class="md:col-span-2 pt-4">
            <button tabindex="11" :disabled="disabled" 
                    class="group relative w-full px-6 py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 disabled:opacity-60 text-white font-semibold shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:shadow-emerald-600/30 transition-all duration-300 hover:scale-[1.02] overflow-hidden">
              <!-- Shimmer effect -->
              <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
              
              <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                {{ __('app.register') }} 
              </span>
            </button>
            
            <p class="mt-6 text-center text-sm text-slate-700 dark:text-slate-300">
              @if(app()->getLocale() === 'en')
                Already have an account?
              @else
                Đã có tài khoản?
              @endif
              <a tabindex="12" href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold hover:underline transition-colors duration-200 ml-1">
                {{ __('app.login') }}
              </a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
