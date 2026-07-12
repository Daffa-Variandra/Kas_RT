<x-sidebar-layout>
    <x-slot name="header">Pengeluaran Kas - {{ auth()->user()->client->name ?? 'Lingkungan' }}</x-slot>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 text-white shadow-xl shadow-teal-200/50 w-full md:w-1/3 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Total Pengeluaran (Filter)</p>
                <h2 class="text-3xl font-black mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        </div>

        <div class="w-full md:w-2/3 bg-white rounded-3xl p-4 md:p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center">
            <form action="{{ route('bendahara.expenses.index') }}" method="GET" class="flex items-center gap-3 w-full">
                <div class="flex-1">
                    <select name="bulan" class="w-full p-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <select name="tahun" class="w-full p-2.5 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700">
                        <option value="">Semua Tahun</option>
                        @php $currentYear = date('Y'); @endphp
                        @for($y = $currentYear; $y >= $currentYear - 3; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-gray-900 text-white px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all">Filter</button>
                </div>
            </form>
            
            <div x-data="{ openAdd: false }">
                <button @click="openAdd = true" class="whitespace-nowrap bg-teal-500 text-white px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-teal-600 transition-all flex items-center shadow-lg shadow-teal-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Catat Pengeluaran
                </button>

                <!-- Modal Tambah -->
                <div x-show="openAdd" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" style="display: none;">
                    <div @click.away="openAdd = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-black text-gray-800 text-lg">Catat Pengeluaran Baru</h3>
                            <button @click="openAdd = false" class="text-gray-400 hover:text-red-500 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                        <form action="{{ route('bendahara.expenses.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Judul / Keterangan Singkat</label>
                                    <input type="text" name="title" required class="w-full p-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700 placeholder-gray-300" placeholder="Contoh: Bayar Listrik Pos Kamling">
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kategori</label>
                                    <select name="category" required class="w-full p-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700">
                                        <option value="Keamanan">Keamanan (Ronda, Satpam, dll)</option>
                                        <option value="Kebersihan">Kebersihan (Sampah, Taman, dll)</option>
                                        <option value="Infrastruktur">Infrastruktur (Jalan, PJU, dll)</option>
                                        <option value="Sosial">Sosial (Santunan, Bantuan, dll)</option>
                                        <option value="Administrasi">Administrasi (ATK, Fotokopi, dll)</option>
                                        <option value="Lain-lain">Lain-lain</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nominal (Rp)</label>
                                    <input type="number" name="amount" min="1" required class="w-full p-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700 placeholder-gray-300">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tanggal Pengeluaran</label>
                                    <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}" class="w-full p-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bukti Nota/Kwitansi (Opsional)</label>
                                    <input type="file" name="receipt" accept="image/*" class="w-full p-2 bg-gray-50 border-none rounded-xl text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Catatan Tambahan (Opsional)</label>
                                    <textarea name="notes" rows="2" class="w-full p-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-teal-500 text-sm font-bold text-gray-700"></textarea>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end gap-3">
                                <button type="button" @click="openAdd = false" class="px-5 py-2.5 rounded-xl font-bold text-sm text-gray-500 hover:bg-gray-100 transition">Batal</button>
                                <button type="submit" class="bg-teal-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-teal-600 transition shadow-lg shadow-teal-200">Simpan Pengeluaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Riwayat Pengeluaran Kas</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Judul / Keterangan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Nominal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">Bukti Nota</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($expenses as $e)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                            {{ \Carbon\Carbon::parse($e->expense_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900">{{ $e->title }}</div>
                            @if($e->notes)
                                <div class="text-[10px] text-gray-400 font-medium mt-1">{{ Str::limit($e->notes, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $catColor = 'bg-gray-100 text-gray-600';
                                if($e->category == 'Keamanan') $catColor = 'bg-blue-50 text-blue-600';
                                if($e->category == 'Kebersihan') $catColor = 'bg-green-50 text-green-600';
                                if($e->category == 'Infrastruktur') $catColor = 'bg-orange-50 text-orange-600';
                                if($e->category == 'Sosial') $catColor = 'bg-pink-50 text-pink-600';
                                if($e->category == 'Administrasi') $catColor = 'bg-purple-50 text-purple-600';
                            @endphp
                            <span class="px-3 py-1 {{ $catColor }} rounded-lg text-[10px] font-black uppercase tracking-tight">
                                {{ $e->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-black text-red-600 font-mono">-Rp {{ number_format($e->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($e->receipt_path)
                                <div x-data="{ openImg: false }">
                                    <button @click="openImg = true" class="text-teal-600 hover:text-teal-800 bg-teal-50 p-2 rounded-xl transition inline-flex">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    
                                    <div x-show="openImg" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" style="display: none;">
                                        <div @click.away="openImg = false" class="relative max-w-2xl w-full">
                                            <button @click="openImg = false" class="absolute -top-10 right-0 text-white hover:text-gray-300"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            <img src="{{ Storage::url($e->receipt_path) }}" class="w-full h-auto max-h-[80vh] object-contain rounded-xl shadow-2xl">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-[10px] text-gray-300 italic font-medium">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('bendahara.expenses.destroy', $e->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin membatalkan/menghapus pengeluaran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-bold uppercase text-xs">Belum ada data pengeluaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
