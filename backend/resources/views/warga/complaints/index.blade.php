<x-sidebar-layout>
    <x-slot name="header">Aspirasi & Pengaduan Warga</x-slot>

    <div class="py-6 lg:py-8" x-data="{ openModal: false, selectedPhoto: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-4 bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 rounded shadow-sm">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <!-- Request Complaint Button & Info -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 mb-8 flex justify-between items-center border border-gray-100">
                <div>
                    <h3 class="text-lg font-black text-gray-800 mb-1">Punya Masukan atau Keluhan?</h3>
                    <p class="text-sm text-gray-500">Laporkan fasilitas rusak, sampaikan aspirasi, atau berikan usulan untuk lingkungan kita tercinta.</p>
                </div>
                <button @click="openModal = true" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-teal-200 transition transform hover:-translate-y-0.5">
                    + Buat Laporan Baru
                </button>
            </div>

            <!-- Complaints History Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-800">Riwayat Aspirasi Anda</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Topik Laporan</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Bukti Foto</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tanggapan Pengurus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($complaints as $complaint)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-5 text-sm font-medium text-gray-900">{{ $complaint->created_at->format('d M Y') }}</td>
                                <td class="p-5">
                                    <div class="text-sm font-bold text-gray-800">{{ $complaint->title }}</div>
                                    <div class="text-xs text-gray-500 max-w-xs truncate" title="{{ $complaint->description }}">{{ $complaint->description }}</div>
                                </td>
                                <td class="p-5 text-center">
                                    @if($complaint->photo_path)
                                        <button @click="selectedPhoto = '{{ asset('storage/' . $complaint->photo_path) }}'" class="text-teal-600 hover:text-teal-800 underline text-xs font-bold">Lihat Foto</button>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if($complaint->status === 'menunggu')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-yellow-100 text-yellow-700">Menunggu</span>
                                    @elseif($complaint->status === 'diproses')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-100 text-blue-700">Diproses</span>
                                    @elseif($complaint->status === 'selesai')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700">Selesai</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-100 text-red-700">Ditolak</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if($complaint->admin_response)
                                        <span class="text-xs text-gray-600" title="{{ $complaint->admin_response }}">Lihat Tanggapan</span>
                                    @else
                                        <span class="text-xs text-gray-400">Belum ada tanggapan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    Belum ada riwayat laporan atau aspirasi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Complaint Modal -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>

                <div x-show="openModal" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-gray-800">Buat Laporan Baru</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('warga.complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Judul / Topik Laporan</label>
                                <input type="text" name="title" required placeholder="Contoh: Lampu Jalan Mati di Blok A" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Deskripsi Lengkap</label>
                                <textarea name="description" rows="4" required placeholder="Ceritakan sedetail mungkin..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm transition-shadow resize-none"></textarea>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Foto Bukti (Opsional)</label>
                                <input type="file" name="photo" accept="image/*" class="w-full px-5 py-3 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm transition-shadow file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                <p class="text-xs text-gray-400 px-1 mt-2">Format: JPG, PNG. Maks: 5MB.</p>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openModal = false" class="flex-1 py-3.5 text-[10px] font-black text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-2xl uppercase tracking-widest transition">Batal</button>
                            <button type="submit" class="flex-[2] py-3.5 text-[10px] font-black text-white bg-teal-600 hover:bg-teal-700 rounded-2xl shadow-lg shadow-teal-200 uppercase tracking-widest transition">Kirim Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Photo Preview Modal -->
        <div x-show="selectedPhoto" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75" style="display: none;">
            <div class="relative w-full max-w-2xl">
                <button @click="selectedPhoto = null" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img :src="selectedPhoto" class="w-full rounded-lg shadow-2xl">
            </div>
        </div>

    </div>
</x-sidebar-layout>
