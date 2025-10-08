<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormPengaduanController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/formpengaduan', [FormPengaduanController::class, 'index']);

Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
