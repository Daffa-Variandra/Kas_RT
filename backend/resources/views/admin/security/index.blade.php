<x-sidebar-layout>
    <x-slot name="header">Keamanan & Ronda</x-slot>

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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Buku Tamu -->
        <div class="space-y-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Buku Tamu Masuk</h3>
                <button x-data @click="$dispatch('open-modal', 'add-guest')" class="px-3 py-1.5 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition">
                    + Tamu Baru
                </button>
            </div>
            
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="max-h-96 overflow-y-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 border-b border-slate-100 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase">Tamu & Tujuan</th>
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase">Waktu Masuk</th>
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($guests as $guest)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-4 py-3">
                                        <div class="text-xs font-black text-slate-800">{{ $guest->nama_tamu }}</div>
                                        <div class="text-[10px] text-slate-500 font-bold">{{ $guest->tujuan }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-xs font-bold text-slate-700">{{ $guest->waktu_masuk->format('d M, H:i') }}</div>
                                        @if($guest->waktu_keluar)
                                            <div class="text-[9px] text-slate-400 font-black uppercase tracking-widest mt-1">Keluar: {{ $guest->waktu_keluar->format('H:i') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if(!$guest->waktu_keluar)
                                        <form action="{{ route('admin.security.guest.updateOut', $guest->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="px-2 py-1 bg-amber-50 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-amber-100">Set Keluar</button>
                                        </form>
                                        @else
                                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-4 py-8 text-center text-xs font-bold text-slate-400">Belum ada riwayat tamu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Jadwal Ronda (Regu Mingguan) -->
        <div class="space-y-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Regu Ronda Mingguan</h3>
                <button x-data @click="$dispatch('open-modal', 'add-schedule')" class="px-3 py-1.5 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition">
                    Atur Regu
                </button>
            </div>

            <div class="space-y-3">
                @php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                @endphp
                @foreach($days as $day)
                    @php
                        $schedule = $schedules->firstWhere('hari', $day);
                    @endphp
                    <div class="bg-white p-4 rounded-2xl shadow-sm border {{ $schedule ? 'border-emerald-100' : 'border-slate-100 border-dashed' }} flex justify-between items-center">
                        <div>
                            <h4 class="text-xs font-black uppercase tracking-widest {{ $schedule ? 'text-emerald-600' : 'text-slate-400' }} mb-1">{{ $day }}</h4>
                            <p class="text-sm font-bold text-slate-700">{{ $schedule ? $schedule->petugas : 'Belum ada regu' }}</p>
                        </div>
                        @if($schedule)
                            <form action="{{ route('admin.security.schedule.destroy', $schedule->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 p-1" onclick="return confirm('Hapus regu ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Tambah Tamu -->
    <div x-data="{ show: false }" x-show="show" @open-modal.window="if ($event.detail === 'add-guest') show = true" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Catat Tamu Masuk</h3>
                <button @click="show = false" class="text-slate-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.security.guest.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Nama Tamu</label>
                    <input type="text" name="nama_tamu" class="w-full px-4 py-2 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Tujuan / Keperluan</label>
                    <input type="text" name="tujuan" class="w-full px-4 py-2 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required placeholder="Cth: Ke rumah Ketua">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Waktu Masuk</label>
                    <input type="datetime-local" name="waktu_masuk" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-2xl shadow-lg shadow-emerald-200 uppercase tracking-widest">Simpan Tamu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Atur Regu -->
    <div x-data="{ show: false }" x-show="show" @open-modal.window="if ($event.detail === 'add-schedule') show = true" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-tight">Atur Regu Ronda</h3>
                <button @click="show = false" class="text-slate-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.security.schedule.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Hari</label>
                    <select name="hari" class="w-full px-4 py-2 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $d)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1 px-1">Petugas (Regu)</label>
                    <textarea name="petugas" rows="3" class="w-full px-4 py-2 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-xs font-bold" required placeholder="Cth: Budi, Andi, Joko"></textarea>
                    <p class="text-[9px] text-slate-400 mt-1 ml-1">Pisahkan nama dengan koma.</p>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 text-[10px] font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-2xl shadow-lg shadow-emerald-200 uppercase tracking-widest">Simpan Regu</button>
                </div>
            </form>
        </div>
    </div>
</x-sidebar-layout>
