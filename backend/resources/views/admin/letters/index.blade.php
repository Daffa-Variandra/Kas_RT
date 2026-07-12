<x-sidebar-layout>
    <x-slot name="header">Verifikasi Surat Pengantar</x-slot>

    <div class="py-6 lg:py-8" x-data="{ openModal: false, selectedLetter: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-4 bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 rounded shadow-sm">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-800">Daftar Permohonan Surat Warga</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Warga</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Keperluan</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($letters as $letter)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-5">
                                    <div class="text-sm font-bold text-gray-900">{{ $letter->user->name }}</div>
                                    <div class="text-xs text-gray-500">No. KK: {{ $letter->user->family->family_card_number ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $letter->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td class="p-5 text-sm font-bold text-gray-800">{{ $letter->letter_type }}</td>
                                <td class="p-5 text-sm text-gray-500 max-w-xs truncate" title="{{ $letter->purpose }}">{{ $letter->purpose }}</td>
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
                                    @if($letter->status === 'pending')
                                        <button @click="selectedLetter = {{ $letter->toJson() }}; openModal = true" class="px-4 py-2 bg-teal-50 text-teal-600 hover:bg-teal-100 rounded-lg text-xs font-bold transition">
                                            Proses
                                        </button>
                                    @elseif($letter->status === 'approved')
                                        <a href="{{ route('admin.letters.print', $letter->id) }}" target="_blank" class="px-4 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg text-xs font-bold transition">
                                            Print PDF
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    Belum ada permohonan surat masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Verification Modal -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>

                <div x-show="openModal" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-gray-800">Proses Surat Pengantar</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl hover:bg-gray-50 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl mb-6">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Jenis Surat</p>
                        <p class="text-sm font-bold text-gray-800 mb-3" x-text="selectedLetter?.letter_type"></p>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Keperluan</p>
                        <p class="text-sm text-gray-800" x-text="selectedLetter?.purpose"></p>
                    </div>

                    <form :action="`/admin/letters/${selectedLetter?.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Keputusan</label>
                                <select name="status" required class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow">
                                    <option value="approved">Setujui & Buatkan PDF</option>
                                    <option value="rejected">Tolak Permohonan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Catatan Tambahan (Opsional / Alasan Tolak)</label>
                                <textarea name="admin_notes" rows="2" placeholder="Catatan untuk warga..." class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm transition-shadow resize-none"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openModal = false" class="flex-1 py-3.5 text-[10px] font-black text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-2xl uppercase tracking-widest transition">Batal</button>
                            <button type="submit" class="flex-[2] py-3.5 text-[10px] font-black text-white bg-teal-600 hover:bg-teal-700 rounded-2xl shadow-lg shadow-teal-200 uppercase tracking-widest transition">Simpan Keputusan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-sidebar-layout>
