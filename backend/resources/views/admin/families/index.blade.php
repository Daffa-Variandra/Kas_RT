<x-sidebar-layout>
    <x-slot name="header">Manajemen Warga - {{ auth()->user()->client->name ?? 'Lingkungan' }}</x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ showModal: {{ $errors->hasAny('email', 'password', 'no_kk', 'alamat', 'status_hunian') ? 'true' : 'false' }}, autoPassword: '' }">
        
        <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h3 class="text-lg font-black text-gray-700 italic">Data Keluarga / Kartu Keluarga</h3>
            <div class="flex flex-wrap gap-2" x-data="{ importModal: false }">
                <a href="{{ route('admin.families.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-2xl text-[10px] font-black transition-all flex items-center shadow-lg uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Excel
                </a>
                <button @click="importModal = true" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2.5 rounded-2xl text-[10px] font-black transition-all flex items-center shadow-lg uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Excel
                </button>
                <button @click="showModal = true; autoPassword = Math.random().toString(36).slice(-8)" class="bg-emerald-600 hover:bg-emerald-900 text-white px-4 py-2.5 rounded-2xl text-[10px] font-black transition-all flex items-center shadow-lg shadow-teal-100 uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Keluarga & Akun
                </button>

                <!-- Import Modal -->
                <div x-show="importModal" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center p-4" style="display: none;">
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                    <div @click.away="importModal = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-left">
                        <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Import Data Keluarga</h3>
                            <button @click="importModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.families.import') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
                            @csrf
                            <div class="bg-teal-50 text-teal-700 p-4 rounded-xl text-xs font-bold leading-relaxed">
                                Pastikan file berupa .xlsx atau .csv dan memiliki kolom Header berikut:<br>
                                <span class="text-[10px] bg-white px-2 py-1 rounded inline-block mt-2 tracking-wide">No KK | NIK | Nama | Email Login | No HP | Alamat | Status Hunian</span>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Pilih File (.xlsx / .csv)</label>
                                <input type="file" name="file" accept=".xlsx,.csv" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                            </div>
                            <div class="flex justify-end pt-1">
                                <a href="{{ route('admin.families.template') }}" class="text-[10px] font-bold text-teal-600 hover:text-teal-800 flex items-center transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download Template Excel
                                </a>
                            </div>
                            <div class="pt-4 flex gap-3">
                                <button type="button" @click="importModal = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                                <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-teal-600 rounded-2xl shadow-lg shadow-teal-100 uppercase tracking-widest">Proses Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">No KK & Akun</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status / Alamat</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($families as $family)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $family->no_kk }}</div>
                                <div class="text-[11px] text-gray-500 font-bold">Email: {{ $family->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-900 font-bold">{{ $family->alamat }}</div>
                                <span class="px-3 py-1 text-[9px] font-black {{ $family->status_hunian == 'Tetap' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} rounded-full uppercase italic tracking-tighter">{{ $family->status_hunian }}</span>
                            </td>
                            
                            <td class="px-6 py-4 text-center" x-data="{ editOpen: false, deleteOpen: false }">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.families.show', $family->id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all">Kelola Anggota</a>
                                    <button @click="editOpen = true" class="px-3 py-1.5 bg-teal-50 text-teal-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">Edit</button>
                                    <button @click="deleteOpen = true" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">Hapus</button>
                                </div>

                                <!-- Edit Modal -->
                                <div x-show="editOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                                    <div @click.away="editOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl z-10 overflow-hidden text-left">
                                        <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                            <div>
                                                <h3 class="text-lg font-black text-gray-800 italic">Edit Keluarga: {{ $family->no_kk }}</h3>
                                            </div>
                                            <button @click="editOpen = false" class="text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.families.update', $family->id) }}" method="POST" class="p-8">
                                            @csrf @method('PUT')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="space-y-4">
                                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1 border-l-2 border-teal-500 ml-1">Data Akun (Login)</h4>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-teal-600 uppercase mb-1 px-1">Email</label>
                                                        <input type="email" name="email" value="{{ $family->user->email }}" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                                    </div>
                                                    <div x-data="{ showPass: false }">
                                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 px-1">Reset Password (Opsional)</label>
                                                        <div class="relative">
                                                            <input :type="showPass ? 'text' : 'password'" name="password" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm pr-10" placeholder="Isi jika ingin ganti">
                                                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-2.5 text-gray-400 hover:text-teal-600 transition">
                                                                <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="space-y-4">
                                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1 border-l-2 border-teal-500 ml-1">Data KK</h4>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-teal-600 uppercase mb-1 px-1">No KK</label>
                                                        <input type="text" name="no_kk" value="{{ $family->no_kk }}" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" maxlength="16">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-teal-600 uppercase mb-1 px-1">Status Hunian</label>
                                                        <select name="status_hunian" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                                            <option value="Tetap" {{ $family->status_hunian == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                                            <option value="Kontrak" {{ $family->status_hunian == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <label class="block text-[10px] font-bold text-teal-600 uppercase mb-1 px-1">Alamat Lengkap</label>
                                                <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">{{ $family->alamat }}</textarea>
                                            </div>
                                            <div class="mt-8 flex gap-3">
                                                <button type="button" @click="editOpen = false" class="flex-1 px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-100 rounded-2xl">Batal</button>
                                                <button type="submit" class="flex-[2] px-6 py-3 text-xs font-black text-white uppercase tracking-widest bg-emerald-600 rounded-2xl shadow-lg shadow-teal-100">Update Keluarga</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div x-show="deleteOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-red-900/40 backdrop-blur-sm"></div>
                                    <div @click.away="deleteOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
                                        <div class="w-20 h-20 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 italic">Hapus Keluarga Ini?</h3>
                                        <p class="text-xs text-gray-500 mt-2 font-bold uppercase tracking-tight">Menghapus <span class="text-red-600">{{ $family->no_kk }}</span> akan menghilangkan semua data anggota & iurannya secara permanen.</p>
                                        <form action="{{ route('admin.families.destroy', $family->id) }}" method="POST" class="mt-8 flex gap-3">
                                            @csrf @method('DELETE')
                                            <button type="button" @click="deleteOpen = false" class="flex-1 py-3 text-[10px] font-black bg-gray-100 text-gray-400 rounded-2xl uppercase tracking-widest">Batal</button>
                                            <button type="submit" class="flex-1 py-3 text-[10px] font-black bg-red-600 text-white rounded-2xl uppercase tracking-widest shadow-lg shadow-red-100">Ya, Hapus!</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-gray-300 font-black uppercase text-xs italic">Belum ada keluarga terdaftar</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div class="fixed inset-0 bg-emerald-800/60 backdrop-blur-sm"></div>
            <div @click.away="showModal = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-left">
                <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Buat Data Keluarga</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.families.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Alamat Email (Login)</label>
                        <input type="email" name="email" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" placeholder="email@warga.com" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Password Default (Auto-Generated)</label>
                        <input type="text" name="password" x-model="autoPassword" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-emerald-600" placeholder="Otomatis atau ketik manual" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">No KK</label>
                        <input type="text" name="no_kk" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" placeholder="16 Digit KK" required maxlength="16">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Alamat</label>
                        <textarea name="alamat" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required></textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Status Hunian</label>
                        <select name="status_hunian" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-emerald-600 rounded-2xl shadow-lg shadow-teal-100 uppercase tracking-widest">Simpan Keluarga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>