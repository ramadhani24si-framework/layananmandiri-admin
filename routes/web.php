<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasPersyaratanController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\RiwayatStatusSuratController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ProfileController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ GANTI 'auth' MENJADI 'check.login'
// Protected Routes (Harus Login)
Route::middleware('check.login')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // ✅ PENGAJUAN ROUTES
    Route::resource('pengajuan', PengajuanController::class);

    // Tambahkan route ini di dalam group auth (setelah resource)
    Route::delete('/jenis_surat/{jenis_id}/media/{media_id}', [JenisSuratController::class, 'destroyMedia'])
        ->name('jenis_surat.destroyMedia');

    // routes/web.php - Tambahkan di dalam group auth
    Route::delete('/pengajuan/{pengajuan_id}/lampiran/{media_id}', [PengajuanController::class, 'destroyLampiran'])
        ->name('pengajuan.destroyLampiran');

    // ✅ TAMBAHKAN INI: Route untuk update status
    Route::post('/pengajuan/{id}/update-status', [PengajuanController::class, 'updateStatus'])
        ->name('pengajuan.update-status');
    Route::get('/download/file/{id}', [PengajuanController::class, 'downloadFile'])->name('download.file');


    // ==================== ROUTES UNTUK ADMIN & SUPER ADMIN ====================
    Route::middleware(['check.role:warga,super_admin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('warga', WargaController::class);
        Route::resource('jenis_surat', JenisSuratController::class);

        // BERKAS PERSYARATAN CREATE/EDIT/DELETE hanya untuk admin
        Route::get('/berkas_persyaratan/create', [BerkasPersyaratanController::class, 'create'])->name('berkas_persyaratan.create');
        Route::post('/berkas_persyaratan', [BerkasPersyaratanController::class, 'store'])->name('berkas_persyaratan.store');
        Route::get('/berkas_persyaratan/{id}/edit', [BerkasPersyaratanController::class, 'edit'])->name('berkas_persyaratan.edit');
        Route::put('/berkas_persyaratan/{id}', [BerkasPersyaratanController::class, 'update'])->name('berkas_persyaratan.update');
        Route::delete('/berkas_persyaratan/{id}', [BerkasPersyaratanController::class, 'destroy'])->name('berkas_persyaratan.destroy');
        Route::delete('/berkas_persyaratan/{berkas_id}/media/{media_id}', [BerkasPersyaratanController::class, 'destroyMedia'])
            ->name('berkas_persyaratan.destroyMedia');
        Route::get('/berkas_persyaratan/{berkas_id}/media/{media_id}/download', [BerkasPersyaratanController::class, 'downloadMedia'])
            ->name('berkas_persyaratan.downloadMedia');

        // RIWAYAT STATUS CREATE/EDIT/DELETE hanya untuk admin
        Route::get('/riwayat-status-surat/create', [RiwayatStatusSuratController::class, 'create'])
            ->name('riwayat_status_surat.create');
        Route::get('/riwayat-status-surat/{id}', [RiwayatStatusSuratController::class, 'show'])
            ->name('riwayat_status_surat.show');
        Route::post('/riwayat-status-surat', [RiwayatStatusSuratController::class, 'store'])
            ->name('riwayat_status_surat.store');
        Route::get('/riwayat-status-surat/{id}/edit', [RiwayatStatusSuratController::class, 'edit'])
            ->name('riwayat_status_surat.edit');
        Route::put('/riwayat-status-surat/{id}', [RiwayatStatusSuratController::class, 'update'])
            ->name('riwayat_status_surat.update');
        Route::delete('/riwayat-status-surat/{id}', [RiwayatStatusSuratController::class, 'destroy'])
            ->name('riwayat_status_surat.destroy');
        Route::post('/riwayat-status-surat/create-from-pengajuan/{pengajuan_id}', [RiwayatStatusSuratController::class, 'createFromPengajuan'])
            ->name('riwayat_status_surat.create-from-pengajuan');
    });

    // ==================== ROUTES UNTUK SUPER ADMIN SAJA ====================
    Route::middleware(['check.role:super_admin'])->group(function () {
        // Pengaturan sistem (hanya super admin)
        Route::get('/admin/settings', function () {
            return view('admin.settings');
        })->name('admin.settings');
    });

    // ==================== ROUTES UNTUK SEMUA USER ====================
    // BERKAS PERSYARATAN (lihat saja untuk semua user)
    Route::get('/berkas_persyaratan', [BerkasPersyaratanController::class, 'index'])->name('berkas_persyaratan.index');
    Route::get('/berkas_persyaratan/{id}', [BerkasPersyaratanController::class, 'show'])->name('berkas_persyaratan.show');

    // RIWAYAT STATUS (lihat saja untuk semua user)
    Route::get('/riwayat-status-surat', [RiwayatStatusSuratController::class, 'index'])
        ->name('riwayat_status_surat.index');
    Route::get('/riwayat-status-surat/{id}', [RiwayatStatusSuratController::class, 'show'])
        ->name('riwayat_status_surat.show');

    // AJAX Routes untuk semua user
    Route::get('/riwayat-status-surat/by-pengajuan/{pengajuan_id}', [RiwayatStatusSuratController::class, 'getByPengajuan'])
        ->name('riwayat_status_surat.by-pengajuan');
});

// Route untuk development (local storage access)
if (app()->environment('local')) {
    Route::get('/storage/app/public/media/jenis_surat/{filename}', function ($filename) {
        $path = storage_path('app/public/media/jenis_surat/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    });
}

// JENIS SURAT INDEX (bisa diakses tanpa login atau dengan login)
Route::get('/jenis_surat', [JenisSuratController::class, 'index'])->name('jenis_surat.index');


// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/picture', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Di routes/web.php
Route::get('/download/template/{id}', [JenisSuratController::class, 'downloadTemplate'])->name('download.template');
