<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Warga;


class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['warga'] = Warga::all();
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
     * Store a newly created resource in storage.
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
        ], [
            // Pesan error dalam bahasa Indonesia
            'no_ktp.required' => 'Nomor KTP wajib diisi',
            'no_ktp.size' => 'Nomor KTP harus 16 digit',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar',
            'nama.required' => 'Nama lengkap wajib diisi',
            'nama.min' => 'Nama lengkap minimal 3 karakter',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
            'agama.required' => 'Agama wajib dipilih',
            'agama.in' => 'Agama harus dipilih dari pilihan yang tersedia',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'pekerjaan.min' => 'Pekerjaan minimal 2 karakter',
            'telp.required' => 'Nomor telepon wajib diisi',
            'telp.min' => 'Nomor telepon minimal 10 digit',
            'telp.max' => 'Nomor telepon maksimal 15 digit',
            'email.email' => 'Format email tidak valid'
        ]);


        Warga::create($validated);


        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Warga $id) {}


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
        $warga_id = $id;
        $warga = Warga::findOrFail($warga_id);

        $warga->no_ktp = $request->no_ktp;
        $warga->nama = $request->nama;
        $warga->jenis_kelamin = $request->jenis_kelamin;
        $warga->agama = $request->agama;
        $warga->pekerjaan = $request->pekerjaan;
        $warga->telp = $request->telp;
        $warga->email = $request->email;

        $warga->save();

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
