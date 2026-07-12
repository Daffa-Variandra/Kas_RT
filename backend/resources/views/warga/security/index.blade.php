<x-sidebar-layout>
    <x-slot name="header">Keamanan & Jadwal Ronda</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Jadwal Hari Ini -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-6 rounded-3xl shadow-lg text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                
                <h3 class="text-xs font-black uppercase tracking-widest text-emerald-100 mb-1">Ronda Hari Ini</h3>
                <h2 class="text-3xl font-black mb-6">{{ $today }}</h2>
                
                <div class="bg-white/10 p-4 rounded-2xl border border-white/20 backdrop-blur-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-200 mb-2">Petugas Jaga:</p>
                    <p class="text-sm font-bold leading-relaxed">
                        {{ $todaySchedule ? $todaySchedule->petugas : 'Tidak ada jadwal ronda hari ini.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Semua Jadwal -->
        <div class="lg:col-span-2">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Jadwal Regu Mingguan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                @endphp
                @foreach($days as $day)
                    @php
                        $schedule = $allSchedules->firstWhere('hari', $day);
                    @endphp
                    <div class="bg-white p-4 rounded-2xl shadow-sm border {{ $day == $today ? 'border-emerald-500 ring-2 ring-emerald-100' : 'border-slate-100' }}">
                        <h4 class="text-xs font-black uppercase tracking-widest {{ $day == $today ? 'text-emerald-600' : 'text-slate-400' }} mb-1">
                            {{ $day }} {!! $day == $today ? '<span class="text-[9px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full ml-1">HARI INI</span>' : '' !!}
                        </h4>
                        <p class="text-sm font-bold {{ $schedule ? 'text-slate-700' : 'text-slate-400 italic' }}">
                            {{ $schedule ? $schedule->petugas : 'Libur / Belum ada regu' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-sidebar-layout>
