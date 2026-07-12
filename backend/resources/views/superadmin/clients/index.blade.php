<x-sidebar-layout>
    <x-slot name="header">
        Manajemen Klien (SaaS)
    </x-slot>

    <div x-data="{ 
        createModal: false, 
        editModal: false, 
        deleteModal: false, 
        selectedClient: null 
    }">
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h3 class="text-2xl font-black text-gray-800 tracking-tight">Daftar Klien / RW</h3>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">Kelola akses organisasi klien yang menggunakan aplikasi ini.</p>
            </div>
            <button @click="createModal = true" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-teal-200 transition flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Klien Baru
            </button>
        </div>

        <!-- Tabel Daftar Klien -->
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200 overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Klien / RW</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kode Tenant</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status Akses</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Auto Billing</th>
                            <th class="p-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($clients as $client)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-5">
                                    <div class="font-bold text-gray-800">{{ $client->name }}</div>
                                    <div class="text-xs font-medium text-gray-400 mt-0.5">Dibuat: {{ $client->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="p-5 font-mono text-sm font-bold text-teal-600 bg-teal-50/50 rounded-lg inline-block mt-3 ml-2 px-3 py-1">{{ $client->code }}</td>
                                <td class="p-5 text-sm text-gray-600 font-medium">{{ $client->address }}</td>
                                <td class="p-5 text-center">
                                    @if($client->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-100 text-red-700">
                                            Ditangguhkan
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if($client->is_auto_billing_enabled)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-100 text-blue-700 mb-1">
                                            Auto Bill: ON
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 mb-1">
                                            Auto Bill: OFF
                                        </span>
                                    @endif
                                    <br>
                                    @if($client->is_email_notification_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-purple-100 text-purple-700">
                                            Email Notif: ON
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500">
                                            Email Notif: OFF
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button @click="selectedClient = {{ $client->toJson() }}; editModal = true" class="p-2 text-teal-600 hover:bg-teal-50 rounded-xl transition tooltip" title="Edit Klien">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button @click="selectedClient = {{ $client->toJson() }}; deleteModal = true" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition tooltip" title="Hapus Klien">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <h4 class="text-gray-900 font-bold mb-1">Belum Ada Klien</h4>
                                    <p class="text-sm text-gray-500 font-medium">Tambahkan Klien/RW pertama Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div x-show="createModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="createModal" @click="createModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm"></div>
                <div x-show="createModal" class="relative inline-block w-full max-w-lg p-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-black text-gray-800 tracking-tight">Pendaftaran Klien Baru</h3>
                        <button @click="createModal = false" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form action="{{ route('superadmin.clients.store') }}" method="POST">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Nama Organisasi / RW</label>
                                <input type="text" name="name" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow" placeholder="Contoh: RW 05 Taman Elok" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Kode Unik Tenant</label>
                                <input type="text" name="code" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold font-mono transition-shadow" placeholder="Contoh: RW05TE" required>
                                <p class="text-[10px] font-medium text-gray-400 mt-1.5 px-1">Kode ini digunakan sistem untuk identifikasi data. Tanpa spasi.</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Alamat Lengkap</label>
                                <textarea name="address" rows="2" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-medium transition-shadow resize-none" required></textarea>
                            </div>
                            
                            <hr class="border-gray-100 my-4">
                            <p class="text-xs font-bold text-teal-600 uppercase tracking-widest mb-2">Akun Admin Pertama</p>

                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Nama Admin</label>
                                <input type="text" name="admin_name" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Email Login Admin</label>
                                <input type="email" name="admin_email" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Password</label>
                                <input type="password" name="admin_password" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow" required minlength="8">
                            </div>

                            <div class="pt-4 flex gap-3">
                                <button type="button" @click="createModal = false" class="flex-1 py-3.5 text-[10px] font-black text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-2xl uppercase tracking-widest transition">Batal</button>
                                <button type="submit" class="flex-[2] py-3.5 text-[10px] font-black text-white bg-teal-600 hover:bg-teal-700 rounded-2xl shadow-lg shadow-teal-200 uppercase tracking-widest transition">Simpan Klien Baru</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="editModal" @click="editModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm"></div>
                <div x-show="editModal" class="relative inline-block w-full max-w-lg p-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-black text-gray-800 tracking-tight">Edit Data Klien</h3>
                        <button @click="editModal = false" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form :action="`/superadmin/clients/${selectedClient?.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Nama Organisasi / RW</label>
                                <input type="text" name="name" :value="selectedClient?.name" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Kode Unik Tenant</label>
                                <input type="text" name="code" :value="selectedClient?.code" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold font-mono transition-shadow" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Alamat Lengkap</label>
                                <textarea name="address" x-model="selectedClient.address" rows="2" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-medium transition-shadow resize-none" required></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Status Akses Aplikasi</label>
                                <select name="is_active" :value="selectedClient?.is_active ? '1' : '0'" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow">
                                    <option value="1">Aktif (Klien bisa login & pakai sistem)</option>
                                    <option value="0">Ditangguhkan (Blokir Akses Klien)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Auto Billing (Fase 3)</label>
                                <select name="is_auto_billing_enabled" :value="selectedClient?.is_auto_billing_enabled ? '1' : '0'" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-teal-500 text-sm font-bold transition-shadow">
                                    <option value="1">ON - Tagihan otomatis awal bulan</option>
                                    <option value="0">OFF - Jangan buat tagihan otomatis</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 px-1">Gateway Notifikasi Email (Fase 8)</label>
                                <select name="is_email_notification_active" :value="selectedClient?.is_email_notification_active ? '1' : '0'" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-purple-500 text-sm font-bold transition-shadow text-purple-700">
                                    <option value="1">ON - Izinkan kirim Email Otomatis</option>
                                    <option value="0">OFF - Matikan Gateway Email</option>
                                </select>
                            </div>

                            <div class="pt-4 flex gap-3">
                                <button type="button" @click="editModal = false" class="flex-1 py-3.5 text-[10px] font-black text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-2xl uppercase tracking-widest transition">Batal</button>
                                <button type="submit" class="flex-[2] py-3.5 text-[10px] font-black text-white bg-teal-600 hover:bg-teal-700 rounded-2xl shadow-lg shadow-teal-200 uppercase tracking-widest transition">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="deleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="deleteModal" @click="deleteModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm"></div>
                <div x-show="deleteModal" class="relative inline-block w-full max-w-md p-8 text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-tight mb-2">Hapus Klien Ini?</h3>
                        <p class="text-sm text-gray-500 font-medium mb-8">Peringatan: Menghapus klien akan <span class="text-red-500 font-bold">menghapus SEMUA data</span> terkait Klien tersebut (Data Warga, Keuangan, Kas, dll). Tindakan ini tidak dapat dibatalkan!</p>
                        
                        <form :action="`/superadmin/clients/${selectedClient?.id}`" method="POST" class="w-full flex gap-3">
                            @csrf
                            @method('DELETE')
                            <button type="button" @click="deleteModal = false" class="flex-1 py-3.5 text-[10px] font-black text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-2xl uppercase tracking-widest transition">Batal</button>
                            <button type="submit" class="flex-1 py-3.5 text-[10px] font-black text-white bg-red-600 hover:bg-red-700 rounded-2xl shadow-lg shadow-red-200 uppercase tracking-widest transition">Hapus Permanen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-sidebar-layout>
