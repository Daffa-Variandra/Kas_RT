<x-sidebar-layout>
    <x-slot name="header">Manajemen Pengurus - {{ auth()->user()->client->name ?? 'Lingkungan' }}</x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }">
        
        <div class="mb-6 flex justify-between items-center">
            <h3 class="text-lg font-black text-gray-700 italic">Data Pengurus (Admin & Bendahara)</h3>
            <button @click="showModal = true" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center shadow-lg shadow-teal-200 uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Pengurus
            </button>
        </div>

        @if(session('success'))
        <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-xl text-sm font-bold border border-green-200">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-xl text-sm font-bold border border-red-200">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 border-b border-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak (Login)</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Peran (Role)</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($staffs as $staff)
                        <tr class="hover:bg-teal-50/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">{{ $staff->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-gray-600">{{ $staff->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($staff->role == 'admin')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest">Admin</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-[10px] font-black rounded-full uppercase tracking-widest">Bendahara</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center" x-data="{ editOpen: false, deleteOpen: false }">
                                <div class="flex justify-center space-x-2">
                                    <button @click="editOpen = true" class="px-3 py-1.5 bg-teal-50 text-teal-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-teal-600 hover:text-white transition-all">Edit</button>
                                    @if(auth()->id() !== $staff->id)
                                    <button @click="deleteOpen = true" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">Hapus</button>
                                    @endif
                                </div>

                                <!-- Edit Modal -->
                                <div x-show="editOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                                    <div @click.away="editOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-left">
                                        <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                            <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Edit Pengurus</h3>
                                            <button @click="editOpen = false" class="text-gray-400 hover:text-red-500 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" class="p-8 space-y-5">
                                            @csrf @method('PUT')
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Nama Lengkap</label>
                                                <input type="text" name="name" value="{{ $staff->name }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Email Login</label>
                                                <input type="email" name="email" value="{{ $staff->email }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Peran (Role)</label>
                                                <select name="role" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                                                    <option value="admin" {{ $staff->role == 'admin' ? 'selected' : '' }}>Admin (Pengurus Inti)</option>
                                                    <option value="bendahara" {{ $staff->role == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 px-1">Ubah Password (Opsional)</label>
                                                <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" placeholder="Kosongkan jika tidak diganti">
                                            </div>
                                            <div class="pt-4 flex gap-3">
                                                <button type="button" @click="editOpen = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                                                <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-teal-600 rounded-2xl shadow-lg shadow-teal-100 uppercase tracking-widest">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                @if(auth()->id() !== $staff->id)
                                <div x-show="deleteOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
                                    <div class="fixed inset-0 bg-red-900/40 backdrop-blur-sm"></div>
                                    <div @click.away="deleteOpen = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
                                        <div class="w-20 h-20 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </div>
                                        <h3 class="text-xl font-black text-gray-900 italic">Hapus Pengurus Ini?</h3>
                                        <p class="text-xs text-gray-500 mt-2 font-bold uppercase tracking-tight">Akun <span class="text-red-600">{{ $staff->name }}</span> akan dihapus permanen.</p>
                                        <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" class="mt-8 flex gap-3">
                                            @csrf @method('DELETE')
                                            <button type="button" @click="deleteOpen = false" class="flex-1 py-3 text-[10px] font-black bg-gray-100 text-gray-400 rounded-2xl uppercase tracking-widest">Batal</button>
                                            <button type="submit" class="flex-1 py-3 text-[10px] font-black bg-red-600 text-white rounded-2xl uppercase tracking-widest shadow-lg shadow-red-100">Ya, Hapus!</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div class="fixed inset-0 bg-teal-900/60 backdrop-blur-sm"></div>
            <div @click.away="showModal = false" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-left">
                <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-base font-black text-gray-800 italic uppercase tracking-tight">Tambah Pengurus Baru</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.staff.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" placeholder="Bpk. Budi Santoso" required>
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Alamat Email (Login)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" placeholder="email@rt005.com" required>
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" placeholder="Minimal 8 karakter" required>
                        @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1 px-1">Peran (Role)</label>
                        <select name="role" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold" required>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengurus Inti)</option>
                            <option value="bendahara" {{ old('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                        </select>
                        @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 text-[10px] font-black text-gray-400 bg-gray-100 rounded-2xl uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-[2] py-3 text-[10px] font-black text-white bg-teal-600 rounded-2xl shadow-lg shadow-teal-100 uppercase tracking-widest">Simpan Pengurus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
