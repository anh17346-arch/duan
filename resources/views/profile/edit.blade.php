@extends('layouts.app')
@section('title', __('app.account') . ' - Perfume Luxury')

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

    <!-- Modern Toast Notifications -->
    @include('partials.toast')

<div class="relative">

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
    .glass {
        backdrop-filter: blur(16px) saturate(180%);
        background-color: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.125);
    }
    .dark .glass {
        background-color: rgba(15, 23, 42, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.125);
    }

</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-brand-50 dark:from-slate-900 dark:via-slate-800 dark:to-brand-900/20">
    <!-- Floating background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-brand-200/20 dark:bg-brand-700/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-200/20 dark:bg-purple-700/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/2 w-72 h-72 bg-pink-200/20 dark:bg-pink-700/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative container mx-auto px-4 py-12 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-500 to-purple-600 rounded-full opacity-20 blur-lg scale-110"></div>
                <div class="relative h-20 w-20 bg-gradient-to-br from-brand-500 via-brand-600 to-purple-600 rounded-full flex items-center justify-center shadow-2xl mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
          </div>
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-slate-900 via-brand-600 to-purple-600 dark:from-slate-100 dark:via-brand-400 dark:to-purple-400 bg-clip-text text-transparent mb-4">
                {{ __('app.account_info') }}
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-md mx-auto">{{ __('app.update_personal_info') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="backdrop-blur-xl bg-white/70 dark:bg-slate-800/70 rounded-3xl shadow-xl border border-white/20 dark:border-slate-700/50 p-6 sticky top-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Navigation</h3>
                        <div class="w-12 h-0.5 bg-gradient-to-r from-brand-500 to-purple-500 rounded-full"></div>
                    </div>
                    <nav class="space-y-3" x-data="{ activeSection: 'personal' }">
                        <a href="#personal" @click="activeSection = 'personal'" 
                           :class="activeSection === 'personal' ? 'bg-gradient-to-r from-brand-500 to-brand-600 text-white shadow-lg shadow-brand-500/25 scale-105' : 'text-slate-700 dark:text-slate-300 hover:bg-brand-50 dark:hover:bg-brand-900/20 hover:text-brand-600 dark:hover:text-brand-400'"
                           class="group flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 ease-out transform hover:scale-105">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                 :class="activeSection === 'personal' ? 'bg-white/20' : 'bg-brand-100 dark:bg-brand-900/30 group-hover:bg-brand-200 dark:group-hover:bg-brand-800/50'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm">{{ __('app.personal_information') }}</div>
                                <div class="text-xs opacity-75">Profile & Avatar</div>
                            </div>
                        </a>
                        
                        <a href="#contact" @click="activeSection = 'contact'"
                           :class="activeSection === 'contact' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25 scale-105' : 'text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400'"
                           class="group flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 ease-out transform hover:scale-105">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                 :class="activeSection === 'contact' ? 'bg-white/20' : 'bg-blue-100 dark:bg-blue-900/30 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm">{{ __('app.contact_information') }}</div>
                                <div class="text-xs opacity-75">Email & Phone</div>
                            </div>
                        </a>
                        
                        <a href="#security" @click="activeSection = 'security'"
                           :class="activeSection === 'security' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-lg shadow-emerald-500/25 scale-105' : 'text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400'"
                           class="group flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 ease-out transform hover:scale-105">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                 :class="activeSection === 'security' ? 'bg-white/20' : 'bg-emerald-100 dark:bg-emerald-900/30 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/50'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm">{{ __('app.security_settings') }}</div>
                                <div class="text-xs opacity-75">Password</div>
                            </div>
                        </a>
                        
                        <a href="#danger" @click="activeSection = 'danger'"
                           :class="activeSection === 'danger' ? 'bg-gradient-to-r from-rose-500 to-rose-600 text-white shadow-lg shadow-rose-500/25 scale-105' : 'text-slate-700 dark:text-slate-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400'"
                           class="group flex items-center gap-4 px-4 py-4 rounded-2xl transition-all duration-300 ease-out transform hover:scale-105">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                 :class="activeSection === 'danger' ? 'bg-white/20' : 'bg-rose-100 dark:bg-rose-900/30 group-hover:bg-rose-200 dark:group-hover:bg-rose-800/50'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm">{{ __('app.danger_zone') }}</div>
                                <div class="text-xs opacity-75">Delete Account</div>
                            </div>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3 space-y-8">
            <!-- Personal Information Section -->
            <section id="personal" class="backdrop-blur-xl bg-white/70 dark:bg-slate-800/70 rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 relative overflow-hidden">
                <!-- Background gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-brand-50/50 via-transparent to-purple-50/30 dark:from-brand-900/20 dark:via-transparent dark:to-purple-900/10 pointer-events-none"></div>
                
                <div class="relative">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-500 to-purple-600 rounded-2xl opacity-20 blur-md"></div>
                            <div class="relative p-3 bg-gradient-to-br from-brand-500 to-brand-600 rounded-2xl shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-brand-600 dark:from-slate-100 dark:to-brand-400 bg-clip-text text-transparent">
                                {{ __('app.personal_information') }}
                            </h2>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">Update your personal details and avatar</p>
                        </div>
                    </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" x-data="{ preview: '{{ $user->avatar_url }}' }">
          @csrf
          @method('PATCH')
                    <input type="hidden" name="form_type" value="personal">

                    <!-- Avatar -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">{{ __('app.avatar') }}</label>
            <div class="flex items-center gap-4">
              <div class="relative">
                                <img :src="preview" src="{{ $user->avatar_url }}" 
                     class="w-20 h-20 rounded-full object-cover border-2 border-slate-200 dark:border-slate-600 shadow-lg" 
                     alt="avatar">
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-brand-600 rounded-full flex items-center justify-center">
                  <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                </div>
              </div>

              <div class="flex flex-col gap-2">
                <label class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white cursor-pointer transition-colors duration-200 text-center font-medium">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                  </svg>
                                    {{ __('app.choose_image') }}
                  <input type="file" name="avatar" accept="image/*" class="hidden"
                                           @change="if($event.target.files[0]){ const f=$event.target.files[0]; const url=URL.createObjectURL(f); preview=url; $refs.avatarClear.value = 0; }">
                </label>

                <button type="button"
                        class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200"
                                        @click="$refs.avatarClear.value = 1; preview='{{ asset('images/default-avatar.svg') }}';">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                                    {{ __('app.remove_image') }}
                </button>
              </div>
              <input type="hidden" name="avatar_clear" x-ref="avatarClear" value="0">
            </div>
            @error('avatar') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
          </div>

                    <!-- Basic Info Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Username -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ __('app.username') }} <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <input name="username" value="{{ old('username', $user->username) }}" required minlength="5" maxlength="20" pattern="[A-Za-z0-9]+"
                                       class="w-full px-4 py-4 rounded-2xl bg-white/50 dark:bg-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 dark:focus:ring-brand-400/50 dark:focus:border-brand-400/50 transition-all duration-300 backdrop-blur-sm group-hover:shadow-lg group-hover:shadow-brand-500/10">
                                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-brand-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                            @error('username') <p class="text-rose-500 text-sm mt-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <!-- Gender -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ __('app.gender') }} <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <select name="gender" required
                                        class="w-full px-4 py-4 rounded-2xl bg-white/50 dark:bg-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 dark:focus:ring-brand-400/50 dark:focus:border-brand-400/50 transition-all duration-300 backdrop-blur-sm group-hover:shadow-lg group-hover:shadow-brand-500/10">
                                    <option value="male" @selected(old('gender', $user->gender) === 'male')>{{ __('app.male') }}</option>
                                    <option value="female" @selected(old('gender', $user->gender) === 'female')>{{ __('app.female') }}</option>
                                    <option value="other" @selected(old('gender', $user->gender) === 'other')>{{ __('app.other') }}</option>
                                </select>
                                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-brand-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                            @error('gender') <p class="text-rose-500 text-sm mt-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <!-- First Name -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ __('app.first_name') }} <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <input name="first_name" value="{{ old('first_name', $user->first_name) }}" required minlength="2" maxlength="20"
                                       class="w-full px-4 py-4 rounded-2xl bg-white/50 dark:bg-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 dark:focus:ring-brand-400/50 dark:focus:border-brand-400/50 transition-all duration-300 backdrop-blur-sm group-hover:shadow-lg group-hover:shadow-brand-500/10">
                                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-brand-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                            @error('first_name') <p class="text-rose-500 text-sm mt-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                                {{ __('app.last_name') }} <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <input name="last_name" value="{{ old('last_name', $user->last_name) }}" required minlength="2" maxlength="20"
                                       class="w-full px-4 py-4 rounded-2xl bg-white/50 dark:bg-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 dark:focus:ring-brand-400/50 dark:focus:border-brand-400/50 transition-all duration-300 backdrop-blur-sm group-hover:shadow-lg group-hover:shadow-brand-500/10">
                                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-brand-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            </div>
                            @error('last_name') <p class="text-rose-500 text-sm mt-1 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-8 space-y-2">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            {{ __('app.address') }} <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative group">
                            <input name="address" value="{{ old('address', $user->address) }}" required minlength="5" maxlength="150"
                                   class="w-full px-4 py-4 rounded-2xl bg-white/50 dark:bg-slate-700/50 border border-slate-200/60 dark:border-slate-600/60 text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500/50 dark:focus:ring-brand-400/50 dark:focus:border-brand-400/50 transition-all duration-300 backdrop-blur-sm group-hover:shadow-lg group-hover:shadow-brand-500/10">
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-brand-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                        </div>
                        @error('address') <p class="text-rose-500 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p> @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-10 flex justify-end">
                        <button type="submit" 
                                class="group relative px-8 py-4 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white rounded-2xl font-bold shadow-xl shadow-brand-500/25 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-brand-500/30">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('app.save_changes') }}
                            </span>
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-brand-400 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </button>
                    </div>
                </form>
            </section>

            <!-- Contact Information Section -->
            <section id="contact" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.contact_information') }}</h2>
          </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="form_type" value="contact">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
          <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.email') }} <span class="text-rose-600">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255"
                                   class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-all duration-200">
            @error('email') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
          </div>

                        <!-- Phone -->
          <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.phone') }} <span class="text-rose-600">*</span></label>
                            <input name="phone" value="{{ old('phone', $user->phone) }}" inputmode="numeric" pattern="\d{10,11}" maxlength="11" required
                                   class="w-full px-4 py-3 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-all duration-200">
                            @error('phone') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>
          </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold shadow-lg shadow-blue-600/20 transition-all duration-200 hover:scale-105">
                            {{ __('app.update_contact_info') }}
                        </button>
                    </div>
                </form>
            </section>

            <!-- Security Settings Section -->
            <section id="security" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">{{ __('app.change_password') }}</h2>
          </div>

                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-sm text-amber-800 dark:text-amber-200">{{ __('app.current_password_required') }}</p>
                    </div>
          </div>

                <form method="POST" action="{{ route('profile.update') }}" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="form_type" value="password">

                    <div class="space-y-6">
                        <!-- Current Password -->
          <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.current_password') }} <span class="text-rose-600">*</span></label>
                            <div class="relative">
                                <input name="current_password" :type="showCurrent ? 'text' : 'password'" required
                                       class="w-full px-4 py-3 pr-12 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-all duration-200">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500" @click="showCurrent = !showCurrent">
                                    <svg x-show="!showCurrent" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showCurrent" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
          </div>
                            @error('current_password') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
          </div>

                        <!-- New Password -->
          <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.new_password') }} <span class="text-rose-600">*</span></label>
            <div class="relative">
                                <input name="password" :type="showNew ? 'text' : 'password'" required minlength="8"
                                       class="w-full px-4 py-3 pr-12 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-all duration-200">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500" @click="showNew = !showNew">
                                    <svg x-show="!showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
            </div>
            @error('password') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
          </div>

                        <!-- Confirm Password -->
          <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.confirm_password') }} <span class="text-rose-600">*</span></label>
            <div class="relative">
                                <input name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required minlength="8"
                                       class="w-full px-4 py-3 pr-12 rounded-xl bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-brand-500 focus:border-transparent transition-all duration-200">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500" @click="showConfirm = !showConfirm">
                                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
            </div>
          </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit" 
                                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-600/20 transition-all duration-200 hover:scale-105">
                            {{ __('app.change_password') }}
            </button>
          </div>
        </form>
            </section>

            <!-- Danger Zone Section -->
            <section id="danger" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-rose-200 dark:border-rose-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-rose-100 dark:bg-rose-900/30 rounded-lg">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-rose-600 dark:text-rose-400">{{ __('app.danger_zone') }}</h2>
                </div>

                <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-rose-800 dark:text-rose-200 mb-1">{{ __('app.delete_account') }}</h3>
                            <p class="text-sm text-rose-700 dark:text-rose-300">{{ __('app.delete_account_warning') }}</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}" x-data="{ showDeletePassword: false }" 
                      onsubmit="return confirm('{{ __('app.confirm_delete_account') }}')">
          @csrf
          @method('DELETE')

                    <div class="flex flex-col sm:flex-row gap-4 items-end max-w-md">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('app.current_password') }} <span class="text-rose-600">*</span></label>
                            <div class="relative">
            <input type="password" name="password" required
                                       class="w-full px-4 py-3 pr-12 rounded-xl bg-white dark:bg-slate-700 border border-rose-300 dark:border-rose-600 text-slate-900 dark:text-slate-100 outline-none focus:ring-2 ring-rose-500 focus:border-transparent transition-all duration-200">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500" @click="showDeletePassword = !showDeletePassword">
                                    <svg x-show="!showDeletePassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showDeletePassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
          </div>
          @error('password') <p class="text-rose-600 text-sm mt-2">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" 
                                class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-semibold shadow-lg shadow-rose-600/20 transition-all duration-200 hover:scale-105 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('app.delete_account') }}
                        </button>
                    </div>
        </form>
            </section>
      </div>
    </div>
  </div>
</div>
@endsection