<x-sidebar-layout>
    <x-slot name="header">Detail Keluarga: {{ $family->no_kk }}</x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ showModal: {{ $errors->hasAny('nik', 'nama', 'no_hp', 'status_keluarga') ? 'true' : 'false' }} }">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.families.index') }}" class="text-sm text-teal-600 font-bold flex items-center hover:text-teal-800">
                &larr; Kembali ke Daftar Keluarga
            </a>
            <button @click="showModal = true" class="bg-emerald-600 hover:bg-emerald-900 text-white px-5 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center shadow-lg shadow-teal-100 uppercase tracking-widest">
                Tambah Anggota
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100" x-data="{ resetOpen: false, showPass: false }">
                <h4 class="text-xs font-black text-gray-400 uppercase mb-2">Info Akun</h4>
                <p class="text-sm font-bold">{{ $family->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $family->user->email }}</p>
                
                <button @click="resetOpen = !resetOpen" class="mt-3 text-[10px] font-black text-teal-600 uppercase tracking-widest hover:text-teal-800 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    Reset Password
                </button>

                <div x-show="resetOpen" class="mt-4 p-4 bg-gray-50 rounded-2xl border border-gray-100" style="display: none;">
                    <form action="{{ route('admin.families.update', $family->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="email" value="{{ $family->user->email }}">
                        <input type="hidden" name="no_kk" value="{{ $family->no_kk }}">
                        <input type="hidden" name="alamat" value="{{ $family->alamat }}">
                        <input type="hidden" name="status_hunian" value="{{ $family->status_hunian }}">
                        
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Password Baru</label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold pr-10" placeholder="Minimal 8 karakter" required minlength="8">
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-2 text-gray-400 hover:text-teal-600 transition">
                                <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <button type="submit" class="mt-3 w-full py-2 text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl uppercase tracking-widest shadow-md transition">Simpan Password</button>
                    </form>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 md:col-span-2">
                <h4 class="text-xs font-black text-gray-400 uppercase mb-2">Info Tempat Tinggal</h4>
                <p class="text-sm font-bold">{{ $family->alamat }}</p>
                <p class="text-xs text-gray-500 mt-1">Status: <span class="uppercase tracking-widest">{{ $family->status_hunian }}</span></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">NIK & Nama</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status / Kontak</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($family->residents as $resident)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $resident->nama }}</div>
                                <div class="text-[11px] text-gray-500 font-bold">NIK: {{ $resident->nik }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[9px] font-black bg-teal-100 text-teal-700 rounded-full uppercase italic tracking-tighter">{{ $resident->status_keluarga }}</span>
                                <div class="text-[11px] text-gray-500 font-bold mt-1">HP: {{ $resident->no_hp ?? '-' }}</div>
                            </td>
                            
                            <td class="px-6 py-4 text-center" x-data="{ editOpen: false, deleteOpen: false }">
                                <div class="flex justify-center space-x-2">
                                    <button @click="editOpen = true" class="px-3 py-1.5 bg-teal-50 text-teal-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">Edit</button>
                                    <button @click="deleteOpen = true" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">Hapus</button>
                                </div>

                                <!-- Edit Modal -->
                                <div x-show="editOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                                    <div @click.away="editOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-left">
                                        <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                            <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Edit Warga</h3>
                                            <button @click="editOpen = false" class="text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.residents.update', $resident->id) }}" method="POST" class="p-8 space-y-5">
                                            @csrf @method('PUT')
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">NIK</label>
                                                <input type="text" name="nik" value="{{ $resident->nik }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required maxlength="16">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Nama Lengkap</label>
                                                <input type="text" name="nama" value="{{ $resident->nama }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Status Keluarga</label>
                                                <select name="status_keluarga" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                                                    <option value="Kepala Keluarga" {{ $resident->status_keluarga == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                                    <option value="Istri" {{ $resident->status_keluarga == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                    <option value="Anak" {{ $resident->status_keluarga == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                    <option value="Lainnya" {{ $resident->status_keluarga == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">No HP</label>
                                                <input type="text" name="no_hp" value="{{ $resident->no_hp }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                            </div>
                                            <div class="pt-4 flex gap-3">
                                                <button type="button" @click="editOpen = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                                                <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-emerald-600 rounded-2xl shadow-lg shadow-teal-100 uppercase tracking-widest">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div x-show="deleteOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-red-900/40 backdrop-blur-sm"></div>
                                    <div @click.away="deleteOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
                                        <h3 class="text-xl font-black text-gray-900 italic">Hapus Anggota?</h3>
                                        <p class="text-xs text-gray-500 mt-2 font-bold uppercase tracking-tight">Menghapus <span class="text-red-600">{{ $resident->nama }}</span>.</p>
                                        <form action="{{ route('admin.residents.destroy', $resident->id) }}" method="POST" class="mt-8 flex gap-3">
                                            @csrf @method('DELETE')
                                            <button type="button" @click="deleteOpen = false" class="flex-1 py-3 text-[10px] font-black bg-gray-100 text-gray-400 rounded-2xl uppercase tracking-widest">Batal</button>
                                            <button type="submit" class="flex-1 py-3 text-[10px] font-black bg-red-600 text-white rounded-2xl uppercase tracking-widest shadow-lg shadow-red-100">Ya, Hapus!</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-gray-300 font-black uppercase text-xs italic">Belum ada anggota keluarga</td></tr>
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
                    <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Tambah Anggota Keluarga</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.residents.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <input type="hidden" name="family_id" value="{{ $family->id }}">
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">NIK</label>
                        <input type="text" name="nik" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required maxlength="16">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Status Keluarga</label>
                        <select name="status_keluarga" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">No HP</label>
                        <input type="text" name="no_hp" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-emerald-600 rounded-2xl shadow-lg shadow-teal-100 uppercase tracking-widest">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
