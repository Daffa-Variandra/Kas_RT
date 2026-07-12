<x-sidebar-layout>
    <x-slot name="header">Laporan Keuangan - {{ auth()->user()->client->name ?? 'Lingkungan' }}</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-emerald-600 rounded-3xl p-6 text-white shadow-xl shadow-teal-200">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Total Kas Masuk</p>
            <h2 class="text-2xl font-black mt-1">Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}</h2>
            <div class="mt-4 flex items-center text-[10px] font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                Terverifikasi
            </div>
        </div>

        <div class="bg-rose-500 rounded-3xl p-6 text-white shadow-xl shadow-rose-200">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Total Kas Keluar</p>
            <h2 class="text-2xl font-black mt-1">Rp {{ number_format($totalKasKeluar, 0, ',', '.') }}</h2>
            <div class="mt-4 flex items-center text-[10px] font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                Pengeluaran
            </div>
        </div>

        <div class="bg-gray-900 rounded-3xl p-6 text-white shadow-xl shadow-gray-300">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Saldo Kas Akhir</p>
            <h2 class="text-2xl font-black mt-1">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h2>
            <div class="mt-4 flex items-center text-[10px] font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                Net Balance
            </div>
        </div>
        
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
            <form action="{{ route('bendahara.reports.index') }}" method="GET" class="flex flex-col gap-2">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1 px-1">Filter Bulan</label>
                    <select name="bulan" class="w-full p-2 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <button type="submit" class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all">Filter</button>
                    <a href="{{ route('bendahara.reports.index') }}" class="text-[10px] font-bold text-gray-400 hover:text-red-500 text-center">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tabel Kas Masuk -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Transaksi Masuk</h3>
                <a href="{{ route('bendahara.reports.pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank" class="text-[10px] font-black text-teal-600 uppercase tracking-widest hover:text-teal-800 transition flex items-center bg-teal-50 px-4 py-2 rounded-xl">
                    Export PDF
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Warga / Iuran</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($reports as $r)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $r->user->name }}</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $r->contribution->nama_iuran }} ({{ \Carbon\Carbon::parse($r->tanggal_bayar)->format('d M y') }})</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-black text-gray-900 font-mono">Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs">Belum ada dana masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Kas Keluar -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Transaksi Keluar (Pengeluaran)</h3>
                <a href="{{ route('bendahara.expenses.index') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition flex items-center bg-blue-50 px-4 py-2 rounded-xl">
                    Kelola
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Keterangan / Kategori</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($expenses as $e)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $e->title }}</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $e->category }} ({{ \Carbon\Carbon::parse($e->expense_date)->format('d M y') }})</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-black text-red-600 font-mono">-Rp {{ number_format($e->amount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs">Belum ada dana keluar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sidebar-layout>
