<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        // Menampilkan form login
        return view('login-form');
    }

    public function login(Request $request)
    {
        // Validasi input form
        $request->validate([
            'username' => 'required',
            'password' => [
                'required',
                'min:3',
                'regex:/[A-Z]/' // harus ada huruf kapital
            ],
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 3 karakter!',
            'password.regex' => 'Password harus mengandung huruf kapital!',
        ]);

        // Jika username dan password sama, login berhasil
        if ($request->username === $request->password) {
            return view('login-success', ['username' => $request->username]);
        }

        // Jika tidak sesuai
        return back()->withErrors(['login' => 'Username dan password tidak cocok!'])->withInput();
    }
}
