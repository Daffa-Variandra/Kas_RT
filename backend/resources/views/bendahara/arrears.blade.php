<x-sidebar-layout>
    <x-slot name="header">Rekap Tunggakan Warga</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-700">Daftar Tagihan Belum Dibayar</h3>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl font-bold text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Warga / Keluarga</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tagihan Bulan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Jenis & Nominal</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-right">Aksi (WhatsApp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($arrears as $arr)
                    <tr class="hover:bg-red-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900">{{ $arr->user->name }}</div>
                            <div class="text-[11px] font-bold text-gray-500">
                                {{ $arr->user->family->alamat ?? 'Alamat tidak diketahui' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($arr->created_at)->format('F Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900">{{ $arr->contribution->nama_iuran }}</div>
                            <div class="text-xs font-bold text-red-600">Rp {{ number_format($arr->jumlah_bayar, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('bendahara.arrears.remind', $arr->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-md flex items-center inline-flex">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Kirim Reminder WA
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-emerald-300 mb-2">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-xs font-bold text-emerald-600 uppercase">Luar Biasa! Tidak ada warga yang menunggak.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sidebar-layout>
