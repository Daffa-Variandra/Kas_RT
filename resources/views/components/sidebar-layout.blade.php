<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kas RT - {{ config('app.rt_identity') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden">
        </div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-30 w-64 bg-amber-900 text-white transition-transform duration-300 transform lg:static lg:inset-0 lg:translate-x-0">
            
            <div class="p-6 border-b border-amber-800 flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('img/logo.png') }}" class="w-10 h-10 mr-3 object-contain" alt="Logo">
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-wider leading-none text-white">Sistem KAS RT</span>
                        <span class="text-[10px] text-white font-medium mt-1 uppercase tracking-tight">
                            {{ config('app.rt_identity') }}
                        </span>
                    </div>
                </div>

                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                
                <a href="/dashboard" class="flex items-center py-2.5 px-4 rounded transition {{ request()->is('dashboard*') || request()->is('admin/dashboard') ? 'bg-amber-800 text-white' : 'text-white hover:bg-amber-950 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                @if(Auth::user()->role == 'admin')
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-amber-500 font-semibold px-4 italic">Menu Admin</span>
                </div>
                <a href="{{ route('admin.residents.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.residents.*') ? 'bg-amber-800 text-white' : 'text-white hover:bg-amber-950 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Data Warga
                </a>
                <a href="{{ route('admin.contributions.index') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('admin.contributions.*') ? 'bg-amber-800 text-white' : 'text-white hover:bg-amber-950 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Jenis Iuran
                </a>
                @endif

                @if(Auth::user()->role == 'bendahara')
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-amber-500 font-semibold px-4 italic">Keuangan</span>
                </div>
                <a href="{{ route('bendahara.verification.index') }}" class="flex items-center py-2.5 px-4 rounded-xl transition {{ request()->routeIs('bendahara.verification.*') ? 'bg-amber-800 text-white shadow-lg' : 'text-white hover:bg-amber-950 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Verifikasi Bayar
                </a>
                <a href="{{ route('bendahara.reports.index') }}" class="flex items-center py-2.5 px-4 rounded-xl transition {{ request()->routeIs('bendahara.reports.*') ? 'bg-amber-800 text-white shadow-lg' : 'text-white hover:bg-amber-950 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Kas
                </a>
                @endif

                @if(Auth::user()->role == 'warga')
                <div class="pt-4 pb-2">
                    <span class="text-xs uppercase text-amber-500 font-semibold px-4 italic">Menu Warga</span>
                </div>
                <a href="{{ route('warga.profile.edit') }}" class="flex items-center py-2.5 px-4 rounded transition {{ request()->routeIs('warga.profile.*') ? 'bg-amber-800 text-white' : 'text-white hover:bg-amber-950 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>
                <a href="{{ route('warga.payments.index') }}" class="flex items-center py-2.5 px-4 rounded transition text-white hover:bg-amber-950 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Bayar Iuran
                </a>
               
                @endif

            </nav>

            <div class="p-4 border-t border-amber-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 text-red-300 hover:text-red-100 flex items-center transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm flex items-center justify-between p-4 h-16">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                <div class="flex items-center space-x-2">
                    <div class="hidden sm:block text-right mr-2">
                        <p class="text-xs font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                        <span class="text-[9px] uppercase font-semibold text-amber-600">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>