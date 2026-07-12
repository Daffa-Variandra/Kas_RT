<x-sidebar-layout>
    <x-slot name="header">
        Dashboard Bendahara - {{ auth()->user()->client->name ?? config('app.rt_identity') }} 
    </x-slot>

    <div class="space-y-6">
        <div class="bg-gradient-to-r from-teal-600 to-emerald-700 rounded-3xl p-8 text-white shadow-xl shadow-teal-100/50 relative overflow-hidden">
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black">Halo, {{ Auth::user()->name }} 👋</h2>
                    <p class="text-teal-100 text-sm mt-1">Pantau arus kas dan verifikasi iuran warga.</p>
                </div>

            </div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-teal-800/20 rounded-full blur-xl"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-green-500 text-white p-6 rounded-3xl shadow-sm border border-green-600 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-green-600 rounded-bl-full -z-10 group-hover:bg-green-400 transition-colors"></div>
                <h3 class="text-green-100 text-[10px] font-black uppercase tracking-widest">Pemasukan Bulan Ini</h3>
                <p class="text-3xl font-black text-white mt-2">Rp {{ number_format($data['pemasukan_bulan_ini'], 0, ',', '.') }}</p>
                <p class="text-xs text-green-100 mt-1">Berhasil terverifikasi</p>
            </div>

            <div class="bg-red-500 text-white p-6 rounded-3xl shadow-sm border border-red-600 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-600 rounded-bl-full -z-10 group-hover:bg-red-400 transition-colors"></div>
                <h3 class="text-red-100 text-[10px] font-black uppercase tracking-widest">Total Pengeluaran</h3>
                <p class="text-3xl font-black text-white mt-2">-Rp {{ number_format($data['total_pengeluaran'], 0, ',', '.') }}</p>
                <p class="text-xs text-red-100 mt-1">Total dana keluar</p>
            </div>

            <div class="bg-gray-900 text-white p-6 rounded-3xl shadow-sm border border-gray-800 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gray-800 rounded-bl-full -z-10 group-hover:bg-gray-700 transition-colors"></div>
                <h3 class="text-gray-300 text-[10px] font-black uppercase tracking-widest">Saldo Kas Akhir</h3>
                <p class="text-3xl font-black text-white mt-2">Rp {{ number_format($data['saldo_akhir'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Net balance</p>
            </div>
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -z-10 group-hover:bg-amber-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Menunggu Verifikasi</h3>
                <p class="text-3xl font-black {{ $data['perlu_verifikasi'] > 0 ? 'text-amber-500' : 'text-gray-800' }} mt-2">
                    {{ $data['perlu_verifikasi'] }} <span class="text-sm text-gray-400 font-medium">Transaksi</span>
                </p>
                <a href="{{ route('bendahara.verification.index') }}" class="text-xs text-amber-600 font-bold mt-2 inline-block hover:underline">Periksa Sekarang &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-rose-50 rounded-bl-full -z-10 group-hover:bg-rose-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Tunggakan Warga</h3>
                <p class="text-3xl font-black {{ $data['tunggakan_bulan_ini'] > 0 ? 'text-rose-500' : 'text-gray-800' }} mt-2">
                    {{ $data['tunggakan_bulan_ini'] }} <span class="text-sm text-gray-400 font-medium">KK</span>
                </p>
                <p class="text-xs text-gray-500 mt-1">Belum bayar bulan berjalan</p>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-center items-center text-center hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <h3 class="text-gray-800 font-black">Laporan Keuangan</h3>
                <a href="{{ route('bendahara.reports.index') }}" class="text-xs text-teal-600 font-bold mt-2 hover:underline">Cetak PDF / Excel &rarr;</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
            <!-- Bar Chart Pemasukan -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-800 font-black text-lg">Tren Pemasukan Kas (6 Bulan)</h3>
                    <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-full uppercase">Verified Only</span>
                </div>
                <div class="h-64 relative">
                    <canvas id="chartIncome"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart Komposisi Pemasukan -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-gray-800 font-black text-lg mb-1">Komposisi Kas</h3>
                <p class="text-xs text-gray-400 mb-6">Sumber dana kas saat ini.</p>
                <div class="h-56 flex justify-center relative">
                    <canvas id="chartComposition"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Income Bar Chart
            const incomeCtx = document.getElementById('chartIncome').getContext('2d');
            
            const gradientBar = incomeCtx.createLinearGradient(0, 0, 0, 400);
            gradientBar.addColorStop(0, 'rgba(16, 185, 129, 0.9)'); // Emerald
            gradientBar.addColorStop(1, 'rgba(20, 184, 166, 0.6)'); // Teal

            new Chart(incomeCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartIncomeLabels),
                    datasets: [{
                        label: 'Pemasukan (Rp)',
                        data: @json($chartIncomeValues),
                        backgroundColor: gradientBar,
                        hoverBackgroundColor: 'rgba(5, 150, 105, 1)', // Emerald 600
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)', padding: 12, cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6', borderDash: [5, 5] },
                            ticks: {
                                callback: function(value) {
                                    if(value >= 1000000) return (value / 1000000) + ' Jt';
                                    if(value >= 1000) return (value / 1000) + ' Rb';
                                    return value;
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Composition Doughnut Chart
            const compCtx = document.getElementById('chartComposition').getContext('2d');
            new Chart(compCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($chartCompositionLabels),
                    datasets: [{
                        data: @json($chartCompositionValues),
                        backgroundColor: [
                            '#0d9488', // Teal
                            '#3b82f6', // Blue
                            '#8b5cf6', // Purple
                            '#f59e0b'  // Amber
                        ],
                        hoverOffset: 6,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15, font: { size: 10 } } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': Rp ' + Number(context.parsed).toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
    @endpush
</x-sidebar-layout>
