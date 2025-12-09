<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        // Kolom filter
        $filterableColumns = ['status', 'jenis_id'];

        // Kolom search
        $searchableColumns = ['nama_pemohon', 'keterangan'];

        $pengajuans = Pengajuan::with('jenisSurat')
                ->filter($request, $filterableColumns)
                ->search($request, $searchableColumns)
                ->latest()
                ->paginate(10)
                ->withQueryString();

        return view('pages.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $jenisSurats = JenisSurat::all();
        return view('pages.pengajuan.create', compact('jenisSurats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis_surat,jenis_id',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Menunggu,Diproses,Selesai',
        ]);

        Pengajuan::create($request->all());

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function edit(Pengajuan $pengajuan)
    {
        $pengajuan->load('jenisSurat');
        $jenisSurats = JenisSurat::all();
        return view('pages.pengajuan.edit', compact('pengajuan', 'jenisSurats'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis_surat,jenis_id',
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
