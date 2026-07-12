<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.rt_identity', 'Smart RW') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen flex flex-col justify-center items-center py-10 px-4">
        
        <div class="w-full max-w-5xl mx-auto">
            
            <!-- Logo & Header -->
            <div class="text-center mb-10">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 hover:opacity-80 transition">
                    <img src="{{ asset('img/logo.png') }}" class="h-12 w-12 object-contain" alt="Logo">
                    <span class="font-black text-3xl tracking-tight text-slate-800">Warga<span class="text-emerald-600">Hub</span>.</span>
                </a>
                <h1 class="text-3xl font-black text-slate-900 mt-6 tracking-tight">Selamat Datang Kembali</h1>
                <p class="text-slate-500 font-medium mt-2">Silakan masuk ke akun Anda untuk melanjutkan pengelolaan lingkungan.</p>
            </div>

            <!-- Card Form -->
            <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100 flex flex-col lg:flex-row mb-12">
                
                <!-- Sisi Kiri (Info) -->
                <div class="lg:w-5/12 bg-emerald-600 p-8 lg:p-12 flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-500 rounded-full blur-3xl opacity-50"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 bg-emerald-700 rounded-full blur-3xl opacity-50"></div>
                    
                    <div class="relative z-10 text-white text-center lg:text-left">
                        <div class="bg-white/20 p-4 rounded-3xl backdrop-blur-sm inline-block mb-8 mx-auto lg:mx-0">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        </div>
                        <h3 class="text-3xl font-black mb-4 tracking-tight">Akses Aman & Terenkripsi</h3>
                        <p class="text-emerald-100 text-sm leading-relaxed mb-8">
                            Sistem Smart RW dilengkapi standar keamanan tinggi untuk menjaga kerahasiaan data kependudukan dan transparansi finansial lingkungan Anda.
                        </p>
                        
                        <div class="flex items-center justify-center lg:justify-start gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span>
                            <span class="text-xs font-bold text-emerald-200 tracking-wider uppercase">Sistem Aktif 24/7</span>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan (Form Login) -->
                <div class="lg:w-7/12 p-8 lg:p-14 flex flex-col justify-center">
                    
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest mb-6 border-b border-slate-100 pb-3">Kredensial Login</h3>
                            
                            <div class="space-y-5">
                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Email Address</label>
                                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                                           class="w-full px-5 py-3.5 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                           placeholder="nama@email.com">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs font-bold" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 gap-2">
                                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Password</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 uppercase tracking-wider bg-emerald-50 px-2 py-1 rounded-md">Lupa Password?</a>
                                        @endif
                                    </div>
                                    <input id="password" type="password" name="password" required 
                                           class="w-full px-5 py-3.5 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                           placeholder="••••••••">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs font-bold" />
                                </div>
                                
                                <!-- Remember Me -->
                                <div class="flex items-center pt-3">
                                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded transition cursor-pointer">
                                    <label for="remember_me" class="ml-3 block text-xs font-bold text-slate-600 cursor-pointer">Ingat saya di perangkat ini</label>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="mt-10 pt-8 border-t border-slate-100 flex flex-col gap-6">
                            <button type="submit" class="w-full flex justify-center items-center py-4 px-6 rounded-xl shadow-lg shadow-emerald-200 text-sm font-black text-white bg-emerald-600 hover:bg-emerald-700 uppercase tracking-widest transition duration-200 transform hover:-translate-y-0.5">
                                MASUK SEKARANG
                            </button>
                            <p class="text-sm text-slate-500 font-medium text-center">
                                Belum punya akun? <a href="#" class="text-emerald-600 font-bold hover:underline">Lapor ke Pengurus Lingkungan</a> setempat.
                            </p>
                        </div>
                    </form>

                </div>
            </div>
            
            <div class="text-center pb-8">
                <a href="{{ route('landing') }}" class="text-sm font-bold text-slate-500 hover:text-emerald-600 transition flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</body>
</html>