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
      
      <div class="relative p-8 md:p-10" x-data="{ 
        show: false, 
        show2: false, 
        caps: false, 
        disabled: false, 
        read: false,
        checkScrollEnd(event) {
          const el = event.target;
          if (el.scrollTop + el.clientHeight >= el.scrollHeight - 10) {
            this.read = true;
          }
        },
        agreeToTerms() {
          document.getElementById('terms').checked = true;
          this.$refs.modal.close();
        }
      }" x-init="
        // Focus vào trường đầu tiên có lỗi khi load trang
        setTimeout(() => {
          const firstError = document.querySelector('.text-rose-500');
          if (firstError) {
            const input = firstError.closest('div').querySelector('input, select');
            if (input) {
              input.focus();
              input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
          }
        }, 100);
      ">
        <!-- Header Section -->
        <div class="mb-8 text-center">
          <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg mb-4 hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
          </div>
          <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('app.create_account') }}
          </h1>
          <p class="text-slate-700 dark:text-slate-300 text-lg">
            @if(app()->getLocale() === 'en')
              Fill in the information below to get started :
            @else
              Điền thông tin bên dưới để bắt đầu :
            @endif
          </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6"
              x-on:submit="disabled=true" autocomplete="new-password" x-data="{ clearForm() { this.$el.reset(); } }">
          @csrf
          
          @if ($errors->any())
          <div class="md:col-span-2 mb-4 p-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 rounded-xl">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-rose-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              <h3 class="text-sm font-medium text-rose-800 dark:text-rose-200">
                Có {{ $errors->count() }} lỗi cần sửa:
              </h3>
            </div>
            <ul class="mt-2 text-sm text-rose-700 dark:text-rose-300 list-disc list-inside">
              @foreach ($errors->all() as $error)
                @if (!str_contains($error, 'password'))
                  <li>{{ $error }}</li>
                @endif
              @endforeach
            </ul>
          </div>
          @endif
          
          <!-- Clear Form Button -->
          <div class="md:col-span-2 flex justify-between items-center mb-4">
            
            <button type="button" @click="clearForm()" 
                    class="px-4 py-2 text-sm bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
              🗑️ Xóa form
            </button>
          </div>


          {{-- Username * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Username <span class="text-rose-500">*</span>
            </label>
            <input tabindex="1" name="username" value="{{ old('username') }}" required minlength="4" maxlength="30"
                   pattern="[a-zA-Z0-9]+"
                   placeholder="vd: anhle2004"
                   autocomplete="new-username"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('username') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
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
                   autocomplete="new-email"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('email') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
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
            <input tabindex="3" name="first_name" value="{{ old('first_name') }}" required minlength="2" maxlength="50"
                   pattern="[\p{L}\s]+"
                   placeholder="Nguyễn"
                   autocomplete="new-first-name"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('first_name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
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
            <input tabindex="4" name="last_name" value="{{ old('last_name') }}" required minlength="2" maxlength="50"
                   pattern="[\p{L}\s]+"
                   placeholder="Văn A"
                   autocomplete="new-last-name"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('last_name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
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
            <input tabindex="5" name="phone" value="{{ old('phone') }}" inputmode="numeric" pattern="(0|\+84)\d{9,10}"
                   maxlength="12" required placeholder="0901234567"
                   autocomplete="new-tel"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('phone') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
            <p class="text-xs text-slate-500 mt-2">
              @if(app()->getLocale() === 'en')
                Format: 0xxxxxxxxx or +84xxxxxxxxx (10-11 digits)
              @else
                Định dạng: 0xxxxxxxxx hoặc +84xxxxxxxxx (10-11 chữ số)
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
                    class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-900 dark:text-slate-100 @error('gender') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
              <option value="" disabled {{ old('gender') ? '' : 'selected' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.select') }}</option>
              <option value="male"   @selected(old('gender')==='male') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.male') }}</option>
              <option value="female" @selected(old('gender')==='female') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.female') }}</option>
              <option value="other"  @selected(old('gender')==='other') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">{{ __('app.other') }}</option>
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

          {{-- Province/City * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Tỉnh/Thành phố <span class="text-rose-500">*</span>
            </label>
            <select tabindex="7" name="province" required
                    class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 text-slate-900 dark:text-slate-100 @error('province') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
              <option value="" disabled {{ old('province') ? '' : 'selected' }} class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Chọn tỉnh/thành phố</option>
              <option value="Hà Nội" @selected(old('province')==='Hà Nội') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Hà Nội</option>
              <option value="Hải Phòng" @selected(old('province')==='Hải Phòng') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Hải Phòng</option>
              <option value="Huế" @selected(old('province')==='Huế') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Huế</option>
              <option value="TP. Hồ Chí Minh" @selected(old('province')==='TP. Hồ Chí Minh') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">TP. Hồ Chí Minh</option>
              <option value="Đà Nẵng" @selected(old('province')==='Đà Nẵng') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Đà Nẵng</option>
              <option value="Cần Thơ" @selected(old('province')==='Cần Thơ') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Cần Thơ</option>
              <option value="An Giang" @selected(old('province')==='An Giang') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">An Giang</option>                            
              <option value="Bắc Ninh" @selected(old('province')==='Bắc Ninh') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Bắc Ninh</option>                                          
              <option value="Cà Mau" @selected(old('province')==='Cà Mau') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Cà Mau</option>
              <option value="Cao Bằng" @selected(old('province')==='Cao Bằng') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Cao Bằng</option>
              <option value="Đắk Lắk" @selected(old('province')==='Đắk Lắk') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Đắk Lắk</option>              
              <option value="Điện Biên" @selected(old('province')==='Điện Biên') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Điện Biên</option>
              <option value="Đồng Nai" @selected(old('province')==='Đồng Nai') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Đồng Nai</option>
              <option value="Đồng Tháp" @selected(old('province')==='Đồng Tháp') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Đồng Tháp</option>
              <option value="Gia Lai" @selected(old('province')==='Gia Lai') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Gia Lai</option>                           
              <option value="Hà Tĩnh" @selected(old('province')==='Hà Tĩnh') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Hà Tĩnh</option>                            
              <option value="Hưng Yên" @selected(old('province')==='Hưng Yên') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Hưng Yên</option>
              <option value="Khánh Hòa" @selected(old('province')==='Khánh Hòa') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Khánh Hòa</option>
              <option value="Lai Châu" @selected(old('province')==='Lai Châu') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Lai Châu</option>
              <option value="Lâm Đồng" @selected(old('province')==='Lâm Đồng') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Lâm Đồng</option>
              <option value="Lạng Sơn" @selected(old('province')==='Lạng Sơn') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Lạng Sơn</option>
              <option value="Lào Cai" @selected(old('province')==='Lào Cai') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Lào Cai</option>              
              <option value="Nghệ An" @selected(old('province')==='Nghệ An') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Nghệ An</option>
              <option value="Ninh Bình" @selected(old('province')==='Ninh Bình') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Ninh Bình</option>           
              <option value="Phú Thọ" @selected(old('province')==='Phú Thọ') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Phú Thọ</option>              
              <option value="Quảng Trị" @selected(old('province')==='Quảng Trị') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Quảng Trị/option>              
              <option value="Quảng Ngãi" @selected(old('province')==='Quảng Ngãi') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Quảng Ngãi</option>
              <option value="Quảng Ninh" @selected(old('province')==='Quảng Ninh') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Quảng Ninh</option>           
              <option value="Sơn La" @selected(old('province')==='Sơn La') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Sơn La</option>
              <option value="Tây Ninh" @selected(old('province')==='Tây Ninh') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Tây Ninh</option>              
              <option value="Thái Nguyên" @selected(old('province')==='Thái Nguyên') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Thái Nguyên</option>
              <option value="Thanh Hóa" @selected(old('province')==='Thanh Hóa') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Thanh Hóa</option>
              <option value="Tuyên Quang" @selected(old('province')==='Tuyên Quang') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Tuyên Quang</option>
              <option value="Vĩnh Long" @selected(old('province')==='Vĩnh Long') class="bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100">Vĩnh Long</option>  
            </select>
            @error('province') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Ward/Commune * --}}
          <div>
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Xã/Phường <span class="text-rose-500">*</span>
            </label>
            <input tabindex="8" name="ward" value="{{ old('ward') }}" required minlength="2" maxlength="50"
                   pattern="[\p{L}\s]+"
                   placeholder="Ví dụ: Phường 1, Xã An Bình"
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('ward') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
            @error('ward') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Detailed Address * --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-slate-200">
              Địa chỉ chi tiết <span class="text-rose-500">*</span>
            </label>
            <input tabindex="9" name="address" value="{{ old('address') }}" required minlength="5" maxlength="255"
                   pattern="[\p{L}\p{N}\s,.\-\/#]+"
                   placeholder="Số nhà, tên đường, khu phố, tòa nhà, căn hộ..."
                   class="w-full px-5 py-4 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('address') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
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
              <input tabindex="10" id="password" name="password" :type="show ? 'text' : 'password'"
                     required minlength="8" maxlength="64" oncopy="return false" oncut="return false" onpaste="return false"
                     @keydown.cap="caps=$event.getModifierState && $event.getModifierState('CapsLock')"
                     @keyup.cap="caps=$event.getModifierState && $event.getModifierState('CapsLock')"
                     class="w-full px-5 py-4 pr-12 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 select-none placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
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
            <p class="text-xs text-slate-500 mt-2">
              @if(app()->getLocale() === 'en')
                Password must contain at least 8 characters with letters, numbers, symbols, and mixed case.
              @else
                Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ cái, số, ký hiệu và chữ hoa/thường.
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
              <input tabindex="11" id="password_confirmation" name="password_confirmation" :type="show2 ? 'text' : 'password'"
                     required minlength="8" maxlength="64" oncopy="return false" oncut="return false" onpaste="return false"
                     class="w-full px-5 py-4 pr-12 rounded-2xl bg-white/90 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 select-none placeholder-slate-500 dark:placeholder-slate-400 text-slate-900 dark:text-slate-100 @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
              <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors duration-200" @click="show2=!show2" tabindex="-1">
                <svg x-show="!show2" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 11a4 4 0 110-8 4 4 0 010 8z"/>
                </svg>
                <svg x-show="show2" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M2 4l20 16-1.5 2L15 17.5A10.6 10.6 0 0112 19c-7 0-10-7-10-7a18.7 18.7 0 013.7-4.8L.5 6 2 4z"/>
                </svg>
              </button>
            </div>
            @error('password_confirmation') 
              <p class="text-rose-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p> 
            @enderror
          </div>

          {{-- Honeypot field (hidden) --}}
          <div class="hidden">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
          </div>

          {{-- Terms & conditions (modal bắt đọc) * --}}
          <div class="md:col-span-2">
            <div class="flex items-start gap-3 p-4 rounded-2xl bg-white/70 dark:bg-slate-700/70 border border-slate-300 dark:border-slate-600">
              <input tabindex="12" id="terms" name="terms" type="checkbox" :disabled="!read" required 
                     :class="read ? 'mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer' : 'mt-1 w-4 h-4 text-gray-400 bg-gray-100 border-gray-300 rounded cursor-not-allowed'">
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
                <div class="h-56 overflow-y-auto pr-2" @scroll="checkScrollEnd($event)">
                  <p class="text-sm text-slate-600 dark:text-slate-300">
                    <strong>ĐIỀU KHOẢN SỬ DỤNG</strong><br><br>
                    
                    1. <strong>Điều khoản chung:</strong><br>
                    Bằng việc sử dụng dịch vụ của chúng tôi, bạn đồng ý tuân thủ các điều khoản và điều kiện này.<br><br>
                    
                    2. <strong>Thông tin cá nhân:</strong><br>
                    Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn theo quy định của pháp luật Việt Nam.<br><br>
                    
                    3. <strong>Thanh toán:</strong><br>
                    Tất cả giao dịch thanh toán được thực hiện an toàn thông qua các cổng thanh toán được ủy quyền.<br><br>
                    
                    4. <strong>Giao hàng:</strong><br>
                    Chúng tôi cam kết giao hàng trong thời gian sớm nhất có thể với dịch vụ vận chuyển đáng tin cậy.<br><br>
                    
                    5. <strong>Bảo hành:</strong><br>
                    Sản phẩm được bảo hành theo chính sách của nhà sản xuất và quy định của pháp luật.<br><br>
                    
                    6. <strong>Trách nhiệm:</strong><br>
                    Người dùng chịu trách nhiệm về việc sử dụng dịch vụ một cách hợp pháp và phù hợp.<br><br>
                    
                    7. <strong>Thay đổi điều khoản:</strong><br>
                    Chúng tôi có quyền thay đổi điều khoản này và sẽ thông báo trước khi có hiệu lực.<br><br>
                    
                    8. <strong>Liên hệ:</strong><br>
                    Nếu có thắc mắc, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ.<br><br>
                    
                    <em>Vui lòng kéo xuống đọc hết nội dung để có thể tích vào checkbox đồng ý.</em>
                  </p>
                  <div class="h-96"></div> {{-- nội dung dài --}}
                </div>
                <div class="mt-4 flex justify-between items-center">
                  <button type="button" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200" @click="$refs.modal.close()">{{ __('app.close') }}</button>
                  
                  <div class="flex items-center gap-3">
                    <button type="button" 
                            x-show="read"
                            @click="agreeToTerms()"
                            class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors duration-200">
                      Tôi đồng ý với các điều khoản
                    </button>
                  </div>
                </div>
              </div>
            </dialog>
            <p class="text-xs mt-2" :class="read ? 'text-emerald-600' : 'text-amber-600'">
              <span x-show="!read">{{ __('Vui lòng đọc kỹ điều khoản.') }}</span>
            </p>
          </div>

          {{-- Submit Button --}}
          <div class="md:col-span-2 pt-4">
            <button tabindex="13" :disabled="disabled" 
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
              <a tabindex="14" href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold hover:underline transition-colors duration-200 ml-1">
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
