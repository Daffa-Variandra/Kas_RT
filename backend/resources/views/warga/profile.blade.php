<x-sidebar-layout>
    <x-slot name="header">Profil Saya</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('warga.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm text-center">
                        <div class="w-24 h-24 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-black">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-xs text-gray-400 uppercase font-black tracking-widest mt-1">Warga {{ $family->status_hunian ?? 'Tetap' }}</p>
                    </div>

                    <div class="bg-emerald-50 p-6 rounded-3xl border border-emerald-100">
                        <h4 class="text-xs font-black text-emerald-700 uppercase tracking-widest mb-2">Penting</h4>
                        <p class="text-[11px] text-emerald-600 leading-relaxed">NIK tidak dapat diubah secara mandiri. Jika ada kesalahan NIK, silakan hubungi Admin/Pengurus.</p>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-teal-600 uppercase px-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                @error('name') <p class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-teal-600 uppercase px-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                @error('email') <p class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase px-1">NIK (Terkunci)</label>
                                <input type="text" value="{{ $resident->nik ?? '' }}" class="w-full p-3 bg-gray-100 border-none rounded-2xl text-sm font-bold text-gray-400" readonly>
                                <input type="hidden" name="nik" value="{{ $resident->nik ?? '' }}">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase px-1">No. KK (Terkunci)</label>
                                <input type="text" value="{{ $family->no_kk ?? '' }}" class="w-full p-3 bg-gray-100 border-none rounded-2xl text-sm font-bold text-gray-400" readonly>
                                <input type="hidden" name="no_kk" value="{{ $family->no_kk ?? '' }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-teal-600 uppercase px-1">No. WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $resident->no_hp ?? '') }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                @error('no_hp') <p class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-teal-600 uppercase px-1">Status Hunian</label>
                                <select name="status_hunian" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">
                                    <option value="Tetap" {{ old('status_hunian', $family->status_hunian ?? '') == 'Tetap' ? 'selected' : '' }}>Warga Tetap</option>
                                    <option value="Kontrak" {{ old('status_hunian', $family->status_hunian ?? '') == 'Kontrak' ? 'selected' : '' }}>Warga Kontrak</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1 mt-5">
                            <label class="text-[10px] font-black text-teal-600 uppercase px-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold">{{ $family->alamat ?? '' }}</textarea>
                        </div>

                        <hr class="border-gray-50 my-2">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5" x-data="{ showPass1: false, showPass2: false }">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-teal-600 uppercase px-1">Password Baru</label>
                                <div class="relative">
                                    <input :type="showPass1 ? 'text' : 'password'" name="password" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm pr-10" placeholder="Password baru">
                                    <button type="button" @click="showPass1 = !showPass1" class="absolute right-3 top-3 text-gray-400 hover:text-teal-600 transition">
                                        <svg x-show="!showPass1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg x-show="showPass1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-teal-600 uppercase px-1">Konfirmasi Password</label>
                                <div class="relative">
                                    <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm pr-10" placeholder="Ulangi password baru">
                                    <button type="button" @click="showPass2 = !showPass2" class="absolute right-3 top-3 text-gray-400 hover:text-teal-600 transition">
                                        <svg x-show="!showPass2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg x-show="showPass2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-emerald-600 text-white p-4 rounded-2xl font-black shadow-lg shadow-teal-100 hover:bg-emerald-900 transition-all uppercase tracking-widest text-xs">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-sidebar-layout>