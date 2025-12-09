<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Kolom filter
        $filterable = ['jenis_kelamin', 'agama'];

        // Kolom search
        $searchable = ['nama', 'no_ktp', 'pekerjaan', 'telp', 'email'];

        $data['warga'] = Warga::filter($request, $filterable)
                              ->search($request, $searchable)
                              ->paginate(10)
                              ->withQueryString();

        return view('pages.warga.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.warga.create');
    }

    /**
     * Store the newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_ktp' => 'required|string|size:16|unique:warga',
            'nama' => 'required|string|max:255|min:3',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pekerjaan' => 'required|string|max:255|min:2',
            'telp' => 'required|string|min:10|max:15',
            'email' => 'nullable|email|max:255'
        ]);

        Warga::create($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['warga'] = Warga::findOrFail($id);
        return view('pages.warga.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warga = Warga::findOrFail($id);

        $warga->update($request->all());

        return redirect()->route('warga.index')->with('success', 'Perubahan Data Warga Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warga = Warga::findOrFail($id);
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data berhasil dihapus');
    }
}
