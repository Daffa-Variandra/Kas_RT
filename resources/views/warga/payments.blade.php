<x-sidebar-layout>
    <x-slot name="header">Pembayaran & Riwayat Iuran</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ proofModal: false, activeImg: '' }">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="px-6 py-5 border-b border-gray-50 bg-indigo-50/30">
                    <h3 class="font-bold text-indigo-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Setor Iuran Baru
                    </h3>
                </div>

                <form action="{{ route('warga.payments.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4" x-data="{ nominal: '' }">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Pilih Iuran</label>
                        <select name="contribution_id" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold"
                                @change="nominal = $event.target.options[$event.target.selectedIndex].dataset.nominal" required>
                            <option value="" data-nominal="">-- Klik untuk Pilih --</option>
                            @foreach($contributions as $item)
                                <option value="{{ $item->id }}" data-nominal="{{ (int)$item->nominal }}">{{ $item->nama_iuran }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Nominal Otomatis</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm font-bold text-gray-400">Rp</span>
                            <input type="number" name="jumlah_bayar" x-model="nominal" class="w-full pl-10 pr-4 py-3 bg-gray-100 border-none rounded-2xl text-sm font-black text-gray-700" readonly required>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" class="w-full p-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold" required>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-indigo-600 uppercase px-1">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_bayar" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-amber-800 file:text-white hover:file:bg-amber-900" required>
                    </div>

                    <button type="submit" class="w-full bg-amber-800 text-white p-4 rounded-2xl font-black shadow-lg shadow-indigo-100 hover:bg-amber-950 transition-all uppercase text-xs tracking-widest">
                        Kirim ke Bendahara
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 tracking-tight">Riwayat Pembayaran Saya</h3>
                    <span class="text-[10px] font-black text-gray-400 uppercase bg-gray-50 px-3 py-1 rounded-full italic">{{ count($payments) }} Transaksi</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Detail Iuran</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">Status</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($payments as $p)
                            <tr class="hover:bg-indigo-50/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-gray-900">{{ $p->contribution->nama_iuran }}</div>
                                    <div class="text-[11px] text-gray-500 font-bold">
                                        {{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y') }} • 
                                        <span class="text-indigo-600">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($p->status == 'success')
                                        <span class="px-3 py-1 text-[9px] font-black bg-green-100 text-green-700 rounded-full uppercase italic">Lunas</span>
                                    @elseif($p->status == 'failed')
                                        <span class="px-3 py-1 text-[9px] font-black bg-red-100 text-red-700 rounded-full uppercase italic">Gagal</span>
                                    @else
                                        <span class="px-3 py-1 text-[9px] font-black bg-amber-100 text-amber-700 rounded-full uppercase italic">Dicek</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button @click="proofModal = true; activeImg = '{{ Storage::url($p->bukti_bayar) }}'" 
                                            class="text-indigo-600 hover:text-indigo-900 text-[10px] font-black uppercase tracking-widest bg-indigo-50 px-3 py-2 rounded-xl transition-all">
                                        Lihat Bukti
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="text-gray-300 mb-2">
                                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </div>
                                    <p class="text-xs font-bold text-gray-400 uppercase">Belum ada transaksi</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="proofModal" 
             class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm"
             x-cloak style="display: none;">
            <div @click.away="proofModal = false" class="relative max-w-lg w-full bg-white rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <span class="text-[10px] font-black text-gray-400 uppercase">Pratinjau Bukti Transfer</span>
                    <button @click="proofModal = false" class="text-gray-400 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4 bg-gray-200">
                    <img :src="activeImg" class="w-full rounded-2xl shadow-inner max-h-[70vh] object-contain mx-auto" alt="Bukti Bayar">
                </div>
            </div>
        </div>

    </div>
</x-sidebar-layout>