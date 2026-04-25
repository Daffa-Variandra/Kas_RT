<x-sidebar-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('warga.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                        <div class="w-24 h-24 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-black">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-xs text-gray-400 uppercase font-black tracking-widest mt-1">Warga {{ $resident->status_hunian }}</p>
                    </div>

                    <div class="bg-amber-50 p-6 rounded-3xl border border-amber-100">
                        <h4 class="text-xs font-black text-amber-700 uppercase tracking-widest mb-2">Penting</h4>
                        <p class="text-[11px] text-amber-800 leading-relaxed">NIK tidak dapat diubah secara mandiri. Jika ada kesalahan NIK, silakan hubungi Pak RT/Admin.</p>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase px-1">NIK (Terkunci)</label>
                                <input type="text" value="{{ $resident->nik }}" class="w-full p-3 bg-gray-100 border-none rounded-2xl text-sm font-bold text-gray-400" readonly>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-indigo-600 uppercase px-1">No. WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ $resident->no_hp }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">{{ $resident->alamat }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Status Hunian</label>
                            <select name="status_hunian" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold">
                                <option value="Tetap" {{ $resident->status_hunian == 'Tetap' ? 'selected' : '' }}>Warga Tetap</option>
                                <option value="Kontrak" {{ $resident->status_hunian == 'Kontrak' ? 'selected' : '' }}>Warga Kontrak</option>
                            </select>
                        </div>

                        <hr class="border-gray-50 my-2">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Password Baru</label>
                                <input type="password" name="password" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Password baru">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-amber-800 text-white p-4 rounded-2xl font-black shadow-lg shadow-indigo-100 hover:bg-amber-950 transition-all uppercase tracking-widest text-xs">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-sidebar-layout>