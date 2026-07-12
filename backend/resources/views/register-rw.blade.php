<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Pengurus - {{ config('app.rt_identity') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-slate-50 selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <div class="w-full sm:max-w-4xl mx-auto px-4">
            
            <!-- Logo & Header -->
            <div class="text-center mb-10 mt-8 sm:mt-0">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 hover:opacity-80 transition">
                    <img src="{{ asset('img/logo.png') }}" class="h-12 w-12 object-contain" alt="Logo">
                    <span class="font-black text-3xl tracking-tight text-slate-800">Warga<span class="text-emerald-600">Hub</span>.</span>
                </a>
                <h1 class="text-3xl font-black text-slate-900 mt-6 tracking-tight">Daftarkan Lingkungan Anda</h1>
                <p class="text-slate-500 font-medium mt-2">Buat akun pengurus RW pertama dan nikmati kemudahan digitalisasi administrasi.</p>
            </div>

            <!-- Card Form -->
            <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100 flex flex-col md:flex-row mb-12">
                
                <!-- Sisi Kiri (Info) -->
                <div class="md:w-5/12 bg-emerald-600 p-10 flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-500 rounded-full blur-3xl opacity-50"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 bg-emerald-700 rounded-full blur-3xl opacity-50"></div>
                    
                    <div class="relative z-10 text-white">
                        <h3 class="text-2xl font-black mb-6">Mengapa bergabung?</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="bg-emerald-500 rounded-lg p-2 mr-4 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">Keuangan Terkontrol</h4>
                                    <p class="text-emerald-100 text-sm mt-1">Laporan transparan yang bisa diakses warga kapan saja.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-emerald-500 rounded-lg p-2 mr-4 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">Database Kependudukan</h4>
                                    <p class="text-emerald-100 text-sm mt-1">Satu pintu untuk arsip data kepala keluarga dan anggota.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="bg-emerald-500 rounded-lg p-2 mr-4 mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">Proses Otomatis</h4>
                                    <p class="text-emerald-100 text-sm mt-1">Tagihan dan laporan terekap otomatis tanpa input manual.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan (Form) -->
                <div class="md:w-7/12 p-8 lg:p-12">
                    
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold border border-red-100 flex items-start">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold border border-red-100">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Pendaftaran Gagal:
                            </div>
                            <ul class="list-disc list-inside space-y-1 ml-1 text-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register-rw.store') }}">
                        @csrf
                        
                        <!-- Bagian Data Organisasi -->
                        <div class="mb-8">
                            <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">Informasi Organisasi / RW</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Nama RW / Lingkungan</label>
                                    <input type="text" name="client_name" value="{{ old('client_name') }}" required 
                                           class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                           placeholder="Contoh: Rukun Warga 05 Taman Elok">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Alamat Lengkap</label>
                                    <textarea name="client_address" rows="2" required 
                                              class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition resize-none"
                                              placeholder="Jl. Raya Perumahan Taman Elok No. 1, Jakarta"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Data Akun -->
                        <div>
                            <h3 class="text-sm font-black text-emerald-600 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">Akun Admin Pertama</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Nama Lengkap Admin</label>
                                    <input type="text" name="admin_name" value="{{ old('admin_name') }}" required 
                                           class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                           placeholder="Budi Santoso">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Email Login</label>
                                    <input type="email" name="admin_email" value="{{ old('admin_email') }}" required 
                                           class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                           placeholder="admin@rw05.com">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Password</label>
                                        <input type="password" name="admin_password" required minlength="8"
                                               class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                               placeholder="Minimal 8 karakter">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Ulangi Password</label>
                                        <input type="password" name="admin_password_confirmation" required minlength="8"
                                               class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition"
                                               placeholder="Ketik ulang password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-xs text-slate-500 font-medium w-full sm:w-1/2">
                                Sudah punya akun RW? <br class="hidden sm:block">
                                <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Masuk di sini</a>
                            </p>
                            
                            <button type="submit" class="w-full sm:w-1/2 flex justify-center py-4 px-6 rounded-xl shadow-lg shadow-emerald-200 text-sm font-black text-white bg-emerald-600 hover:bg-emerald-700 uppercase tracking-widest transition duration-200 transform hover:-translate-y-0.5">
                                DAFTAR SEKARANG
                            </button>
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
