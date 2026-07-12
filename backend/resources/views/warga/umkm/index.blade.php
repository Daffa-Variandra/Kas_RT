<x-sidebar-layout>
    <x-slot name="header">Marketplace UMKM Warga</x-slot>

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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Form Pendaftaran UMKM Saya -->
        <div class="xl:col-span-1">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 sticky top-6">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight mb-1">{{ $myUmkm ? 'Profil Usaha Saya' : 'Daftarkan Usaha Anda' }}</h3>
                <p class="text-[10px] text-slate-400 font-bold mb-6">Promosikan produk/jasa ke tetangga sekitar.</p>
                
                <form action="{{ route('warga.umkms.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nama Usaha/Toko</label>
                        <input type="text" name="nama_usaha" value="{{ $myUmkm->nama_usaha ?? old('nama_usaha') }}" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Kategori</label>
                        <select name="kategori" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                            <option value="Makanan & Minuman" {{ ($myUmkm->kategori ?? '') == 'Makanan & Minuman' ? 'selected' : '' }}>Makanan & Minuman</option>
                            <option value="Jasa & Servis" {{ ($myUmkm->kategori ?? '') == 'Jasa & Servis' ? 'selected' : '' }}>Jasa & Servis</option>
                            <option value="Pakaian & Fashion" {{ ($myUmkm->kategori ?? '') == 'Pakaian & Fashion' ? 'selected' : '' }}>Pakaian & Fashion</option>
                            <option value="Kebutuhan Harian" {{ ($myUmkm->kategori ?? '') == 'Kebutuhan Harian' ? 'selected' : '' }}>Kebutuhan Harian</option>
                            <option value="Lainnya" {{ ($myUmkm->kategori ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nomor WhatsApp (Aktif)</label>
                        <input type="text" name="nomor_whatsapp" value="{{ $myUmkm->nomor_whatsapp ?? old('nomor_whatsapp') }}" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required placeholder="Contoh: 08123456789">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required placeholder="Ceritakan sedikit tentang produk/jasa Anda...">{{ $myUmkm->deskripsi ?? old('deskripsi') }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-colors shadow-lg shadow-emerald-200">
                        {{ $myUmkm ? 'Simpan Perubahan' : 'Daftarkan Sekarang' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Direktori UMKM Warga -->
        <div class="xl:col-span-2">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Direktori UMKM ({{ $umkms->count() }})</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($umkms as $umkm)
                    <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 hover:border-emerald-200 transition-colors group flex flex-col h-full">
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-500 group-hover:bg-emerald-50 group-hover:text-emerald-700 rounded-full text-[9px] font-black uppercase tracking-widest transition-colors">{{ $umkm->kategori }}</span>
                        </div>
                        
                        <h4 class="text-lg font-black text-slate-800 leading-tight mb-1">{{ $umkm->nama_usaha }}</h4>
                        <p class="text-[10px] text-slate-400 font-bold mb-3 uppercase tracking-wider">Milik: {{ $umkm->user->name }}</p>
                        
                        <p class="text-xs text-slate-600 font-medium leading-relaxed mb-6 flex-1 line-clamp-3">{{ $umkm->deskripsi }}</p>
                        
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->nomor_whatsapp) }}" target="_blank" class="w-full py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl text-xs font-black uppercase tracking-widest flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964 1.003-3.509c-.628-1.054-.959-2.261-.959-3.504 0-3.805 3.097-6.903 6.906-6.903 3.806 0 6.906 3.097 6.906 6.903 0 3.805-3.098 6.903-6.906 6.903z"/></svg>
                            Hubungi Penjual
                        </a>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-slate-100">
                        <p class="text-sm font-bold text-slate-500">Belum ada UMKM yang terdaftar di lingkungan Anda.</p>
                        <p class="text-xs text-slate-400 mt-1">Jadilah yang pertama mempromosikan usaha Anda!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-sidebar-layout>
