<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\JenisSuratController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✏️ UBAH INI: Route "/" langsung ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Protected Routes (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('pengajuan', PengajuanController::class);
    Route::resource('user', UserController::class);
    Route::resource('warga', WargaController::class);
    Route::resource('jenis_surat', JenisSuratController::class);
});

// ==================== BERKAS PERSYARATAN ROUTES ====================
Route::get('/berkas-persyaratan', [BerkasPersyaratanController::class, 'index'])->name('berkas-persyaratan.index');
Route::get('/berkas-persyaratan/create', [BerkasPersyaratanController::class, 'create'])->name('berkas-persyaratan.create');
Route::post('/berkas-persyaratan', [BerkasPersyaratanController::class, 'store'])->name('berkas-persyaratan.store');
Route::get('/berkas-persyaratan/{berkas_persyaratan}', [BerkasPersyaratanController::class, 'show'])->name('berkas-persyaratan.show');
Route::get('/berkas-persyaratan/{berkas_persyaratan}/edit', [BerkasPersyaratanController::class, 'edit'])->name('berkas-persyaratan.edit');
Route::put('/berkas-persyaratan/{berkas_persyaratan}', [BerkasPersyaratanController::class, 'update'])->name('berkas-persyaratan.update');
Route::delete('/berkas-persyaratan/{berkas_persyaratan}', [BerkasPersyaratanController::class, 'destroy'])->name('berkas-persyaratan.destroy');

// ✅ ROUTE UNTUK HAPUS FILE MEDIA
Route::delete('/berkas-persyaratan/{berkas_id}/media/{media_id}',
    [BerkasPersyaratanController::class, 'destroyMedia'])->name('berkas-persyaratan.media.destroy');

// ✅ ROUTE UNTUK UPDATE STATUS
Route::post('/berkas-persyaratan/{berkas_persyaratan}/status',
    [BerkasPersyaratanController::class, 'updateStatus'])->name('berkas-persyaratan.status.update');

// ✅ ROUTE GET BERKAS BY PENGAJUAN (AJAX)
Route::get('/pengajuan/{pengajuan_id}/berkas',
    [BerkasPersyaratanController::class, 'getByPengajuan'])->name('pengajuan.berkas.get');

    // ==================== RIWAYAT STATUS SURAT ROUTES ====================
Route::get('/riwayat-status-surat', [RiwayatStatusSuratController::class, 'index'])->name('riwayat-status-surat.index');
Route::get('/riwayat-status-surat/create', [RiwayatStatusSuratController::class, 'create'])->name('riwayat-status-surat.create');
Route::post('/riwayat-status-surat', [RiwayatStatusSuratController::class, 'store'])->name('riwayat-status-surat.store');
Route::get('/riwayat-status-surat/{riwayat_status_surat}', [RiwayatStatusSuratController::class, 'show'])->name('riwayat-status-surat.show');
Route::get('/riwayat-status-surat/{riwayat_status_surat}/edit', [RiwayatStatusSuratController::class, 'edit'])->name('riwayat-status-surat.edit');
Route::put('/riwayat-status-surat/{riwayat_status_surat}', [RiwayatStatusSuratController::class, 'update'])->name('riwayat-status-surat.update');
Route::delete('/riwayat-status-surat/{riwayat_status_surat}', [RiwayatStatusSuratController::class, 'destroy'])->name('riwayat-status-surat.destroy');

// ✅ ROUTE UNTUK HAPUS FILE MEDIA
Route::delete('/riwayat-status-surat/{riwayat_id}/media/{media_id}',
    [RiwayatStatusSuratController::class, 'destroyMedia'])->name('riwayat-status-surat.media.destroy');

// ✅ ROUTE KHUSUS UNTUK PENGAJUAN (UBAH: permohonan -> pengajuan)
Route::post('/pengajuan/{pengajuan_id}/riwayat',  // DIUBAH
    [RiwayatStatusSuratController::class, 'createFromPengajuan'])->name('pengajuan.riwayat.store'); // DIUBAH

// ✅ ROUTE GET RIWAYAT BY PENGAJUAN (AJAX) - UBAH
Route::get('/pengajuan/{pengajuan_id}/riwayat',  // DIUBAH
    [RiwayatStatusSuratController::class, 'getByPengajuan'])->name('pengajuan.riwayat.get'); // DIUBAH
