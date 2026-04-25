<x-sidebar-layout>
    <x-slot name="header">Manajemen Warga RT 005 Taman Elok</x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ showModal: {{ $errors->hasAny('name', 'email', 'password') ? 'true' : 'false' }} }">
        
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-black text-gray-700 italic">Data Seluruh Warga</h3>
            <button @click="showModal = true" class="bg-amber-800 hover:bg-amber-950 text-white px-5 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center shadow-lg shadow-indigo-100 uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Akun Warga
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama & Email</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Profil</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($users as $user)
                        <tr class="hover:bg-indigo-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $user->name }}</div>
                                <div class="text-[11px] text-gray-500 font-bold">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->resident)
                                    <span class="px-3 py-1 text-[9px] font-black bg-green-100 text-green-700 rounded-full uppercase italic tracking-tighter">Profil Lengkap</span>
                                @else
                                    <span class="px-3 py-1 text-[9px] font-black bg-red-100 text-red-700 rounded-full uppercase italic tracking-tighter">Belum Isi Bio</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 text-center" x-data="{ editOpen: false, deleteOpen: false }">
                                <div class="flex justify-center space-x-2">
                                    <button @click="editOpen = true" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-amber-800 hover:text-white transition-all">Edit Bio</button>
                                    <button @click="deleteOpen = true" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">Hapus</button>
                                </div>

                                <div x-show="editOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                                    <div @click.away="editOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl z-10 overflow-hidden text-left">
                                        <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                            <div>
                                                <h3 class="text-lg font-black text-gray-800 italic">Full Edit Bio: {{ $user->name }}</h3>
                                                <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest">Otoritas Admin RT 003</p>
                                            </div>
                                            <button @click="editOpen = false" class="text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>

                                        <form action="{{ route('admin.residents.update', $user->id) }}" method="POST" class="p-8">
                                            @csrf @method('PUT')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="space-y-4">
                                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1 border-l-2 border-indigo-500 ml-1">Data Akun</h4>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1 px-1">Nama Lengkap</label>
                                                        <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1 px-1">Email</label>
                                                        <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 px-1">Reset Password (Opsional)</label>
                                                        <input type="password" name="password" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Isi jika ingin ganti">
                                                    </div>
                                                </div>

                                                <div class="space-y-4">
                                                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1 border-l-2 border-indigo-500 ml-1">Data Identitas</h4>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1 px-1">NIK (16 Digit)</label>
                                                        <input type="text" name="nik" value="{{ $user->resident->nik ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold" maxlength="16">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1 px-1">No. HP / WA</label>
                                                        <input type="text" name="no_hp" value="{{ $user->resident->no_hp ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1 px-1">Status Hunian</label>
                                                        <select name="status_hunian" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                                                            <option value="Tetap" {{ ($user->resident->status_hunian ?? '') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                                            <option value="Kontrak" {{ ($user->resident->status_hunian ?? '') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <label class="block text-[10px] font-bold text-indigo-600 uppercase mb-1 px-1">Alamat Lengkap</label>
                                                <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">{{ $user->resident->alamat ?? '' }}</textarea>
                                            </div>
                                            <div class="mt-8 flex gap-3">
                                                <button type="button" @click="editOpen = false" class="flex-1 px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-100 rounded-2xl">Batal</button>
                                                <button type="submit" class="flex-[2] px-6 py-3 text-xs font-black text-white uppercase tracking-widest bg-amber-800 rounded-2xl shadow-lg shadow-indigo-100">Update Seluruh Bio</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div x-show="deleteOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-red-900/40 backdrop-blur-sm"></div>
                                    <div @click.away="deleteOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
                                        <div class="w-20 h-20 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 italic">Hapus Warga Ini?</h3>
                                        <p class="text-xs text-gray-500 mt-2 font-bold uppercase tracking-tight">Menghapus <span class="text-red-600">{{ $user->name }}</span> akan menghilangkan semua data iuran & bionya secara permanen.</p>
                                        <form action="{{ route('admin.residents.destroy', $user->id) }}" method="POST" class="mt-8 flex gap-3">
                                            @csrf @method('DELETE')
                                            <button type="button" @click="deleteOpen = false" class="flex-1 py-3 text-[10px] font-black bg-gray-100 text-gray-400 rounded-2xl uppercase tracking-widest">Batal</button>
                                            <button type="submit" class="flex-1 py-3 text-[10px] font-black bg-red-600 text-white rounded-2xl uppercase tracking-widest shadow-lg shadow-red-100">Ya, Hapus!</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-gray-300 font-black uppercase text-xs italic">Belum ada warga terdaftar</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div class="fixed inset-0 bg-amber-900/60 backdrop-blur-sm"></div>
            <div @click.away="showModal = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-left">
                <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Buat Akun Warga Baru</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.residents.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1 px-1">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold" placeholder="Nama sesuai KTP" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1 px-1">Alamat Email</label>
                        <input type="email" name="email" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold" placeholder="email@warga.com" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1 px-1">Password Default</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold" placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-2xl border border-indigo-100">
                        <p class="text-[10px] text-indigo-700 font-bold leading-relaxed">
                            💡 Setelah akun dibuat, instruksikan warga untuk login dan melengkapi data Bio (NIK & Alamat) secara mandiri.
                        </p>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-amber-800 rounded-2xl shadow-lg shadow-indigo-100 uppercase tracking-widest">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>