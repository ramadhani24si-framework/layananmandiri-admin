<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\Pengajuan;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userName = $user->name;
        $userRole = $user->role; // AMBIL ROLE DARI USER

        // Debug: Cek role user
        // dd($userRole); // Uncomment untuk debugging

        // Data berdasarkan role
        if (in_array($userRole, ['super_admin', 'warga'])) {
            // Data untuk admin dan super_admin
            $userCount = User::count();
            $wargaCount = Warga::count();
            $pengajuanCount = Pengajuan::count();
            $jenisSuratCount = JenisSurat::count();

            // Status pengajuan - SESUAIKAN DENGAN STATUS DI MODEL PENGAJUAN
            $pengajuanPending = Pengajuan::where('status', 'draft')->count();
            $pengajuanDiproses = Pengajuan::where('status', 'diproses')->count();
            $pengajuanSelesai = Pengajuan::where('status', 'selesai')->count();
            $pengajuanDitolak = Pengajuan::where('status', 'ditolak')->count();

            // Recent pengajuan untuk admin
            $recentPengajuan = Pengajuan::with(['warga', 'jenisSurat'])
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact(
                'userCount',
                'wargaCount',
                'pengajuanCount',
                'jenisSuratCount',
                'userName',
                'pengajuanPending',
                'pengajuanDiproses',
                'pengajuanSelesai',
                'pengajuanDitolak',
                'recentPengajuan',
                'userRole' // KIRIM USERROLE KE VIEW
            ));
        } else {
            // Data untuk user biasa/warga
            $pengajuanCount = 0;
            $pengajuanPending = 0;
            $pengajuanDiproses = 0;
            $pengajuanSelesai = 0;
            $pengajuanDitolak = 0;
            $recentPengajuan = collect([]);

            return view('dashboard', compact(
                'userName',
                'pengajuanCount',
                'pengajuanPending',
                'pengajuanDiproses',
                'pengajuanSelesai',
                'pengajuanDitolak',
                'recentPengajuan',
                'userRole' // KIRIM USERROLE KE VIEW
            ));
        }
    }
}
