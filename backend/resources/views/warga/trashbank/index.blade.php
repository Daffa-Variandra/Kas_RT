<x-sidebar-layout>
    <x-slot name="header">Bank Sampah Warga</x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Saldo Koperasi Hasil Sampah -->
        <div class="md:col-span-1">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-lg shadow-emerald-200 relative overflow-hidden h-full flex flex-col justify-center">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div class="relative">
                    <p class="text-xs font-black uppercase tracking-widest text-emerald-100 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Saldo Koperasi Anda
                    </p>
                    <h2 class="text-3xl font-black mb-2">Rp {{ number_format($coop->saldo_simpanan ?? 0, 0, ',', '.') }}</h2>
                    <p class="text-[10px] text-emerald-100 font-medium">Uang hasil penjualan Bank Sampah akan secara otomatis ditambahkan ke saldo tabungan Koperasi Anda.</p>
                </div>
            </div>
        </div>

        <!-- Form Request Jemput -->
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-1">Setor Sampah Daur Ulang</h3>
                <p class="text-[10px] text-slate-400 font-bold mb-6">Panggil petugas Bank Sampah untuk menjemput atau menimbang sampah Anda.</p>
                
                <form action="{{ route('warga.trashbank.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Jenis Sampah Daur Ulang</label>
                        <select name="jenis_sampah" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                            <option value="">Pilih Jenis...</option>
                            <option value="Kardus / Kertas">Kardus / Kertas</option>
                            <option value="Plastik Botol / Cup">Plastik Botol / Cup</option>
                            <option value="Besi / Logam">Besi / Logam</option>
                            <option value="Kaca / Beling">Kaca / Beling</option>
                            <option value="Minyak Jelantah">Minyak Jelantah</option>
                            <option value="Campur">Campur / Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Estimasi Berat (Kg)</label>
                        <input type="number" step="0.1" name="estimasi_berat" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" placeholder="Kosongkan jika tidak tahu">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Keterangan / Lokasi (Opsional)</label>
                        <input type="text" name="keterangan" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" placeholder="Contoh: Tolong dijemput di teras depan.">
                    </div>
                    <div class="sm:col-span-2 pt-2">
                        <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">
                            Ajukan Penjemputan / Setoran
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Riwayat -->
    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Riwayat Setoran Bank Sampah Anda</h3>
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis Sampah</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Berat Aktual</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nominal (Masuk Koperasi)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($deposits as $deposit)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $deposit->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-black text-slate-800 block">{{ $deposit->jenis_sampah }}</span>
                            @if($deposit->keterangan)
                                <span class="text-[10px] text-slate-400">{{ $deposit->keterangan }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-black text-slate-700">
                            {{ $deposit->berat_kg ?? 'Menunggu' }} <span class="text-xs text-slate-400 font-normal">kg</span>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Belum ada riwayat setoran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
