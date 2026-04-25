<x-sidebar-layout>
    <x-slot name="header">Verifikasi Iuran Warga</x-slot>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ proofModal: false, activeImg: '' }">
        <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Daftar Masuk Pembayaran</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Warga & Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase">Iuran & Nominal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">Bukti</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase text-right">Aksi Bendahara</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payments as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900">{{ $p->user->name }}</div>
                            <div class="text-[11px] text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-indigo-900">{{ $p->contribution->nama_iuran }}</div>
                            <div class="text-sm font-black text-indigo-600 font-mono">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="proofModal = true; activeImg = '{{ Storage::url($p->bukti_bayar) }}'" 
                                    class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all shadow-sm border border-indigo-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status == 'success')
                                <span class="px-3 py-1 text-[9px] font-black bg-green-100 text-green-700 rounded-full uppercase">Berhasil</span>
                            @elseif($p->status == 'failed')
                                <span class="px-3 py-1 text-[9px] font-black bg-red-100 text-red-700 rounded-full uppercase">Ditolak</span>
                            @else
                                <span class="px-3 py-1 text-[9px] font-black bg-amber-100 text-amber-700 rounded-full uppercase italic animate-pulse">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($p->status == 'pending')
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('bendahara.verification.update', $p->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="success">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-xl shadow-lg shadow-green-100 transition-all active:scale-90" title="Terima">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('bendahara.verification.update', $p->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="failed">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-xl shadow-lg shadow-red-100 transition-all active:scale-90" title="Tolak">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="text-[10px] font-bold text-gray-400 uppercase italic">Sudah Diproses</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic font-bold uppercase text-xs tracking-widest">Antrean Pembayaran Kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="proofModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm" x-cloak style="display: none;">
            <div @click.away="proofModal = false" class="relative max-w-lg w-full bg-white rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Cek Struk Transfer</span>
                    <button @click="proofModal = false" class="text-gray-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="p-4 bg-gray-100"><img :src="activeImg" class="w-full rounded-2xl shadow-inner max-h-[70vh] object-contain mx-auto"></div>
            </div>
        </div>
    </div>
</x-sidebar-layout>