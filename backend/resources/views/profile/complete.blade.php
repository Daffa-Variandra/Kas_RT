<x-sidebar-layout>
    <x-slot name="header">Lengkapi Profil Warga</x-slot>

    <div class="max-w-2xl mx-auto mt-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-teal-100/50 border border-gray-100 overflow-hidden">
            
            <div class="bg-emerald-600 p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-2xl font-black italic tracking-tight">Halo, Warga 🙋‍♂️</h2>
                    <p class="text-teal-100 text-sm mt-1">Satu langkah lagi sebelum kamu bisa mulai bayar iuran dan lapor kas di Sistem Smart RW 005.</p>
                </div>
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
            </div>

            <form action="{{ route('profile.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-teal-600 uppercase tracking-widest px-1">Nomor Kartu Keluarga (KK)</label>
                        <input type="text" name="no_kk" maxlength="16" 
                               class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 transition-all text-sm font-bold @error('no_kk') ring-2 ring-red-500 @enderror" 
                               placeholder="16 Digit KK" value="{{ old('no_kk') }}" required>
                        @error('no_kk') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-teal-600 uppercase tracking-widest px-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" maxlength="16" 
                               class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 transition-all text-sm font-bold @error('nik') ring-2 ring-red-500 @enderror" 
                               placeholder="16 Digit NIK" value="{{ old('nik') }}" required>
                        @error('nik') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-teal-600 uppercase tracking-widest px-1">Nomor WhatsApp / HP</label>
                        <input type="text" name="no_hp" 
                               class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 transition-all text-sm font-bold" 
                               placeholder="0813xxxxxxxx" value="{{ old('no_hp') }}" required>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-teal-600 uppercase tracking-widest px-1">Alamat Lengkap (Blok/No Rumah)</label>
                    <textarea name="alamat" rows="2" 
                              class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 transition-all text-sm font-bold" 
                              placeholder="Contoh: Blok E 2 No. 20" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black text-teal-600 uppercase tracking-widest px-1">Status</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 bg-gray-50 rounded-2xl cursor-pointer hover:bg-teal-50 transition-colors border-2 border-transparent has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50">
                            <input type="radio" name="status_hunian" value="Tetap" class="hidden" checked>
                            <span class="text-sm font-bold text-gray-700">Tetap</span>
                        </label>
                        <label class="relative flex items-center p-4 bg-gray-50 rounded-2xl cursor-pointer hover:bg-teal-50 transition-colors border-2 border-transparent has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50">
                            <input type="radio" name="status_hunian" value="Kontrak" class="hidden">
                            <span class="text-sm font-bold text-gray-700">Kontrak</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-emerald-600 text-white p-5 rounded-2xl font-black shadow-lg shadow-teal-100 hover:bg-emerald-900 hover:scale-[1.01] active:scale-95 transition-all uppercase tracking-widest">
                        Simpan
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-4 font-bold uppercase tracking-tighter">
                        Pastikan data benar. Data ini akan digunakan untuk laporan Smart RW 005.
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-sidebar-layout>
