<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DevCommand extends Command
{
    /**
     * Perintah yang akan dipanggil di terminal: php artisan dev
     */
    protected $signature = 'dev';

    /**
     * Deskripsi perintah
     */
    protected $description = 'Jalankan server Laravel dan buka halaman login otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $port = 8000;
        $url = "http://127.0.0.1:{$port}/login";

        $this->info("Sedang menyiapkan server...");
        $this->warn("Membuka browser ke: {$url}");

        // Logika deteksi OS untuk membuka browser
        if (PHP_OS_FAMILY === 'Windows') {
            exec("start {$url}");
        } elseif (PHP_OS_FAMILY === 'Linux') {
            exec("xdg-open {$url}");
        } elseif (PHP_OS_FAMILY === 'Darwin') { // macOS
            exec("open {$url}");
        }

        // Menjalankan artisan serve
        $this->call('serve', ['--port' => $port]);
    }
}