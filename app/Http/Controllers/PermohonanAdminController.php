<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermohonanAdminController extends Controller
{
    public function index()
    {
        /* Cara 1 */
        $data['judul'] = 'Daftar Permohonan Surat';
        $data['admin'] = 'Adricy';
        $data['waktu_login'] = date('Y-m-d H:i:s');

        // contoh data permohonan surat (hardcode)
        $data['permohonan'] = [
            [
                'permohonan_id' => 1,
                'nomor_permohonan' => 'PRM-001',
                'pemohon_warga_id' => 'W001',
                'jenis_id' => 'Surat Keterangan Domisili',
                'tanggal_pengajuan' => '2025-10-01',
                'status' => 'Menunggu Verifikasi',
                'catatan' => '-'
            ],
            [
                'permohonan_id' => 2,
                'nomor_permohonan' => 'PRM-002',
                'pemohon_warga_id' => 'W002',
                'jenis_id' => 'Surat Keterangan Usaha',
                'tanggal_pengajuan' => '2025-10-01',
                'status' => 'Disetujui',
                'catatan' => 'Selesai diproses'
            ],
        ];

        return view('permohonan', $data);
    }
}
