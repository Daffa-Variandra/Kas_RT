<x-sidebar-layout>
    <x-slot name="header">KMS & Rekam Medis Keluarga</x-slot>

    <div class="mb-8">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-1">Riwayat Pertumbuhan & Posyandu</h3>
        <p class="text-[10px] text-slate-400 font-bold">Pantau catatan kesehatan anggota keluarga Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @php
            $patients = $records->groupBy('nama_pasien');
        @endphp
        
        @forelse($patients as $name => $patientRecords)
            @php 
                $latest = $patientRecords->last(); 
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-emerald-200 transition-colors">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                <div class="relative">
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-3 inline-block">{{ $latest->kategori }}</span>
                    <h4 class="text-xl font-black text-slate-800 mb-4">{{ $name }}</h4>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-slate-50 rounded-2xl p-3 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Berat</p>
                            <p class="text-lg font-black text-emerald-600">{{ $latest->berat_badan ?? '-' }}<span class="text-[10px] text-emerald-400 ml-1">kg</span></p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-3 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tinggi</p>
                            <p class="text-lg font-black text-teal-600">{{ $latest->tinggi_badan ?? '-' }}<span class="text-[10px] text-teal-400 ml-1">cm</span></p>
                        </div>
                    </div>
                    
                    <p class="text-[10px] font-bold text-slate-400">Pemeriksaan Terakhir: <span class="text-slate-600">{{ $latest->created_at->format('d M Y') }}</span></p>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-8 border border-slate-100 text-center">
                <p class="text-sm font-bold text-slate-500">Belum ada rekam medis yang dicatat oleh Posyandu.</p>
            </div>
        @endforelse
    </div>

    <!-- Tabel Detail Riwayat KMS -->
    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Log KMS Seluruh Anggota Keluarga</h3>
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pasien</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">BB (kg)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">TB (cm)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan (Imunisasi, dll)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($records as $rec)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-slate-600">{{ $rec->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-black text-slate-800">{{ $rec->nama_pasien }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-black text-emerald-600">{{ $rec->berat_badan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-black text-teal-600">{{ $rec->tinggi_badan ?? '-' }}</td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-500">{{ $rec->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold text-sm">Tidak ada riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
