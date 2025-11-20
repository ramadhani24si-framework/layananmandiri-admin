<?php
namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index()
    {
        $data = JenisSurat::latest()->get();
        return view('pages.jenis_surat.index', compact('data'));
    }

    public function create()
    {
        return view('pages.jenis_surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'        => 'required|string|max:50|unique:jenis_surat,kode',
            'nama_jenis'  => 'required|string|max:150',
            'syarat_json' => 'nullable|string',
        ]);

        // Ubah input syarat menjadi JSON otomatis
        $syarat = $request->syarat_json;

        // Pisahkan berdasarkan koma → bikin array
        // Contoh input: ktp, kk, surat pengantar
        // Output: ["ktp","kk","surat pengantar"]
        if ($syarat) {
            $syarat = array_map('trim', explode(',', $syarat));
        }

        JenisSurat::create([
            'kode'        => $request->kode,
            'nama_jenis'  => $request->nama_jenis,
            'syarat_json' => json_encode($syarat), // otomatis jadi JSON valid
        ]);

        return redirect()->route('jenis_surat.index')->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis_surat = JenisSurat::findOrFail($id);
        return view('pages.jenis_surat.edit', compact('jenis_surat'));
    }

    public function update(Request $request, $id)
    {
        $jenis_surat = JenisSurat::findOrFail($id);

        $request->validate([
            'kode'        => 'required|string|max:50|unique:jenis_surat,kode,' . $jenis_surat->jenis_id . ',jenis_id',
            'nama_jenis'  => 'required|string|max:150',
            'syarat_json' => 'nullable|string',
        ]);

        $syarat = $request->syarat_json;
        if ($syarat) {
            $syarat = array_map('trim', explode(',', $syarat));
        }

        $jenis_surat->update([
            'kode'        => $request->kode,
            'nama_jenis'  => $request->nama_jenis,
            'syarat_json' => json_encode($syarat),
        ]);

        return redirect()->route('jenis_surat.index')->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis_surat = JenisSurat::findOrFail($id);
        $jenis_surat->delete();

        return redirect()->route('jenis_surat.index')->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
