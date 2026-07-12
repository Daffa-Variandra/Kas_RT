<x-sidebar-layout>
    <x-slot name="header">Kelola KMS Posyandu</x-slot>

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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Form Tambah Data KMS -->
        <div class="xl:col-span-1">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 sticky top-6">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-1">Catat Hasil Posyandu</h3>
                <p class="text-[10px] text-slate-400 font-bold mb-6">Input rekam medis pertumbuhan.</p>
                
                <form action="{{ route('admin.posyandu.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Kepala Keluarga (Warga)</label>
                        <select name="user_id" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                            <option value="">Pilih Keluarga...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nama Pasien / Balita</label>
                        <input type="text" name="nama_pasien" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Kategori</label>
                        <select name="kategori" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                            <option value="Balita">Balita</option>
                            <option value="Ibu Hamil">Ibu Hamil</option>
                            <option value="Lansia">Lansia</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Berat (Kg)</label>
                            <input type="number" step="0.1" name="berat_badan" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Tinggi (Cm)</label>
                            <input type="number" step="0.1" name="tinggi_badan" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Catatan / Imunisasi</label>
                        <textarea name="keterangan" rows="2" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" placeholder="Cth: DPT-HB-Hib 1, Polio 2"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">Simpan Data Medis</button>
                </form>
            </div>
        </div>

        <!-- Tabel Riwayat Posyandu -->
        <div class="xl:col-span-2">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Log Rekam Medis Warga</h3>
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pasien</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">KMS</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($records as $rec)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-xs font-bold text-slate-600">
                                    {{ $rec->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-slate-800">{{ $rec->nama_pasien }}</div>
                                    <div class="text-[11px] text-slate-500 font-bold mt-1 uppercase">{{ $rec->kategori }} (KK: {{ $rec->user->name }})</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-black text-slate-700">BB: {{ $rec->berat_badan ?? '-' }} kg</div>
                                    <div class="text-xs font-black text-slate-700 mt-1">TB: {{ $rec->tinggi_badan ?? '-' }} cm</div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-600 font-medium">
                                    {{ $rec->keterangan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.posyandu.destroy', $rec->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors tooltip" title="Hapus Data" onclick="return confirm('Hapus rekam medis ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Belum ada catatan posyandu.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
