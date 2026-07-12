<x-sidebar-layout>
    <x-slot name="header">
        Dashboard Warga - {{ auth()->user()->client->name ?? config('app.rt_identity') }} 
    </x-slot>

    <div class="space-y-6">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-xl shadow-emerald-100/50 relative overflow-hidden">
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black">Halo, {{ Auth::user()->name }} 👋</h2>
                    <p class="text-emerald-100 text-sm mt-1">Selamat datang di portal layanan digital warga.</p>
                </div>
                <div class="hidden md:block bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                    @if(!Auth::user()->resident)
                        <div class="flex items-center space-x-2 text-yellow-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest">Profil Belum Lengkap</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-green-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-bold uppercase tracking-widest">Warga Terverifikasi</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="absolute -top-20 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-teal-800/30 rounded-full blur-2xl"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Status Iuran Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-teal-50 rounded-bl-full -z-10 group-hover:bg-teal-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Tagihan Kas Bulan Ini</h3>
                <div class="mt-4">
                    @if($data['status_bulan_ini'])
                        @if($data['status_bulan_ini']->status == 'success')
                            <div class="flex items-center space-x-2">
                                <span class="p-1.5 bg-green-100 text-green-600 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span class="text-xl font-black text-green-700">Lunas</span>
                            </div>
                        @elseif($data['status_bulan_ini']->status == 'pending')
                            <div class="flex items-center space-x-2">
                                <span class="p-1.5 bg-amber-100 text-amber-600 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                <span class="text-xl font-black text-amber-600">Menunggu Verifikasi</span>
                            </div>
                        @else
                            <div class="flex items-center space-x-2">
                                <span class="p-1.5 bg-red-100 text-red-600 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </span>
                                <span class="text-xl font-black text-red-600">Gagal</span>
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col items-start space-y-2">
                            <span class="text-xl font-black text-gray-800">Belum Bayar</span>
                            <a href="{{ route('warga.payments.index') }}" class="text-xs bg-teal-500 text-white px-3 py-1.5 rounded-full font-bold hover:bg-teal-600 transition-colors">Bayar Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Surat Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 rounded-bl-full -z-10 group-hover:bg-orange-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Surat Diajukan</h3>
                <p class="text-3xl font-black text-gray-800 mt-2">{{ $data['surat_diajukan'] }} <span class="text-sm text-gray-400 font-medium">Dokumen</span></p>
                <a href="{{ route('warga.letters.index') }}" class="text-xs text-orange-600 font-bold mt-2 inline-block hover:underline">Riwayat Surat &rarr;</a>
            </div>

            <!-- Aset Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 rounded-bl-full -z-10 group-hover:bg-purple-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Aset Dipinjam</h3>
                <p class="text-3xl font-black text-gray-800 mt-2">{{ $data['aset_dipinjam'] }} <span class="text-sm text-gray-400 font-medium">Barang</span></p>
                <a href="{{ route('warga.assets.index') }}" class="text-xs text-purple-600 font-bold mt-2 inline-block hover:underline">Lihat Aset &rarr;</a>
            </div>
            
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mt-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-gray-800 font-black text-lg">Riwayat Iuran Saya</h3>
                    <p class="text-xs text-gray-400">Total pembayaran terverifikasi dalam 6 bulan terakhir.</p>
                </div>
            </div>
            <div class="h-64 relative">
                <canvas id="chartHistory"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // History Bar Chart
            const historyCtx = document.getElementById('chartHistory').getContext('2d');
            
            const gradientBar = historyCtx.createLinearGradient(0, 0, 0, 400);
            gradientBar.addColorStop(0, 'rgba(16, 185, 129, 0.9)'); // Emerald 500
            gradientBar.addColorStop(1, 'rgba(20, 184, 166, 0.6)'); // Teal 500

            new Chart(historyCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartHistoryLabels),
                    datasets: [{
                        label: 'Total Pembayaran (Rp)',
                        data: @json($chartHistoryValues),
                        backgroundColor: gradientBar,
                        hoverBackgroundColor: 'rgba(13, 148, 136, 1)', // Teal 600
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.5
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
        });
    </script>
    @endpush
</x-sidebar-layout>
