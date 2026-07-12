<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Smart RW & RW Modern - {{ config('app.rt_identity') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .blob-shape {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-slate-50 selection:bg-emerald-500 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" class="h-10 w-10 object-contain" alt="Logo">
                    <span class="font-black text-2xl tracking-tight text-slate-800">Warga<span class="text-emerald-600">Hub</span>.</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fitur" class="text-sm font-bold text-slate-600 hover:text-emerald-600 transition">Fitur</a>
                    <a href="#manfaat" class="text-sm font-bold text-slate-600 hover:text-emerald-600 transition">Manfaat</a>
                    <a href="#testimoni" class="text-sm font-bold text-slate-600 hover:text-emerald-600 transition">Testimoni</a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-emerald-600 transition hidden sm:block">Masuk</a>
                    <a href="{{ route('register-rw') }}" class="px-6 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-lg shadow-emerald-200 transition transform hover:-translate-y-0.5">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] opacity-30 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-300 rounded-full blur-3xl blob-shape"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase tracking-widest mb-8 border border-emerald-200">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                    Sistem Digitalisasi Rukun Tetangga #1
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.1] mb-8">
                    Kelola Kas & Warga <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Lebih Transparan & Mudah</span>
                </h1>
                
                <p class="text-lg lg:text-xl text-slate-600 font-medium mb-10 max-w-2xl mx-auto leading-relaxed">
                    Tinggalkan buku catatan manual. Pantau pembayaran iuran bulanan, kelola data kependudukan warga, dan sajikan laporan keuangan transparan dalam satu aplikasi canggih.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register-rw') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold shadow-xl shadow-emerald-200 transition transform hover:-translate-y-1">
                        Daftarkan Lingkungan Saya
                    </a>
                    <a href="#fitur" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white hover:bg-slate-50 text-slate-700 text-lg font-bold shadow-lg shadow-slate-200/50 border border-slate-100 transition">
                        Pelajari Fitur
                    </a>
                </div>
            </div>
            
            <!-- Dashboard Preview Image -->
            <div class="mt-20 relative mx-auto max-w-5xl">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-[2.5rem] blur-xl opacity-30"></div>
                <div class="relative bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden p-2">
                    <div class="bg-slate-50 rounded-2xl h-[450px] lg:h-[600px] flex overflow-hidden border border-slate-200 shadow-inner text-left">
                        <!-- Sidebar Mockup -->
                        <div class="w-16 lg:w-56 bg-emerald-800 flex-shrink-0 flex flex-col">
                            <div class="h-16 flex items-center justify-center lg:justify-start lg:px-4 border-b border-emerald-700/50">
                                <div class="w-8 h-8 rounded-full bg-white/20 flex-shrink-0 flex items-center justify-center text-white text-xs font-bold">W</div>
                                <div class="hidden lg:block ml-3">
                                    <div class="text-white font-bold text-sm tracking-wide">Smart RW</div>
                                    <div class="text-emerald-300 text-[10px]">RT 005 TAMAN ELOK</div>
                                </div>
                            </div>
                            <div class="p-3 space-y-2 flex-1 mt-4">
                                <div class="w-10 lg:w-full h-10 rounded-lg bg-emerald-700 lg:flex lg:items-center lg:px-3 mx-auto lg:mx-0">
                                    <div class="w-4 h-4 rounded-sm bg-emerald-400 hidden lg:block mr-3"></div>
                                    <div class="hidden lg:block w-20 h-2.5 rounded bg-white"></div>
                                </div>
                                <div class="px-2 mt-4 mb-2 hidden lg:block text-[9px] text-emerald-400 font-bold uppercase tracking-wider">Pelayanan & Keamanan</div>
                                <div class="w-8 lg:w-full h-8 rounded-md hover:bg-emerald-700/50 lg:flex lg:items-center lg:px-3 mx-auto lg:mx-0">
                                    <div class="w-3.5 h-3.5 rounded-sm bg-emerald-600/50 hidden lg:block mr-3"></div>
                                    <div class="hidden lg:block w-24 h-2 rounded bg-emerald-100/70"></div>
                                </div>
                                <div class="w-8 lg:w-full h-8 rounded-md hover:bg-emerald-700/50 lg:flex lg:items-center lg:px-3 mx-auto lg:mx-0">
                                    <div class="w-3.5 h-3.5 rounded-sm bg-emerald-600/50 hidden lg:block mr-3"></div>
                                    <div class="hidden lg:block w-28 h-2 rounded bg-emerald-100/70"></div>
                                </div>
                                <div class="w-8 lg:w-full h-8 rounded-md hover:bg-emerald-700/50 lg:flex lg:items-center lg:px-3 mx-auto lg:mx-0">
                                    <div class="w-3.5 h-3.5 rounded-sm bg-emerald-600/50 hidden lg:block mr-3"></div>
                                    <div class="hidden lg:block w-20 h-2 rounded bg-emerald-100/70"></div>
                                </div>
                                <div class="px-2 mt-4 mb-2 hidden lg:block text-[9px] text-emerald-400 font-bold uppercase tracking-wider">Ekonomi Warga</div>
                                <div class="w-8 lg:w-full h-8 rounded-md hover:bg-emerald-700/50 lg:flex lg:items-center lg:px-3 mx-auto lg:mx-0">
                                    <div class="w-3.5 h-3.5 rounded-sm bg-emerald-600/50 hidden lg:block mr-3"></div>
                                    <div class="hidden lg:block w-20 h-2 rounded bg-emerald-100/70"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Main Content Mockup -->
                        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative">
                            <!-- Header Bar -->
                            <div class="h-14 bg-white border-b border-slate-200 flex justify-between items-center px-6 flex-shrink-0">
                                <div class="text-sm font-bold text-slate-700 hidden sm:block">Dashboard Admin - Smart RW</div>
                                <div class="w-32 h-4 rounded bg-slate-200 sm:hidden"></div>
                                <div class="flex items-center gap-4">
                                    <div class="w-6 h-6 rounded-full bg-slate-100"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="hidden md:flex flex-col items-end">
                                            <div class="w-16 h-2.5 rounded bg-slate-800 mb-1"></div>
                                            <div class="w-10 h-2 rounded bg-emerald-500"></div>
                                        </div>
                                        <div class="w-8 h-8 rounded-full bg-emerald-100"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content Area -->
                            <div class="p-4 lg:p-6 flex-1 overflow-y-auto space-y-4 lg:space-y-6">
                                
                                <!-- Stats Grid (4 cards) -->
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Card 1 -->
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 rounded-bl-[2rem]">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Warga</div>
                                        <div class="flex items-baseline gap-1 mb-1">
                                            <div class="text-2xl font-black text-slate-800">18</div>
                                            <div class="text-xs text-slate-500">Jiwa</div>
                                        </div>
                                        <div class="text-[10px] text-slate-400">Dari 15 Kepala Keluarga</div>
                                    </div>
                                    <!-- Card 2 -->
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 rounded-bl-[2rem]">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Surat Pengantar</div>
                                        <div class="flex items-baseline gap-1 mb-1">
                                            <div class="text-2xl font-black text-slate-800">0</div>
                                            <div class="text-xs text-slate-500">Menunggu</div>
                                        </div>
                                        <div class="text-[10px] font-bold text-orange-500">Lihat Detail →</div>
                                    </div>
                                    <!-- Card 3 -->
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 rounded-bl-[2rem] hidden lg:block">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Aspirasi Warga</div>
                                        <div class="flex items-baseline gap-1 mb-1">
                                            <div class="text-2xl font-black text-slate-800">0</div>
                                            <div class="text-xs text-slate-500">Masuk</div>
                                        </div>
                                        <div class="text-[10px] font-bold text-red-500">Tindak lanjuti →</div>
                                    </div>
                                    <!-- Card 4 -->
                                    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 rounded-bl-[2rem] hidden lg:block">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Aset Dipinjam</div>
                                        <div class="flex items-baseline gap-1 mb-1">
                                            <div class="text-2xl font-black text-slate-800 text-purple-600">1</div>
                                            <div class="text-xs text-slate-500">Aktif</div>
                                        </div>
                                        <div class="text-[10px] font-bold text-purple-600">Cek Status →</div>
                                    </div>
                                </div>
                                
                                <!-- Monitoring Ekosistem -->
                                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="font-bold text-slate-800">Monitoring Ekosistem Warga</h3>
                                        <div class="text-[10px] font-bold text-slate-400">RINGKASAN</div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                                        <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-xl">
                                            <div class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mb-1">Total Smart RW</div>
                                            <div class="text-lg font-black text-emerald-700">Rp 25.000</div>
                                        </div>
                                        <div class="bg-teal-50 border border-teal-100 p-4 rounded-xl">
                                            <div class="text-[9px] font-bold text-teal-600 uppercase tracking-widest mb-1">Bank Sampah</div>
                                            <div class="text-lg font-black text-teal-700">4,0 Kg</div>
                                            <div class="text-[10px] text-teal-600 mt-1">Rp 1.500</div>
                                        </div>
                                        <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-xl hidden md:block">
                                            <div class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mb-1">Koperasi (Simpanan)</div>
                                            <div class="text-lg font-black text-indigo-700">Rp 1.500</div>
                                            <div class="text-[10px] text-indigo-600 mt-1">Pinjaman: Rp 5.333.333</div>
                                        </div>
                                        <div class="bg-rose-50 border border-rose-100 p-4 rounded-xl hidden md:block">
                                            <div class="text-[9px] font-bold text-rose-600 uppercase tracking-widest mb-1">Riwayat Posyandu</div>
                                            <div class="text-lg font-black text-rose-700">1</div>
                                            <div class="text-[10px] text-rose-600 mt-1">Pemeriksaan Tercatat</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Charts Area -->
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <div class="lg:col-span-2 bg-white p-5 rounded-2xl shadow-sm border border-slate-100 h-48 relative overflow-hidden hidden sm:block">
                                        <h3 class="font-bold text-slate-800 text-sm mb-4">Aktivitas Layanan (6 Bulan)</h3>
                                        <div class="absolute bottom-0 left-0 w-full h-32 flex items-end">
                                            <svg viewBox="0 0 100 40" class="w-full h-full preserve-3d" preserveAspectRatio="none">
                                                <path d="M0 40 L0 38 L20 38 L40 38 L60 38 L80 30 L100 20 L100 40 Z" fill="rgba(59, 130, 246, 0.2)" />
                                                <path d="M0 38 L20 38 L40 38 L60 38 L80 30 L100 20" fill="none" stroke="#3b82f6" stroke-width="1" />
                                                
                                                <path d="M0 40 L0 38 L20 38 L40 38 L60 35 L80 20 L100 5 L100 40 Z" fill="rgba(239, 68, 68, 0.2)" />
                                                <path d="M0 38 L20 38 L40 38 L60 35 L80 20 L100 5" fill="none" stroke="#ef4444" stroke-width="1" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 h-48 flex flex-col items-center justify-center">
                                        <h3 class="font-bold text-slate-800 text-sm self-start mb-2">Demografi Hunian</h3>
                                        <div class="w-24 h-24 rounded-full border-[8px] border-teal-600 border-t-amber-500 transform rotate-45 mb-2 relative">
                                            <div class="absolute inset-0 bg-white m-1 rounded-full"></div>
                                        </div>
                                        <div class="flex gap-4 text-[10px]">
                                            <span class="flex items-center gap-1"><div class="w-2 h-2 bg-teal-600"></div> Tetap</span>
                                            <span class="flex items-center gap-1"><div class="w-2 h-2 bg-amber-500"></div> Kontrak</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-emerald-600 font-black text-sm uppercase tracking-widest mb-2">Fitur Unggulan</h2>
                <h3 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight mb-6">Ekosistem lengkap untuk lingkungan Anda.</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Fitur Kas -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Keuangan Kas</h4>
                    <p class="text-slate-600 font-medium text-sm">Catat iuran bulanan dan pengeluaran secara digital. Transparansi otomatis untuk seluruh warga.</p>
                </div>

                <!-- Fitur Kependudukan -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Data Warga Terpusat</h4>
                    <p class="text-slate-600 font-medium text-sm">Kelola data Kepala Keluarga dan anggota secara terstruktur. Mudah untuk sensus tingkat lingkungan.</p>
                </div>

                <!-- Fitur Surat -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-6 group-hover:bg-orange-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Surat Pengantar</h4>
                    <p class="text-slate-600 font-medium text-sm">Warga bisa memohon surat pengantar secara online, cetak instan dengan tanda tangan digital.</p>
                </div>

                <!-- Fitur Aspirasi -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 mb-6 group-hover:bg-red-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Aspirasi & Pengaduan</h4>
                    <p class="text-slate-600 font-medium text-sm">Wadah keluhan warga terkait fasilitas, keamanan, atau kebersihan yang bisa ditanggapi langsung oleh Pengurus.</p>
                </div>

                <!-- Fitur Aset -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6 group-hover:bg-purple-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Peminjaman Aset</h4>
                    <p class="text-slate-600 font-medium text-sm">Inventarisasi tenda, kursi, dll. Warga bisa memesan aset langsung dari ponsel mereka.</p>
                </div>

                <!-- Fitur Bank Sampah -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-6 group-hover:bg-green-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Bank Sampah</h4>
                    <p class="text-slate-600 font-medium text-sm">Fasilitas setor sampah warga yang terkonversi menjadi tabungan digital. Lingkungan bersih, warga untung.</p>
                </div>

                <!-- Fitur Koperasi -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Koperasi & UMKM</h4>
                    <p class="text-slate-600 font-medium text-sm">Dukung ekonomi warga dengan direktori UMKM lokal dan fasilitas pinjaman/simpanan Koperasi.</p>
                </div>

                <!-- Fitur Posyandu -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center text-pink-600 mb-6 group-hover:bg-pink-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Rekam Posyandu</h4>
                    <p class="text-slate-600 font-medium text-sm">Catat tumbuh kembang balita dan pemantauan lansia secara digital yang terintegrasi profil keluarga.</p>
                </div>

                <!-- Fitur Keamanan -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 group">
                    <div class="w-14 h-14 bg-slate-200 rounded-2xl flex items-center justify-center text-slate-600 mb-6 group-hover:bg-slate-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Buku Tamu & Ronda</h4>
                    <p class="text-slate-600 font-medium text-sm">Jadwal keamanan lingkungan dan log tamu masuk/keluar terpantau 24/7 di sistem warga.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Manfaat Section -->
    <section id="manfaat" class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <h2 class="text-emerald-600 font-black text-sm uppercase tracking-widest mb-2">Kenapa Memilih Kami?</h2>
                    <h3 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight mb-6 leading-tight">Digitalisasi untuk kerukunan dan kepercayaan.</h3>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">Sistem kami dibangun berdasarkan keluhan umum para pengurus. Tidak ada lagi catatan buku yang hilang, kas yang tidak sinkron, atau warga yang bingung alur pengurusan surat.</p>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-slate-800">Bebas Konflik Uang Kas</h4>
                                <p class="text-slate-500 mt-1">Sistem pencatatan terpusat dan verifikasi otomatis yang meminimalkan salah paham keuangan.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-slate-800">Layanan Warga 24 Jam</h4>
                                <p class="text-slate-500 mt-1">Warga bisa request layanan pengantar dari HP mereka kapanpun tanpa harus menunggu RT di sekretariat.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-slate-800">Hemat Biaya Operasional</h4>
                                <p class="text-slate-500 mt-1">Kurangi penggunaan kertas untuk laporan, undangan rapat, dan formulir birokrasi konvensional.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-emerald-400 rounded-[3rem] blur-2xl opacity-20 transform rotate-6"></div>
                    <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?q=80&w=1000&auto=format&fit=crop" class="relative rounded-[2rem] shadow-2xl border-4 border-white object-cover h-[500px] w-full" alt="Warga tersenyum menggunakan HP">
                    
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 animate-bounce">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Tingkat Kepuasan</p>
                                <p class="text-2xl font-black text-slate-800">98% Warga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section id="testimoni" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-emerald-600 font-black text-sm uppercase tracking-widest mb-2">Suara Mereka</h2>
                <h3 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight mb-6">Dipercaya oleh ribuan rukun tetangga.</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Review 1 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <div class="flex text-amber-400 mb-4">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <p class="text-slate-700 italic mb-6">"Sangat membantu! Warga jadi nggak ada yang alasan lupa bayar iuran keamanan karena sistem ini punya reminder dan riwayat yang jelas. Laporan bulanan tinggal sekali klik."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center font-bold text-emerald-800">B</div>
                        <div>
                            <h5 class="font-black text-slate-900">Bapak Susanto</h5>
                            <p class="text-xs text-slate-500 font-bold">Ketua Lingkungan 05 - Jakarta</p>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="bg-emerald-600 text-white p-8 rounded-3xl shadow-xl shadow-emerald-200 relative overflow-hidden transform md:-translate-y-4">
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 text-emerald-500 opacity-50">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <div class="flex text-amber-300 mb-4 relative z-10">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <p class="italic mb-6 relative z-10 text-emerald-50 leading-relaxed">"Sekarang mengajukan surat pengantar jadi super praktis. Nggak usah bolak-balik ke rumah Pengurus karena bisa diajukan via HP. Program Bank Sampahnya juga sangat menguntungkan."</p>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center font-bold text-emerald-600">L</div>
                        <div>
                            <h5 class="font-black text-white">Lina Marlina</h5>
                            <p class="text-xs text-emerald-200 font-bold">Warga - Bekasi</p>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <div class="flex text-amber-400 mb-4">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <p class="text-slate-700 italic mb-6">"Saya sangat tertolong sebagai bendahara. Dulu harus nulis di buku kas berlembar-lembar, sekarang sistem otomatis hitung siapa aja yang nunggak bayar tiap bulannya."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center font-bold text-emerald-800">A</div>
                        <div>
                            <h5 class="font-black text-slate-900">Ahmad Fauzi</h5>
                            <p class="text-xs text-slate-500 font-bold">Bendahara Lingkungan - Bandung</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-emerald-600/20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-6">Siap memodernisasi lingkungan Anda?</h2>
            <p class="text-xl text-slate-300 font-medium mb-10">Daftarkan RW/Lingkungan Anda sekarang dan nikmati kemudahan pengelolaan warga dalam satu platform yang aman dan profesional.</p>
            
            <a href="{{ route('register-rw') }}" class="inline-flex items-center px-8 py-4 rounded-full bg-emerald-500 hover:bg-emerald-400 text-slate-900 text-lg font-black shadow-xl shadow-emerald-500/30 transition transform hover:-translate-y-1">
                Mulai Gratis Sekarang
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-xs">WH</span>
                </div>
                <span class="font-bold text-xl tracking-tight text-white">Warga<span class="text-emerald-500">Hub</span>.</span>
            </div>
            
            <p class="text-slate-500 font-medium text-sm text-center md:text-left">
                &copy; {{ date('Y') }} Sistem Smart RW/RW Modern. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer>

</body>
</html>
