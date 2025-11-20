<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\JenisSurat; // TAMBAH INI
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        // Ambil data dengan relasi jenisSurat
        $pengajuans = Pengajuan::with('jenisSurat')->latest()->get();
        return view('pages.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        // Ambil semua jenis surat untuk dropdown
        $jenisSurats = JenisSurat::all();
        return view('pages.pengajuan.create', compact('jenisSurats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,jenis_id', // UBAH VALIDASI
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        Pengajuan::create($request->all());

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function edit(Pengajuan $pengajuan)
    {
        // Load relasi dan ambil jenis surat
        $pengajuan->load('jenisSurat');
        $jenisSurats = JenisSurat::all();
        return view('pages.pengajuan.edit', compact('pengajuan', 'jenisSurats'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,jenis_id', // UBAH VALIDASI
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        $pengajuan->update($request->all());

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();
        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
