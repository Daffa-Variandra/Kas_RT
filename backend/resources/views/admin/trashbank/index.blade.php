<x-sidebar-layout>
    <x-slot name="header">Kelola Bank Sampah</x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-1">Daftar Setoran Sampah Warga</h3>
        <p class="text-[10px] text-slate-400 font-bold">Proses penimbangan dan cairkan nominal ke saldo koperasi warga.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Warga</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis Sampah</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Timbangan (Kg)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Harga (Rp)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($deposits as $deposit)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-slate-800">{{ $deposit->user->name }}</div>
                            <div class="text-[11px] text-slate-500 font-bold mt-1">{{ $deposit->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $deposit->jenis_sampah }}</span>
                            @if($deposit->keterangan)
                                <div class="text-[10px] text-slate-500 font-bold mt-2">{{ $deposit->keterangan }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-black text-slate-700">
                            {{ $deposit->berat_kg ?? '?' }} <span class="text-xs text-slate-400 font-normal">kg</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-black text-emerald-600">
                            {{ $deposit->nominal_rupiah ? 'Rp ' . number_format($deposit->nominal_rupiah, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($deposit->status == 'Menunggu Jemput')
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest">Menunggu Timbang</span>
                            @elseif($deposit->status == 'Selesai')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-[10px] font-black uppercase tracking-widest">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($deposit->status != 'Selesai' && $deposit->status != 'Ditolak')
                                <button onclick="openTimbangModal({{ $deposit->id }}, '{{ $deposit->jenis_sampah }}', '{{ $deposit->berat_kg }}')" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-colors">
                                    Proses / Timbang
                                </button>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Belum ada request setoran sampah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TIMBANG -->
    <div id="modal-timbang" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-emerald-50">
                <div>
                    <h3 class="text-sm font-black text-emerald-800 uppercase tracking-widest">Proses Setoran Sampah</h3>
                    <p class="text-[10px] text-emerald-600 font-bold mt-1" id="modal-jenis-sampah">Jenis Sampah</p>
                </div>
                <button onclick="document.getElementById('modal-timbang').classList.add('hidden')" class="text-emerald-400 hover:text-emerald-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="form-timbang" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                
                <div>
                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1 px-1">Berat Aktual (Kg)</label>
                    <input type="number" step="0.1" name="berat_kg" id="input-berat" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                </div>
                
                <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100">
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Total Nominal / Harga (Rp)</label>
                    <input type="number" name="nominal_rupiah" class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 text-sm font-black text-emerald-700" placeholder="Contoh: 15000" required>
                    <p class="text-[9px] text-emerald-600 mt-2 font-bold leading-relaxed">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Nominal ini akan otomatis ditambahkan ke Saldo Tabungan Koperasi warga.
                    </p>
                </div>
                
                <div class="pt-2 flex gap-3">
                    <button type="submit" name="status" value="Ditolak" formnovalidate class="flex-1 py-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors">
                        Tolak
                    </button>
                    <button type="submit" name="status" value="Selesai" class="flex-[2] py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">
                        Selesaikan & Cairkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openTimbangModal(id, jenis, berat) {
            document.getElementById('form-timbang').action = '/admin/trashbank/' + id + '/process';
            document.getElementById('modal-jenis-sampah').innerText = 'Jenis: ' + jenis;
            document.getElementById('input-berat').value = berat || '';
            document.getElementById('modal-timbang').classList.remove('hidden');
        }
    </script>
</x-sidebar-layout>
