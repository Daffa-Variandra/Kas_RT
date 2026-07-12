<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart RW - {{ auth()->user()->client->name ?? config('app.rt_identity') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden">
        </div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-800 text-white transition-transform duration-300 transform lg:static lg:inset-0 lg:translate-x-0 flex flex-col h-full">
            
            <div class="p-6 border-b border-emerald-600 flex items-center justify-between shrink-0">
                <div class="flex items-center">
                    <img src="{{ asset('img/logo.png') }}" class="w-10 h-10 mr-3 object-contain" alt="Logo">
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-wider leading-none text-white">Sistem Smart RW</span>
                        <span class="text-[10px] text-white font-medium mt-1 uppercase tracking-tight">
                            {{ auth()->user()->client->name ?? config('app.rt_identity') }}
                        </span>
                    </div>
                </div>

                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto scrollbar-hide">
                
                <a href="/dashboard" class="flex items-center py-2.5 px-4 rounded transition {{ request()->is('dashboard*') || request()->is('admin/dashboard') || request()->is('bendahara/dashboard') || request()->is('superadmin/dashboard') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                {{-- KATEGORI MASTER --}}
                @if(Auth::user()->hasRole('admin'))
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-emerald-500 font-semibold px-4 italic">📁 Master</span>
                </div>
                <a href="{{ route('admin.families.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.families.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Warga
                </a>
                <a href="{{ route('admin.assets.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.assets.*') || request()->routeIs('admin.asset_loans.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Inventaris & Aset
                </a>
                <a href="{{ route('admin.umkms.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.umkms.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Direktori UMKM
                </a>
                <a href="{{ route('admin.contributions.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.contributions.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Jenis Iuran
                </a>
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.staff.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.staff.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Pengurus
                </a>
                @endif
                @endif


                {{-- KATEGORI TRANSACTIONAL --}}
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-emerald-500 font-semibold px-4 italic">🔄 Transactional</span>
                </div>
                @if(Auth::user()->role == 'warga')
                <a href="{{ route('warga.payments.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.payments.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Tagihan & Bayar
                </a>
                @endif

                @if(Auth::user()->role == 'bendahara')
                <a href="{{ route('bendahara.verification.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('bendahara.verification.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Verifikasi Bayar
                </a>
                <a href="{{ route('bendahara.expenses.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('bendahara.expenses.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Pengeluaran Kas
                </a>
                @endif

                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.cooperative.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.cooperative.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Koperasi
                </a>
                <a href="{{ route('admin.trashbank.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.trashbank.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Bank Sampah
                </a>
                <a href="{{ route('admin.posyandu.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.posyandu.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    KMS Posyandu
                </a>
                <a href="{{ route('admin.letters.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.letters.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Surat Pengantar
                </a>
                <a href="{{ route('admin.complaints.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.complaints.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Aspirasi & Pengaduan
                </a>
                <a href="{{ route('admin.security.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.security.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Buku Tamu & Ronda
                </a>
                @endif
                
                @if(Auth::user()->role == 'warga')
                <a href="{{ route('warga.cooperative.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.cooperative.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Koperasi
                </a>
                <a href="{{ route('warga.trashbank.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.trashbank.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Bank Sampah
                </a>
                <a href="{{ route('warga.posyandu.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.posyandu.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    KMS Posyandu
                </a>
                <a href="{{ route('warga.letters.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.letters.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Surat Pengantar
                </a>
                <a href="{{ route('warga.complaints.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.complaints.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Aspirasi Warga
                </a>
                <a href="{{ route('warga.assets.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.assets.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Peminjaman Aset
                </a>
                <a href="{{ route('warga.security.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.security.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Keamanan & Ronda
                </a>
                @endif


                {{-- KATEGORI REPORT --}}
                @if(Auth::user()->role == 'bendahara')
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-emerald-500 font-semibold px-4 italic">📊 Report</span>
                </div>
                <a href="{{ route('bendahara.reports.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('bendahara.reports.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Kas
                </a>
                <a href="{{ route('bendahara.arrears.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('bendahara.arrears.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Rekap Tunggakan
                </a>
                @endif


                {{-- KATEGORI SETTING --}}
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-emerald-500 font-semibold px-4 italic">⚙️ Setting</span>
                </div>
                @if(Auth::user()->role == 'superadmin')
                <a href="{{ route('superadmin.clients.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('superadmin.clients.*') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Daftar Klien (RW)
                </a>
                @endif
                <a href="{{ Auth::user()->role === 'warga' ? route('warga.profile.edit') : route('profile.edit') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.profile.edit') || request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white' : 'text-white hover:bg-emerald-900 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Saya
                </a>

            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm flex items-center justify-between p-4 h-16 shrink-0">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    
                    <!-- Notification Bell -->
                    <div x-data="{ notifOpen: false }" class="relative">
                        <button @click="notifOpen = !notifOpen" class="relative p-2 text-gray-500 hover:text-emerald-600 transition focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="absolute top-1 right-1 flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                                </span>
                            @endif
                        </button>

                        <div x-show="notifOpen" 
                             @click.away="notifOpen = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden" style="display: none;">
                            <div class="p-4 bg-emerald-50 border-b border-emerald-100 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-emerald-800">Notifikasi</h3>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="text-xs bg-emerald-600 text-white px-2 py-1 rounded-full font-bold">{{ Auth::user()->unreadNotifications->count() }} Baru</span>
                                @endif
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @forelse(Auth::user()->notifications as $notification)
                                    <div class="p-4 border-b border-gray-50 {{ $notification->read_at ? 'opacity-50' : 'bg-white' }}">
                                        @php
                                            $statusColor = 'text-red-600';
                                            if (isset($notification->data['status'])) {
                                                if ($notification->data['status'] == 'success') $statusColor = 'text-green-600';
                                                elseif ($notification->data['status'] == 'pending') $statusColor = 'text-blue-600';
                                            }
                                        @endphp
                                        <p class="text-xs font-bold {{ $statusColor }}">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                        <p class="text-[10px] text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-gray-400 text-sm">
                                        Belum ada notifikasi.
                                    </div>
                                @endforelse
                            </div>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                            <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
                                <form method="POST" action="{{ route('notifications.markRead') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-emerald-600 font-bold hover:text-emerald-800 transition">Tandai Semua Sudah Dibaca</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Menu -->
                    <div x-data="{ profileOpen: false }" class="relative ml-4 flex items-center cursor-pointer" @click="profileOpen = !profileOpen" @click.away="profileOpen = false">
                        <div class="hidden sm:block text-right mr-3">
                            <p class="text-xs font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                            <span class="text-[9px] uppercase font-semibold text-emerald-600">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 hover:bg-emerald-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        
                        <div x-show="profileOpen" 
                             x-transition
                             class="absolute right-0 top-full mt-2 w-48 bg-white/80 backdrop-blur-md rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden" 
                             style="display: none;">
                            <div class="p-2">
                                <a href="{{ Auth::user()->role === 'warga' ? route('warga.profile.edit') : route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Profil
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" class="no-loading">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-6 relative">
                
                @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 3000)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-8"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform translate-x-8"
                         class="absolute top-6 right-6 z-50 flex items-center bg-green-500 rounded-xl shadow-xl shadow-green-200/50 px-4 py-3 min-w-[300px] border border-green-400">
                        
                        <div class="flex items-center justify-center w-8 h-8 bg-white/20 rounded-full mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="text-white">
                            <p class="text-[10px] font-black uppercase tracking-wider text-green-100">Berhasil</p>
                            <p class="text-sm font-bold">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="ml-auto text-green-100 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 5000)"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-8"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform translate-x-8"
                         class="absolute top-6 right-6 z-50 flex items-center bg-red-500 rounded-xl shadow-xl shadow-red-200/50 px-4 py-3 min-w-[300px] border border-red-400">
                        
                        <div class="flex items-center justify-center w-8 h-8 bg-white/20 rounded-full mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="text-white">
                            <p class="text-[10px] font-black uppercase tracking-wider text-red-100">Gagal</p>
                            <p class="text-sm font-bold">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="ml-auto text-red-100 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-8"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform translate-x-8"
                         class="absolute top-6 right-6 z-50 flex items-start bg-red-500 rounded-xl shadow-xl shadow-red-200/50 px-4 py-3 min-w-[300px] border border-red-400">
                        
                        <div class="flex items-center justify-center w-8 h-8 bg-white/20 rounded-full mr-3 mt-1">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="text-white flex-1 pr-4">
                            <p class="text-[10px] font-black uppercase tracking-wider text-red-100 mb-1">Validasi Gagal</p>
                            <ul class="text-xs font-semibold list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="ml-auto text-red-100 hover:text-white transition-colors mt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
    <!-- Global Loading Overlay -->
    <div x-data="{ loading: false }" 
         @form-submit.window="loading = true" 
         x-show="loading" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm"
         style="display: none;">
        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-emerald-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-sm font-bold text-gray-700">Sedang memproses...</p>
            <p class="text-[10px] text-gray-500 mt-1">Mohon tunggu sebentar</p>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        document.addEventListener('submit', function(e) {
            // Trigger loading animation for all forms unless specified otherwise
            if (e.target.tagName === 'FORM' && !e.target.classList.contains('no-loading')) {
                window.dispatchEvent(new CustomEvent('form-submit'));
            }
        });
    </script>
</body>
</html>
