# Smart RW (SaaS)

Smart RW adalah platform SaaS terintegrasi untuk pengelolaan Rukun Warga (RW) yang mencakup manajemen kependudukan, iuran, kas keuangan, keamanan, administrasi surat menyurat, hingga pemberdayaan ekonomi warga (Koperasi dan UMKM).

## Struktur Arsitektur Baru (Tahap Transisi)
Sistem ini sedang bertransisi menggunakan Opsi A (Headless Backend Laravel API + Frontend Terpisah). Saat ini sistem terbagi menjadi:
- **/backend**: (Dalam proses pemisahan) Merupakan *core* API yang menangani autentikasi, database, dan logika bisnis menggunakan Laravel Sanctum.
- **/frontend**: (Dalam proses pengembangan) Antarmuka pengguna berbasis React/Next.js.

## Panduan Setup & Instalasi Lokal

1. **Clone Repository**
   ```bash
   git clone <repo_url>
   cd smart_rw
   ```

2. **Setup Backend**
   ```bash
   cp .env.example .env
   # Sesuaikan DB_DATABASE=smart_rw pada file .env
   composer install
   php artisan key:generate
   ```

3. **Inisialisasi Database (Create & Seed)**
   Buat database `smart_rw` di MySQL, lalu jalankan perintah berikut untuk migrasi dan melakukan seeding data master (100 keluarga warga beserta modul lainnya):
   ```bash
   php artisan migrate:fresh --seed
   ```
   
4. **Jalankan Server Backend**
   ```bash
   php artisan serve
   ```

## Detail Seeder Master Data
Saat Anda menjalankan `php artisan migrate:fresh --seed`, sistem secara otomatis membuat:
- 1 akun Superadmin (`superadmin@kasrt.com`)
- 1 akun Admin (`admin@rt005.com`)
- 1 akun Bendahara (`bendahara@rt005.com`)
- 1 Client (RW 05 Taman Elok)
- **100 Keluarga Warga** dengan masing-masing 2-3 anggota (kepala keluarga, istri, dan anak).
- Master Data lainnya seperti: Jenis Iuran (5), Aset Inventaris (10), dan Daftar UMKM (15).

Semua password akun *dummy* secara default adalah `password` (untuk superadmin, admin, bendahara) dan `password123` (untuk akun warga *dummy*).

## Struktur Kategori Sidebar
Navigasi pada aplikasi dikelompokkan ke dalam empat bagian utama:
1. **📁 MASTER:** Data dasar seperti Data Warga, Inventaris & Aset, Direktori UMKM, Jenis Iuran, Manajemen Pengurus.
2. **🔄 TRANSACTIONAL:** Aktivitas interaktif seperti Tagihan & Bayar, Verifikasi, Koperasi, Bank Sampah, KMS Posyandu, Surat Pengantar, Aspirasi Warga, Peminjaman Aset, dan Buku Tamu.
3. **📊 REPORT:** Rekapitulasi seperti Laporan Kas dan Rekap Tunggakan.
4. **⚙️ SETTING:** Profil pengguna dan Manajemen Klien (Khusus Superadmin).
