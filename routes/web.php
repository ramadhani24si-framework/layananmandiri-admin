<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormPengaduanController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/formpengaduan', [FormPengaduanController::class, 'index']);

Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('warga', WargaController::class);

Route::resource('surat', SuratController::class);
