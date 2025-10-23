<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\PermohonanSuratController;


Route::get('/', function () {
    return view('welcome');
});
//auth
Route::get('/formpengaduan', [FormPengaduanController::class, 'index']);
Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
//admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//warga
Route::get('/warga', [WargaController::class, 'index'])->name('warga');

//permohonansurat
Route::resource('permohonansurat', PermohonanSuratController::class);
