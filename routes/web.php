<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PengajuanController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });


// Halaman login & register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Aksi login & register
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (hanya bisa diakses jika sudah login)
// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
// });

Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
Route::resource('pengajuan', PengajuanController::class);

Route::resource('user', UserController::class);
Route::resource('warga', WargaController::class);
