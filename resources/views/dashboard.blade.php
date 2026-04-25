<x-sidebar-layout>
    <x-slot name="header">
        Dashboard {{ ucfirst(Auth::user()->role) }} - {{ config('app.rt_identity') }} 
    </x-slot>

    <div class="space-y-6">
        <div class="bg-amber-800 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-black">Welcome, {{ Auth::user()->name }} 🙌</h2>
                <p class="text-indigo-100 text-sm mt-1">Sistem KAS RT 005 Taman Elok.</p>
            </div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            @if(Auth::user()->role == 'admin')
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Kas RT</h3>
                    <p class="text-3xl font-black text-indigo-600 mt-2">Rp {{ number_format($data['total_kas'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Warga Terdaftar</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ $data['total_warga'] }} <span class="text-sm text-gray-400">Jiwa</span></p>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Jenis Iuran</h3>
                    <p class="text-3xl font-black text-gray-800 mt-2">{{ $data['total_jenis_iuran'] }} <span class="text-sm text-gray-400">Kategori</span></p>
                </div>

            @elseif(Auth::user()->role == 'bendahara')
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Pemasukan Bulan Ini</h3>
                    <p class="text-3xl font-black text-green-600 mt-2">Rp {{ number_format($data['pemasukan_bulan_ini'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Menunggu Verifikasi</h3>
                    <p class="text-3xl font-black {{ $data['perlu_verifikasi'] > 0 ? 'text-amber-500' : 'text-gray-800' }} mt-2">
                        {{ $data['perlu_verifikasi'] }} <span class="text-sm text-gray-400">Transaksi</span>
                    </p>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Saldo Kas</h3>
                    <p class="text-3xl font-black text-indigo-600 mt-2">Rp {{ number_format($data['total_kas'], 0, ',', '.') }}</p>
                </div>

            @else
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Iuran Saya</h3>
                    <p class="text-3xl font-black text-indigo-600 mt-2">Rp {{ number_format($data['total_bayar_saya'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Status Iuran Bulan Ini</h3>
                    <div class="mt-3">
                        @if($data['status_bulan_ini'])
                            @if($data['status_bulan_ini']->status == 'success')
                                <span class="px-4 py-2 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase italic">Terverifikasi Lunas</span>
                            @elseif($data['status_bulan_ini']->status == 'pending')
                                <span class="px-4 py-2 bg-amber-100 text-amber-700 text-[10px] font-black rounded-full uppercase italic">Menunggu Pengecekan</span>
                            @else
                                <span class="px-4 py-2 bg-red-100 text-red-700 text-[10px] font-black rounded-full uppercase italic">Pembayaran Gagal</span>
                            @endif
                        @else
                            <span class="px-4 py-2 bg-gray-100 text-gray-500 text-[10px] font-black rounded-full uppercase italic">Belum Ada Setoran</span>
                        @endif
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Lengkapi Profil</h3>
                        <p class="text-sm font-bold text-gray-800 mt-1">{{ Auth::user()->resident ? 'Sudah Lengkap ✅' : 'Belum Lengkap ❌' }}</p>
                    </div>
                    <a href="{{ route('warga.profile.edit') }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mt-8">
            <h3 class="text-gray-700 font-bold mb-4">Grafik Iuran Masuk per Hari</h3>
            <canvas id="chartKasRt" width="400" height="200" class="w-full h-64"></canvas>
        </div>

    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // console.log('DOM Ready, initializing chart...');
            
            const canvasElement = document.getElementById('chartKasRt');
            if (!canvasElement) {
                console.error('Canvas element not found!');
                return;
            }
            
            const ctx = canvasElement.getContext('2d');
            const labels = @json($chartLabels);
            const values = @json($chartValues);
            
            // console.log('Chart Labels:', labels);
            // console.log('Chart Values:', values);
            
            if (!labels || labels.length === 0) {
                console.warn('No data for chart!');
                return;
            }
            
            const chartKasRt = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Bayar (Rp)',
                        data: values,
                        fill: true,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.1)',
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Tanggal Bayar' }
                        },
                        y: {
                            title: { display: true, text: 'Jumlah Bayar (Rp)' },
                            beginAtZero: true
                        }
                    }
                }
            });
            
            console.log('Chart initialized successfully');
        });
    </script>
    @endpush
</x-sidebar-layout>