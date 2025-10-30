<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::latest()->get();
        return view('pages.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        return view('pages.pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        Pengajuan::create($request->all());

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function edit(Pengajuan $pengajuan)
    {
        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:255',
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
