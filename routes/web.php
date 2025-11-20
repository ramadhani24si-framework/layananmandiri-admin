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


