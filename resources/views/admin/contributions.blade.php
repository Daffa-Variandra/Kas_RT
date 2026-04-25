<x-sidebar-layout>
    <x-slot name="header">Pengaturan Jenis Iuran</x-slot>

    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }">
        
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-700">Daftar Tagihan Kas RT</h3>
            <button @click="showModal = true" class="bg-amber-800 hover:bg-amber-950 text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center shadow-lg shadow-indigo-100">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Iuran
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase">Nama Iuran & Keterangan</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase">Nominal</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contributions as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_iuran }}</div>
                                <div class="text-xs text-gray-500 line-clamp-1">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-indigo-700">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center" x-data="{ editOpen: false, deleteOpen: false }">
                                <div class="flex justify-center space-x-3">
                                    <button @click="editOpen = true" class="text-indigo-600 hover:text-indigo-900 text-xs font-bold uppercase tracking-tighter transition-colors">Edit</button>
                                    <button @click="deleteOpen = true" class="text-red-500 hover:text-red-700 text-xs font-bold uppercase tracking-tighter transition-colors">Hapus</button>
                                </div>

                                <div x-show="editOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0 text-left" x-cloak style="display: none;">
                                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
                                    
                                    <div @click.away="editOpen = false" class="relative bg-white rounded-2xl shadow-2xl w-full sm:w-96 z-10 overflow-hidden">
                                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                            <h3 class="text-base font-bold text-gray-800">Edit Jenis Iuran</h3>
                                            <button @click="editOpen = false" class="text-gray-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                        </div>
                                        <form action="{{ route('admin.contributions.update', $item->id) }}" method="POST" class="p-6">
                                            @csrf
                                            @method('PUT')
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Iuran</label>
                                                    <input type="text" name="nama_iuran" value="{{ $item->nama_iuran }}" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nominal (Rp)</label>
                                                    <input type="number" name="nominal" value="{{ (int)$item->nominal }}" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Deskripsi / Keterangan</label>
                                                    <textarea name="deskripsi" rows="2" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm">{{ $item->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="mt-6 flex gap-3">
                                                <button type="button" @click="editOpen = false" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100">Batal</button>
                                                <button type="submit" class="flex-[2] px-4 py-2.5 text-sm font-bold text-white bg-amber-800 rounded-lg hover:bg-amber-950 shadow-md">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div x-show="deleteOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0 text-left" x-cloak style="display: none;">
                                    <div class="fixed inset-0 bg-red-900/60 backdrop-blur-sm transition-opacity"></div>
                                    
                                    <div @click.away="deleteOpen = false" class="relative bg-white rounded-2xl shadow-2xl w-full sm:w-96 z-10 overflow-hidden text-center">
                                        <div class="p-6 pt-8">
                                            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">Hapus Iuran Ini?</h3>
                                            <p class="text-sm text-gray-500">Iuran <strong>{{ $item->nama_iuran }}</strong> akan dihapus. Lanjutkan?</p>
                                        </div>
                                        <form action="{{ route('admin.contributions.destroy', $item->id) }}" method="POST" class="p-6 pt-0 flex gap-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="deleteOpen = false" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100">Batal</button>
                                            <button type="submit" class="flex-[2] px-4 py-2.5 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">Belum ada daftar iuran. Klik "Tambah Iuran" untuk memulai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0 text-left" x-cloak style="display: none;">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            
            <div @click.away="showModal = false" class="relative bg-white rounded-2xl shadow-2xl w-full sm:w-96 z-10 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-800">Tambah Tagihan Iuran</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-red-500 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <form action="{{ route('admin.contributions.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Iuran</label>
                            <input type="text" name="nama_iuran" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm" placeholder="Contoh: Iuran Bulanan Warga" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nominal (Rupiah)</label>
                            <input type="number" name="nominal" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm" placeholder="Contoh: 50000" min="0" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" rows="2" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm" placeholder="Keterangan tagihan..."></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100">Batal</button>
                        <button type="submit" class="flex-[2] px-4 py-2.5 text-sm font-bold text-white bg-amber-800 rounded-lg hover:bg-amber-950 shadow-md">Simpan Tagihan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-sidebar-layout>