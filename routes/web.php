<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ContributionController;
use App\Http\Controllers\Warga\PaymentController as WargaPaymentController;
use App\Http\Controllers\Bendahara\PaymentVerificationController;
use App\Http\Controllers\Bendahara\ReportController;

Route::get('/', function () { 
    if (!Auth::check()) {
        return redirect('/login');
    }
    return redirect('/dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD ROUTE (Semua role panggil controller yang sama) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- ROLE: ADMIN ---
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/admin/residents', [ResidentController::class, 'residentindex'])->name('admin.residents.index');
        Route::post('/admin/residents', [ResidentController::class, 'residentstore'])->name('admin.residents.store');
        Route::put('/admin/residents/{id}', [ResidentController::class, 'residentupdate'])->name('admin.residents.update');
        Route::delete('/admin/residents/{id}', [ResidentController::class, 'residentdestroy'])->name('admin.residents.destroy');
        
        Route::resource('/admin/contributions', ContributionController::class)->names('admin.contributions');
    });

    // --- ROLE: BENDAHARA ---
    Route::middleware(['role:bendahara'])->group(function () {
        Route::get('/bendahara/dashboard', [DashboardController::class, 'index'])->name('bendahara.dashboard');
        Route::get('/bendahara/verifikasi', [PaymentVerificationController::class, 'index'])->name('bendahara.verification.index');
        Route::patch('/bendahara/verifikasi/{id}', [PaymentVerificationController::class, 'updateStatus'])->name('bendahara.verification.update');
        Route::get('/bendahara/laporan', [ReportController::class, 'index'])->name('bendahara.reports.index');
    });

    // --- ROLE: WARGA ---
    Route::middleware(['role:warga'])->group(function () {
        Route::get('/warga/pembayaran', [WargaPaymentController::class, 'index'])->name('warga.payments.index');
        Route::post('/warga/pembayaran', [WargaPaymentController::class, 'store'])->name('warga.payments.store');
    });

    // --- GLOBAL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/warga/profil', [ProfileController::class, 'wargaEdit'])->name('warga.profile.edit');
    Route::put('/warga/profil', [ProfileController::class, 'wargaUpdate'])->name('warga.profile.update');
    Route::get('/complete-profile', [ProfileController::class, 'complete'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileController::class, 'storeProfile'])->name('profile.store');
});

// 3. LOGOUT & AUTH
Route::get('/logged-out', function () {
    return view('auth.logged-out');
})->name('logged-out');

require __DIR__.'/auth.php';