<x-sidebar-layout>
    <x-slot name="header">Kelola Koperasi & Simpan Pinjam</x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-200">
            <p class="text-xs font-black uppercase tracking-widest text-emerald-100 mb-2">Total Simpanan Kas</p>
            <h2 class="text-3xl font-black">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</h2>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl p-6 text-white shadow-lg shadow-orange-200">
            <p class="text-xs font-black uppercase tracking-widest text-orange-100 mb-2">Total Pinjaman Aktif</p>
            <h2 class="text-3xl font-black">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</h2>
        </div>
        
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex flex-col justify-center">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-4">Pengaturan Skema</h3>
            <form action="{{ route('admin.cooperative.settings.update') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                <div class="flex items-center gap-3">
                    <select name="koperasi_skema" class="flex-1 px-3 py-2 bg-slate-50 border-none rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500">
                        <option value="flat" {{ $client->koperasi_skema == 'flat' ? 'selected' : '' }}>Flat (Tanpa Bunga)</option>
                        <option value="margin" {{ $client->koperasi_skema == 'margin' ? 'selected' : '' }}>Margin / Bunga</option>
                    </select>
                    <div class="flex items-center bg-slate-50 rounded-xl overflow-hidden w-24">
                        <input type="number" step="0.1" name="koperasi_margin_persen" value="{{ $client->koperasi_margin_persen }}" class="w-full bg-transparent border-none text-xs font-bold focus:ring-0 px-3 py-2 text-center" placeholder="0">
                        <span class="text-xs font-bold text-slate-400 pr-3">%</span>
                    </div>
                </div>
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors">Update Skema</button>
            </form>
        </div>
    </div>

    <!-- Antrean Pinjaman -->
    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Pengajuan Pinjaman</h3>
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Warga</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengajuan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Skema</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-slate-800">{{ $loan->user->name }}</div>
                            <div class="text-[11px] text-slate-500 font-bold mt-1">{{ $loan->keterangan }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-slate-800">Rp {{ number_format($loan->total_pinjaman, 0, ',', '.') }}</div>
                            <div class="text-[11px] text-slate-500 font-bold mt-1">Rp {{ number_format($loan->angsuran_per_bulan, 0, ',', '.') }} x {{ $loan->tenor_bulan }} bln</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold uppercase">{{ $loan->skema }} ({{ $loan->margin_persen }}%)</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($loan->status == 'Menunggu')
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest">Menunggu</span>
                            @elseif($loan->status == 'Berjalan')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">Berjalan</span>
                            @elseif($loan->status == 'Lunas')
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-widest">Lunas</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-[10px] font-black uppercase tracking-widest">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($loan->status == 'Menunggu')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.cooperative.loan.update', $loan->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Berjalan">
                                    <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors tooltip" title="Setujui Pinjaman" onclick="return confirm('Setujui dan cairkan pinjaman ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.cooperative.loan.update', $loan->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors tooltip" title="Tolak Pinjaman" onclick="return confirm('Tolak pinjaman ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="text-xs text-slate-400 font-bold">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Belum ada pengajuan pinjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Antrean Transaksi -->
    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Verifikasi Transaksi (Setor/Tarik/Angsuran)</h3>
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Warga</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaksi</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Bukti</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-slate-800">{{ $trx->user->name }}</div>
                            <div class="text-[11px] text-slate-500 font-bold mt-1">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-slate-800">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</div>
                            <div class="text-[10px] font-bold text-slate-500 uppercase mt-1">{{ $trx->jenis_transaksi }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->bukti_bayar)
                                <a href="{{ asset('storage/'.$trx->bukti_bayar) }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:underline">Lihat Bukti</a>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->status == 'Menunggu')
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest">Menunggu</span>
                            @elseif($trx->status == 'Disetujui')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-[10px] font-black uppercase tracking-widest">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($trx->status == 'Menunggu')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.cooperative.transaction.update', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Disetujui">
                                    <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors tooltip" title="Setujui" onclick="return confirm('Verifikasi transaksi ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.cooperative.transaction.update', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors tooltip" title="Tolak" onclick="return confirm('Tolak transaksi ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="text-xs text-slate-400 font-bold">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
