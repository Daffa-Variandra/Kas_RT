<x-sidebar-layout>
    <x-slot name="header">Koperasi & Simpan Pinjam</x-slot>

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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Saldo Simpanan -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-200 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
            <p class="text-xs font-black uppercase tracking-widest text-emerald-100 mb-2">Saldo Simpanan Saya</p>
            <h2 class="text-3xl font-black mb-6">Rp {{ number_format($coop->saldo_simpanan, 0, ',', '.') }}</h2>
            
            <button onclick="document.getElementById('modal-setor').classList.remove('hidden')" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-xs font-black uppercase tracking-widest transition-colors">
                + Setor Simpanan
            </button>
        </div>

        <!-- Sisa Pinjaman -->
        <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl p-6 text-white shadow-lg shadow-orange-200 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
            <p class="text-xs font-black uppercase tracking-widest text-orange-100 mb-2">Total Tanggungan Pinjaman</p>
            <h2 class="text-3xl font-black mb-6">Rp {{ number_format($coop->saldo_pinjaman, 0, ',', '.') }}</h2>
            
            <button onclick="document.getElementById('modal-pinjam').classList.remove('hidden')" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-xs font-black uppercase tracking-widest transition-colors">
                Ajukan Pinjaman
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Riwayat Pinjaman -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Riwayat Pinjaman Saya</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pinjaman</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sisa / Tenor</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($loans as $loan)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-slate-800">Rp {{ number_format($loan->total_pinjaman, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-slate-500 font-bold mt-1">Cicilan: Rp {{ number_format($loan->angsuran_per_bulan, 0, ',', '.') }}/bln</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-slate-800">Rp {{ number_format($loan->sisa_pinjaman, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-slate-500 font-bold mt-1">Sisa: {{ $loan->tenor_bulan - $loan->angsuran_ke }} Bulan</div>
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
                                @if($loan->status == 'Berjalan')
                                    <button onclick="openAngsuranModal({{ $loan->id }}, '{{ number_format($loan->angsuran_per_bulan, 0, '', '') }}')" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-colors">
                                        Bayar Cicilan
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Tidak ada riwayat pinjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Riwayat Transaksi Terakhir</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $trx->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-xs font-black text-slate-800 uppercase">{{ $trx->jenis_transaksi }}</td>
                            <td class="px-6 py-4 text-sm font-black text-slate-800">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($trx->status == 'Menunggu')
                                    <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest">Menunggu</span>
                                @elseif($trx->status == 'Disetujui')
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">Selesai</span>
                                @else
                                    <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-[10px] font-black uppercase tracking-widest">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Tidak ada riwayat transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL SETOR SIMPANAN -->
    <div id="modal-setor" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Setor Simpanan</h3>
                <button onclick="document.getElementById('modal-setor').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('warga.cooperative.transaction.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="jenis_transaksi" value="Simpanan Wajib">
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nominal Setor (Rp)</label>
                    <input type="number" name="jumlah" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required min="1000">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Bukti Transfer/Setor</label>
                    <input type="file" name="bukti_bayar" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" accept="image/*" required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold">
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">Setorkan</button>
            </form>
        </div>
    </div>

    <!-- MODAL PENGAJUAN PINJAMAN -->
    <div id="modal-pinjam" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pengajuan Pinjaman</h3>
                    <p class="text-[10px] text-slate-500 font-bold mt-1">Skema Koperasi saat ini: <span class="uppercase text-emerald-600">{{ $client->koperasi_skema }} {{ $client->koperasi_skema == 'margin' ? '('.$client->koperasi_margin_persen.'%)' : '' }}</span></p>
                </div>
                <button onclick="document.getElementById('modal-pinjam').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('warga.cooperative.loan.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nominal Pinjaman (Rp)</label>
                    <input type="number" name="pokok_pinjaman" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required min="10000">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Tenor (Bulan)</label>
                    <select name="tenor_bulan" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Keterangan / Keperluan</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required></textarea>
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">Ajukan Pinjaman</button>
            </form>
        </div>
    </div>

    <!-- MODAL BAYAR ANGSURAN -->
    <div id="modal-angsuran" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Bayar Angsuran</h3>
                <button onclick="document.getElementById('modal-angsuran').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('warga.cooperative.transaction.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="jenis_transaksi" value="Bayar Angsuran">
                <input type="hidden" name="cooperative_loan_id" id="angsuran_loan_id">
                
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nominal Angsuran (Rp)</label>
                    <input type="number" name="jumlah" id="angsuran_jumlah" class="w-full px-4 py-3 bg-slate-100 border-none rounded-2xl focus:ring-0 text-xs font-bold text-slate-500" required readonly>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Bukti Pembayaran</label>
                    <input type="file" name="bukti_bayar" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" accept="image/*" required>
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">Kirim Pembayaran</button>
            </form>
        </div>
    </div>

    <script>
        function openAngsuranModal(loanId, nominal) {
            document.getElementById('angsuran_loan_id').value = loanId;
            document.getElementById('angsuran_jumlah').value = nominal;
            document.getElementById('modal-angsuran').classList.remove('hidden');
        }
    </script>
</x-sidebar-layout>
