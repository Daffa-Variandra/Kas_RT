<x-sidebar-layout>
    <x-slot name="header">
        Dashboard SuperAdmin
    </x-slot>

    <div class="mb-8">
        <h3 class="text-2xl font-black text-gray-800 tracking-tight">SaaS Overview</h3>
        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">Ringkasan Ekosistem Aplikasi Smart RW</p>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 border-l-4 border-teal-500 shadow-xl shadow-teal-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Klien (RW)</p>
                <h3 class="text-4xl font-black text-gray-800">{{ $totalClients }}</h3>
            </div>
            <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border-l-4 border-green-500 shadow-xl shadow-green-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Klien Aktif</p>
                <h3 class="text-4xl font-black text-gray-800">{{ $activeClients }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border-l-4 border-emerald-500 shadow-xl shadow-emerald-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Users</p>
                <h3 class="text-4xl font-black text-gray-800">{{ $totalUsers }}</h3>
            </div>
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-xl shadow-gray-200 lg:col-span-2">
            <h4 class="text-lg font-bold text-gray-800 mb-4">Pertumbuhan Klien (6 Bulan)</h4>
            <div class="h-64 relative">
                <canvas id="chartClients"></canvas>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 shadow-xl shadow-gray-300 text-white flex flex-col justify-center relative overflow-hidden">
            <div class="relative z-10">
                <h4 class="text-xl font-bold mb-2">Selamat Datang di Panel SaaS</h4>
                <p class="text-gray-300 text-sm leading-relaxed">Ini adalah panel khusus bagi pemilik aplikasi untuk mengelola seluruh Klien/RW yang menggunakan aplikasi ini. Navigasikan ke menu <b class="text-teal-400">Daftar Klien (RW)</b> untuk menambah atau memblokir akses Klien tertentu.</p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-teal-500/20 rounded-full blur-2xl"></div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chartClients').getContext('2d');
            
            const gradientLine = ctx.createLinearGradient(0, 0, 0, 400);
            gradientLine.addColorStop(0, 'rgba(20, 184, 166, 0.5)'); // Teal 500
            gradientLine.addColorStop(1, 'rgba(20, 184, 166, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Klien Baru',
                        data: @json($chartValues),
                        borderColor: '#14b8a6', // Teal 500
                        backgroundColor: gradientLine,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#14b8a6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: 'rgba(0,0,0,0.8)', padding: 12, cornerRadius: 8 }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f4f6', borderDash: [5, 5] }, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
    @endpush
</x-sidebar-layout>
