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

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/register-rw', [LandingController::class, 'registerRw'])->name('register-rw');
Route::post('/register-rw', [LandingController::class, 'storeRw'])->name('register-rw.store');

Route::get('/test-403', function () {
    abort(403, 'Waduh! Anda tidak punya akses ke halaman ini.');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD ROUTE (Semua role panggil controller yang sama) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- ROLE: ADMIN & SUPERADMIN ---
    Route::middleware(['role:admin,superadmin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/admin/families/template', [App\Http\Controllers\Admin\FamilyController::class, 'template'])->name('admin.families.template');
        Route::get('/admin/families/export', [App\Http\Controllers\Admin\FamilyController::class, 'export'])->name('admin.families.export');
        Route::post('/admin/families/import', [App\Http\Controllers\Admin\FamilyController::class, 'import'])->name('admin.families.import');
        Route::resource('/admin/families', App\Http\Controllers\Admin\FamilyController::class)->names('admin.families');
        
        Route::resource('/admin/staff', App\Http\Controllers\Admin\StaffController::class)->names('admin.staff')->except(['create', 'show', 'edit']);

        Route::resource('/admin/payments', App\Http\Controllers\Admin\PaymentController::class)->names('admin.payments')->only(['index', 'update', 'destroy']);
        Route::resource('/admin/residents', App\Http\Controllers\Admin\ResidentController::class)->names('admin.residents')->only(['store', 'update', 'destroy']);
    });

    // --- ROLE: ADMIN, SUPERADMIN, BENDAHARA ---
    Route::middleware(['role:admin,superadmin,bendahara'])->group(function () {
        Route::resource('/admin/contributions', App\Http\Controllers\Admin\ContributionController::class)->names('admin.contributions');
        Route::get('/bendahara/dashboard', [DashboardController::class, 'index'])->name('bendahara.dashboard');
    });

    // --- ROLE: SUPERADMIN ---
    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/clients', App\Http\Controllers\SuperAdmin\ClientController::class);
    });

    // --- ROLE: BENDAHARA ---
    Route::middleware(['role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
        Route::get('/verification', [App\Http\Controllers\Bendahara\PaymentVerificationController::class, 'index'])->name('verification.index');
        Route::patch('/verification/{id}', [App\Http\Controllers\Bendahara\PaymentVerificationController::class, 'updateStatus'])->name('verification.update');

        Route::get('/reports', [App\Http\Controllers\Bendahara\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [App\Http\Controllers\Bendahara\ReportController::class, 'exportPdf'])->name('reports.pdf');

        Route::get('/arrears', [App\Http\Controllers\Bendahara\ArrearsController::class, 'index'])->name('arrears.index');
        Route::post('/arrears/{id}/remind', [App\Http\Controllers\Bendahara\ArrearsController::class, 'sendReminder'])->name('arrears.remind');

        Route::resource('/expenses', App\Http\Controllers\Bendahara\ExpenseController::class)->only(['index', 'store', 'destroy']);
    });

    // --- ROLE: WARGA ---
    Route::middleware('role:warga')->prefix('warga')->name('warga.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Warga\DashboardController::class, 'index'])->name('dashboard');
        
        // Iuran & Pembayaran
        Route::get('/payments', [App\Http\Controllers\Warga\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/{payment}/upload', [App\Http\Controllers\Warga\PaymentController::class, 'upload'])->name('payments.upload');

        // Surat Pengantar
        Route::get('/letters', [App\Http\Controllers\Warga\LetterController::class, 'index'])->name('letters.index');
        Route::post('/letters', [App\Http\Controllers\Warga\LetterController::class, 'store'])->name('letters.store');

        // Pengaduan / Aspirasi
        Route::get('/complaints', [App\Http\Controllers\Warga\ComplaintController::class, 'index'])->name('complaints.index');
        Route::post('/complaints', [App\Http\Controllers\Warga\ComplaintController::class, 'store'])->name('complaints.store');

        // Aset & Keamanan
        Route::get('/assets', [App\Http\Controllers\Warga\AssetController::class, 'index'])->name('assets.index');
        Route::post('/assets/borrow', [App\Http\Controllers\Warga\AssetController::class, 'store'])->name('assets.store');
        
        Route::get('/security', [App\Http\Controllers\Warga\SecurityController::class, 'index'])->name('security.index');

        // UMKM & Koperasi
        Route::get('/umkms', [App\Http\Controllers\Warga\UmkmController::class, 'index'])->name('umkms.index');
        Route::post('/umkms', [App\Http\Controllers\Warga\UmkmController::class, 'store'])->name('umkms.store');

        Route::get('/cooperative', [App\Http\Controllers\Warga\CooperativeController::class, 'index'])->name('cooperative.index');
        Route::post('/cooperative/loan', [App\Http\Controllers\Warga\CooperativeController::class, 'storeLoan'])->name('cooperative.loan.store');
        Route::post('/cooperative/transaction', [App\Http\Controllers\Warga\CooperativeController::class, 'storeTransaction'])->name('cooperative.transaction.store');

        // Posyandu & Bank Sampah
        Route::get('/posyandu', [App\Http\Controllers\Warga\PosyanduController::class, 'index'])->name('posyandu.index');
        
        Route::get('/trashbank', [App\Http\Controllers\Warga\TrashBankController::class, 'index'])->name('trashbank.index');
        Route::post('/trashbank', [App\Http\Controllers\Warga\TrashBankController::class, 'store'])->name('trashbank.store');
    });

    // Rute untuk Admin RT / Sekretaris
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('families', App\Http\Controllers\Admin\FamilyController::class);
        Route::resource('residents', App\Http\Controllers\Admin\ResidentController::class);
        
        // Verifikasi Surat
        Route::get('/letters', [App\Http\Controllers\Admin\LetterController::class, 'index'])->name('letters.index');
        Route::put('/letters/{letter}', [App\Http\Controllers\Admin\LetterController::class, 'update'])->name('letters.update');
        Route::get('/letters/{letter}/print', [App\Http\Controllers\Admin\LetterController::class, 'print'])->name('letters.print');

        // Pengaduan / Aspirasi
        Route::get('/complaints', [App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('complaints.index');
        Route::put('/complaints/{complaint}', [App\Http\Controllers\Admin\ComplaintController::class, 'update'])->name('complaints.update');

        // Aset & Keamanan
        Route::resource('assets', App\Http\Controllers\Admin\AssetController::class)->except(['create', 'show', 'edit']);
        Route::get('/asset-loans', [App\Http\Controllers\Admin\AssetLoanController::class, 'index'])->name('asset_loans.index');
        Route::put('/asset-loans/{loan}', [App\Http\Controllers\Admin\AssetLoanController::class, 'update'])->name('asset_loans.update');

        Route::get('/security', [App\Http\Controllers\Admin\SecurityController::class, 'index'])->name('security.index');
        Route::post('/security/schedule', [App\Http\Controllers\Admin\SecurityController::class, 'storeSchedule'])->name('security.schedule.store');
        Route::delete('/security/schedule/{schedule}', [App\Http\Controllers\Admin\SecurityController::class, 'destroySchedule'])->name('security.schedule.destroy');
        Route::post('/security/guest', [App\Http\Controllers\Admin\SecurityController::class, 'storeGuest'])->name('security.guest.store');
        Route::put('/security/guest/{guest}/out', [App\Http\Controllers\Admin\SecurityController::class, 'updateGuestOut'])->name('security.guest.updateOut');

        // UMKM & Koperasi
        Route::delete('/umkms/{umkm}', [App\Http\Controllers\Admin\UmkmController::class, 'destroy'])->name('umkms.destroy');
        Route::get('/umkms', [App\Http\Controllers\Admin\UmkmController::class, 'index'])->name('umkms.index');

        Route::get('/cooperative', [App\Http\Controllers\Admin\CooperativeController::class, 'index'])->name('cooperative.index');
        Route::put('/cooperative/loan/{loan}', [App\Http\Controllers\Admin\CooperativeController::class, 'updateLoanStatus'])->name('cooperative.loan.update');
        Route::put('/cooperative/transaction/{transaction}', [App\Http\Controllers\Admin\CooperativeController::class, 'updateTransactionStatus'])->name('cooperative.transaction.update');
        
        Route::post('/cooperative/settings', [App\Http\Controllers\Admin\CooperativeSettingsController::class, 'update'])->name('cooperative.settings.update');

        // Posyandu & Bank Sampah
        Route::resource('posyandu', App\Http\Controllers\Admin\PosyanduController::class)->except(['create', 'show', 'edit']);
        
        Route::get('/trashbank', [App\Http\Controllers\Admin\TrashBankController::class, 'index'])->name('trashbank.index');
        Route::put('/trashbank/{deposit}/process', [App\Http\Controllers\Admin\TrashBankController::class, 'process'])->name('trashbank.process');
    });

    // Global Auth routes
    Route::post('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markRead');

    // --- ROLE: WARGA ---
    Route::middleware(['role:warga'])->group(function () {
        Route::get('/warga/pembayaran', [WargaPaymentController::class, 'index'])->name('warga.payments.index');
        Route::post('/warga/pembayaran', [WargaPaymentController::class, 'store'])->name('warga.payments.store');
    });

    // --- GLOBAL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.markRead');

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