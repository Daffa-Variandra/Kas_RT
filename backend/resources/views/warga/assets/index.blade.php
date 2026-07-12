<x-sidebar-layout>
    <x-slot name="header">Peminjaman Aset</x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Katalog Aset -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Katalog Barang</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($assets as $asset)
                    <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 relative" x-data="{ borrowOpen: false }">
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $asset->kategori }}</span>
                            <span class="text-xs font-bold {{ $asset->jumlah > 0 ? 'text-emerald-600' : 'text-red-500' }}">{{ $asset->jumlah }} Unit Tersedia</span>
                        </div>
                        <h4 class="text-base font-black text-slate-800">{{ $asset->nama_barang }}</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-4">{{ $asset->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                        
                        <button @click="borrowOpen = !borrowOpen" class="w-full py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-xl text-xs font-black uppercase tracking-widest transition-colors" {{ $asset->jumlah < 1 ? 'disabled' : '' }}>
                            {{ $asset->jumlah > 0 ? 'Pinjam Ini' : 'Stok Habis' }}
                        </button>

                        <div x-show="borrowOpen" style="display: none;" class="mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <form action="{{ route('warga.assets.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                                
                                <div class="mb-3">
                                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Tanggal Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Jumlah</label>
                                    <input type="number" name="jumlah" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required min="1" max="{{ $asset->jumlah }}" value="1">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Keterangan / Keperluan</label>
                                    <input type="text" name="keterangan" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required placeholder="Contoh: Acara tahlilan">
                                </div>
                                
                                <button type="submit" class="w-full py-2 bg-emerald-600 text-white rounded-xl text-xs font-black shadow-md uppercase tracking-widest">Kirim Pengajuan</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-slate-100">
                        <p class="text-sm font-bold text-slate-500">Belum ada aset yang terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Riwayat Peminjaman -->
        <div>
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Riwayat Pinjaman Saya</h3>
            <div class="space-y-4">
                @forelse($myLoans as $loan)
                    <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-sm font-black text-slate-800">{{ $loan->asset->nama_barang }}</span>
                            @php
                                $statusColors = [
                                    'Menunggu' => 'bg-amber-100 text-amber-700',
                                    'Dipinjam' => 'bg-blue-100 text-blue-700',
                                    'Selesai' => 'bg-emerald-100 text-emerald-700',
                                    'Ditolak' => 'bg-red-100 text-red-700'
                                ];
                                $color = $statusColors[$loan->status] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="px-2 py-0.5 {{ $color }} rounded-full text-[9px] font-black uppercase tracking-widest">{{ $loan->status }}</span>
                        </div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Jml: {{ $loan->jumlah }} Unit</p>
                        <p class="text-[10px] text-slate-400 font-medium">Pinjam: {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</p>
                    </div>
                @empty
                    <div class="p-6 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                        <p class="text-xs font-bold text-slate-400">Belum ada riwayat peminjaman.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-sidebar-layout>
