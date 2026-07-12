<x-sidebar-layout>
    <x-slot name="header">Daftar Aset</x-slot>

    <div x-data="{ showModal: false, editMode: false, currentAsset: null }">
        <div class="mb-6 flex justify-between items-center">
            <p class="text-sm text-slate-500">Kelola inventaris barang milik lingkungan.</p>
            <div class="space-x-2">
                <a href="{{ route('admin.asset_loans.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-5 py-2.5 rounded-2xl text-xs font-black transition-all shadow-sm">
                    Daftar Peminjaman
                </a>
                <button @click="showModal = true; editMode = false" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black transition-all shadow-lg shadow-emerald-200">
                    + Tambah Aset
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($assets as $asset)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $asset->kategori }}</span>
                            <span class="px-3 py-1 {{ $asset->kondisi == 'Baik' ? 'bg-emerald-100 text-emerald-700' : ($asset->kondisi == 'Rusak Ringan' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }} rounded-full text-[10px] font-black uppercase tracking-widest">{{ $asset->kondisi }}</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 mb-1">{{ $asset->nama_barang }}</h3>
                        <p class="text-sm font-bold text-slate-500 mb-4">Stok: {{ $asset->jumlah }} Unit</p>
                        @if($asset->keterangan)
                            <p class="text-xs text-slate-400 mb-6 italic">{{ $asset->keterangan }}</p>
                        @endif
                    </div>
                    
                    <div class="flex space-x-2 border-t border-slate-50 pt-4 mt-auto">
                        <button @click="currentAsset = {{ $asset }}; editMode = true; showModal = true" class="flex-1 py-2 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase hover:bg-slate-100 transition-colors">Edit</button>
                        <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-2 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase hover:bg-red-100 transition-colors" onclick="return confirm('Hapus aset ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Create / Edit Modal -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div @click.away="showModal = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-base font-black text-slate-800 uppercase tracking-tight" x-text="editMode ? 'Edit Aset' : 'Tambah Aset'"></h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form :action="editMode ? '{{ url('admin/assets') }}/' + currentAsset.id : '{{ route('admin.assets.store') }}'" method="POST" class="p-8 space-y-5">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nama Barang</label>
                        <input type="text" name="nama_barang" x-bind:value="editMode ? currentAsset.nama_barang : ''" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Kategori</label>
                            <select name="kategori" id="kategori_select" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold" required>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Furnitur">Furnitur</option>
                                <option value="Tenda">Tenda</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Jumlah</label>
                            <input type="number" name="jumlah" min="1" x-bind:value="editMode ? currentAsset.jumlah : 1" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Kondisi</label>
                        <select name="kondisi" id="kondisi_select" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold" required>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Keterangan Tambahan</label>
                        <textarea name="keterangan" x-bind:value="editMode ? currentAsset.keterangan : ''" rows="2" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold"></textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 text-[10px] font-black text-slate-400 bg-slate-100 rounded-2xl uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-2xl shadow-lg shadow-emerald-200 uppercase tracking-widest" x-text="editMode ? 'Simpan Perubahan' : 'Tambah Aset'"></button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.effect(() => {
                    const data = Alpine.$data(document.querySelector('[x-data]'));
                    if (data.editMode && data.currentAsset) {
                        setTimeout(() => {
                            document.getElementById('kategori_select').value = data.currentAsset.kategori;
                            document.getElementById('kondisi_select').value = data.currentAsset.kondisi;
                        }, 50);
                    }
                });
            });
        </script>
    </div>
</x-sidebar-layout>
