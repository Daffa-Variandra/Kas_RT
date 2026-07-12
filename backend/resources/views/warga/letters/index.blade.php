<x-sidebar-layout>
    <x-slot name="header">Pelayanan Surat Pengantar</x-slot>

    <div class="py-6 lg:py-8" x-data="{ openModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-4 bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 rounded shadow-sm">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <!-- Request Letter Button & Info -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 mb-8 flex justify-between items-center border border-gray-100">
                <div>
                    <h3 class="text-lg font-black text-gray-800 mb-1">Butuh Surat Pengantar?</h3>
                    <p class="text-sm text-gray-500">Ajukan permohonan surat secara online, pantau statusnya, dan unduh PDF setelah di-ACC oleh Pengurus.</p>
                </div>
                <button @click="openModal = true" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-teal-200 transition transform hover:-translate-y-0.5">
                    + Buat Permohonan Baru
                </button>
            </div>

            <!-- Letters History Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-800">Riwayat Permohonan Surat</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Keperluan</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($letters as $letter)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-5 text-sm font-medium text-gray-900">{{ $letter->created_at->format('d M Y') }}</td>
                                <td class="p-5 text-sm font-bold text-gray-800">{{ $letter->letter_type }}</td>
                                <td class="p-5 text-sm text-gray-500 max-w-xs truncate">{{ $letter->purpose }}</td>
                                <td class="p-5 text-center">
                                    @if($letter->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700">Disetujui</span>
                                    @elseif($letter->status === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-100 text-red-700">Ditolak</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-yellow-100 text-yellow-700">Menunggu</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if($letter->status === 'approved')
                                        <a href="#" target="_blank" class="inline-flex items-center px-4 py-2 bg-teal-50 text-teal-600 hover:bg-teal-100 rounded-lg text-xs font-bold transition">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh PDF
                                        </a>
                                    @elseif($letter->status === 'rejected')
                                        <span class="text-xs text-red-500" title="{{ $letter->admin_notes }}">Lihat Alasan</span>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    Belum ada riwayat permohonan surat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Letter Modal -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>

                <div x-show="openModal" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-gray-800">Permohonan Surat Baru</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('warga.letters.store') }}" method="POST">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Jenis Surat</label>
                                <select name="letter_type" required class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow">
                                    <option value="">Pilih jenis surat...</option>
                                    <option value="Surat Pengantar Domisili">Surat Pengantar Domisili</option>
                                    <option value="Surat Pengantar Pembuatan KTP">Surat Pengantar Pembuatan KTP / KK</option>
                                    <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                                    <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                                    <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                                    <option value="Lainnya">Lainnya...</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Keperluan Lengkap</label>
                                <textarea name="purpose" rows="3" required placeholder="Jelaskan secara singkat keperluan Anda..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm transition-shadow resize-none"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openModal = false" class="flex-1 py-3.5 text-[10px] font-black text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-2xl uppercase tracking-widest transition">Batal</button>
                            <button type="submit" class="flex-[2] py-3.5 text-[10px] font-black text-white bg-teal-600 hover:bg-teal-700 rounded-2xl shadow-lg shadow-teal-200 uppercase tracking-widest transition">Kirim Permohonan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-sidebar-layout>
