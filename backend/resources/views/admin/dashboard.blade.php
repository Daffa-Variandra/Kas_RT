<x-sidebar-layout>
    <x-slot name="header">
        Dashboard Admin - {{ auth()->user()->client->name ?? config('app.rt_identity') }} 
    </x-slot>

    <div class="space-y-6">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-xl shadow-teal-100/50 relative overflow-hidden">
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black">Halo, {{ Auth::user()->name }} 👋</h2>
                    <p class="text-teal-100 text-sm mt-1">Ringkasan administrasi dan pelayanan warga hari ini.</p>
                </div>
                <div class="hidden md:block bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                    <p class="text-xs uppercase tracking-widest font-bold text-teal-100 mb-1">Tanggal</p>
                    <p class="text-xl font-black">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-10 w-40 h-40 bg-teal-800/30 rounded-full blur-2xl"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10 group-hover:bg-blue-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Warga</h3>
                <p class="text-3xl font-black text-gray-800 mt-2">{{ $data['total_warga'] }} <span class="text-sm text-gray-400 font-medium">Jiwa</span></p>
                <p class="text-xs text-gray-500 mt-1">Dari {{ $data['total_keluarga'] }} Kepala Keluarga</p>
            </div>
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 rounded-bl-full -z-10 group-hover:bg-orange-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Surat Pengantar</h3>
                <p class="text-3xl font-black {{ $data['surat_pending'] > 0 ? 'text-orange-600' : 'text-gray-800' }} mt-2">
                    {{ $data['surat_pending'] }} <span class="text-sm text-gray-400 font-medium">Menunggu</span>
                </p>
                <a href="{{ route('admin.letters.index') }}" class="text-xs text-orange-600 font-bold mt-2 inline-block hover:underline">Lihat Detail &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -z-10 group-hover:bg-red-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Aspirasi Warga</h3>
                <p class="text-3xl font-black {{ $data['aspirasi_pending'] > 0 ? 'text-red-600' : 'text-gray-800' }} mt-2">
                    {{ $data['aspirasi_pending'] }} <span class="text-sm text-gray-400 font-medium">Masuk</span>
                </p>
                <a href="{{ route('admin.complaints.index') }}" class="text-xs text-red-600 font-bold mt-2 inline-block hover:underline">Tindak lanjuti &rarr;</a>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 rounded-bl-full -z-10 group-hover:bg-purple-100 transition-colors"></div>
                <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Aset Dipinjam</h3>
                <p class="text-3xl font-black text-purple-600 mt-2">{{ $data['aset_dipinjam'] }} <span class="text-sm text-gray-400 font-medium">Aktif</span></p>
                <a href="{{ route('admin.asset_loans.index') }}" class="text-xs text-purple-600 font-bold mt-2 inline-block hover:underline">Cek Status &rarr;</a>
            </div>
        </div>

        <div class="mb-4 mt-8 flex items-center justify-between">
            <h3 class="text-xl font-black text-gray-800 tracking-tight">Monitoring Ekosistem</h3>
            <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full uppercase tracking-widest">Ringkasan</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100">
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-1">Total Smart RW</p>
                <h4 class="text-2xl font-black text-emerald-900">Rp {{ number_format($data['total_kas'], 0, ',', '.') }}</h4>
            </div>
            
            <div class="bg-green-50 rounded-2xl p-5 border border-green-100">
                <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest mb-1">Bank Sampah</p>
                <h4 class="text-xl font-black text-green-900">{{ number_format($data['sampah_terkumpul'], 1, ',', '.') }} Kg</h4>
                <p class="text-xs font-bold text-green-700 mt-1">Rp {{ number_format($data['saldo_sampah'], 0, ',', '.') }}</p>
            </div>

            <div class="bg-indigo-50 rounded-2xl p-5 border border-indigo-100">
                <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest mb-1">Koperasi (Simpanan)</p>
                <h4 class="text-xl font-black text-indigo-900">Rp {{ number_format($data['simpanan_koperasi'], 0, ',', '.') }}</h4>
                <p class="text-xs font-bold text-indigo-700 mt-1">Pinjaman: Rp {{ number_format($data['pinjaman_koperasi'], 0, ',', '.') }}</p>
            </div>

            <div class="bg-rose-50 rounded-2xl p-5 border border-rose-100">
                <p class="text-[10px] font-bold text-rose-600 uppercase tracking-widest mb-1">Riwayat Posyandu</p>
                <h4 class="text-2xl font-black text-rose-900">{{ $data['data_posyandu'] }}</h4>
                <p class="text-xs font-bold text-rose-700 mt-1">Pemeriksaan Tercatat</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
            <!-- Line Chart Aktivitas -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-800 font-black text-lg">Aktivitas Layanan (6 Bulan)</h3>
                    <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full uppercase">Surat & Aspirasi</span>
                </div>
                <div class="h-64 relative">
                    <canvas id="chartActivity"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart Demografi -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-gray-800 font-black text-lg mb-1">Demografi Hunian</h3>
                <p class="text-xs text-gray-400 mb-6">Distribusi status hunian warga terdaftar.</p>
                <div class="h-56 flex justify-center relative">
                    <canvas id="chartDemo"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activity Line Chart
            const activityCtx = document.getElementById('chartActivity').getContext('2d');
            
            // Create Gradient
            const gradientLetters = activityCtx.createLinearGradient(0, 0, 0, 400);
            gradientLetters.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue
            gradientLetters.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            const gradientComplaints = activityCtx.createLinearGradient(0, 0, 0, 400);
            gradientComplaints.addColorStop(0, 'rgba(239, 68, 68, 0.5)'); // Red
            gradientComplaints.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: @json($chartActivityLabels),
                    datasets: [
                        {
                            label: 'Pengajuan Surat',
                            data: @json($chartLettersValues),
                            borderColor: '#3b82f6',
                            backgroundColor: gradientLetters,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#3b82f6',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Aspirasi Masuk',
                            data: @json($chartComplaintsValues),
                            borderColor: '#ef4444',
                            backgroundColor: gradientComplaints,
                            borderWidth: 3,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#ef4444',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', align: 'end', labels: { boxWidth: 10, usePointStyle: true, font: { weight: 'bold' } } },
                        tooltip: { backgroundColor: 'rgba(0,0,0,0.8)', padding: 12, cornerRadius: 8 }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f4f6', borderDash: [5, 5] }, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Demographics Doughnut Chart
            const demoCtx = document.getElementById('chartDemo').getContext('2d');
            new Chart(demoCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($chartDemoLabels),
                    datasets: [{
                        data: @json($chartDemoValues),
                        backgroundColor: ['#0d9488', '#f59e0b', '#3b82f6'],
                        hoverOffset: 6,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 20, font: { weight: 'bold' } } }
                    },
                    cutout: '75%'
                }
            });
        });
    </script>
    @endpush
</x-sidebar-layout>
