<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $userCount = User::count();
        $wargaCount = Warga::count();
        $pengajuanCount = Pengajuan::count();
        $userName = auth()->check() ? auth()->user()->name : 'Guest';

        return view('dashboard', compact('userCount', 'wargaCount', 'pengajuanCount', 'userName'));
    }
}
