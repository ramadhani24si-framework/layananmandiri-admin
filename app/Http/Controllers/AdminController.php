<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung jumlah pengguna
        $userCount = User::count();

        // Ambil nama pengguna yang sedang login
        $userName = auth()->user()->name;


        return view('dashboard', compact('userCount', 'userName'));
    }
}
