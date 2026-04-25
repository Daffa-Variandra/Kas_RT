<x-sidebar-layout>
    <x-slot name="header">Laporan Kas RT 005 Taman Elok</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-amber-800 rounded-3xl p-6 text-white shadow-xl shadow-indigo-200">
            <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Total Saldo Masuk</p>
            <h2 class="text-3xl font-black mt-1">Rp {{ number_format($totalKas, 0, ',', '.') }}</h2>
            <div class="mt-4 flex items-center text-[10px] font-bold bg-white/20 w-fit px-3 py-1 rounded-full">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                Terverifikasi Bendahara
            </div>
        </div>
        
        <div class="md:col-span-2 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-center">
            <form action="{{ route('bendahara.reports.index') }}" method="GET" class="flex items-center gap-4">
                <div class="flex-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2 px-1">Filter Bulan</label>
                    <select name="bulan" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-700">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all">Filter</button>
                    <a href="{{ route('bendahara.reports.index') }}" class="ml-2 text-xs font-bold text-gray-400 hover:text-red-500">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Rincian Transaksi Masuk</h3>
            <button onclick="window.print()" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition">
                Cetak Laporan
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Warga</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Jenis Iuran</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Tanggal Lunas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reports as $r)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900">{{ $r->user->name }}</div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $r->user->resident->nik }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tight">
                                {{ $r->contribution->nama_iuran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium italic">
                            {{ \Carbon\Carbon::parse($r->tanggal_bayar)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-black text-gray-900 font-mono">Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs">Belum ada dana masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>