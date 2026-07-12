<x-sidebar-layout>
    <x-slot name="header">Daftar Peminjaman Aset</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.assets.index') }}" class="text-sm text-emerald-600 font-bold hover:text-emerald-800">&larr; Kembali ke Daftar Aset</a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Warga & Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Barang (Jumlah)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-slate-800">{{ $loan->user->name }}</div>
                            <div class="text-[11px] text-slate-500 font-bold mt-1">Pinjam: {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-700">{{ $loan->asset->nama_barang }}</div>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black">{{ $loan->jumlah }} Unit</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'Menunggu' => 'bg-amber-100 text-amber-700',
                                    'Dipinjam' => 'bg-blue-100 text-blue-700',
                                    'Selesai' => 'bg-emerald-100 text-emerald-700',
                                    'Ditolak' => 'bg-red-100 text-red-700'
                                ];
                                $color = $statusColors[$loan->status] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="px-3 py-1 {{ $color }} rounded-full text-[10px] font-black uppercase tracking-widest">{{ $loan->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <button @click="open = !open" @click.away="open = false" class="p-2 text-slate-400 hover:text-emerald-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                                
                                <div x-show="open" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-36 rounded-2xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-slate-50 z-10 overflow-hidden">
                                    <form action="{{ route('admin.asset_loans.update', $loan->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Dipinjam">
                                        <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold text-blue-600 hover:bg-blue-50 transition">Setuju (Dipinjam)</button>
                                    </form>
                                    <form action="{{ route('admin.asset_loans.update', $loan->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Selesai">
                                        <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold text-emerald-600 hover:bg-emerald-50 transition">Tandai Selesai</button>
                                    </form>
                                    <form action="{{ route('admin.asset_loans.update', $loan->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold text-red-600 hover:bg-red-50 transition">Tolak</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold text-sm">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
