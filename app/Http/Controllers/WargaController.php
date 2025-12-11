<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Warga::query();

        // Filter jenis kelamin (form: L/P, database: Laki-laki/Perempuan)
        if ($request->filled('jenis_kelamin')) {
            $jkForm = $request->jenis_kelamin;
            $jkDB = $jkForm == 'L' ? 'Laki-laki' : 'Perempuan';
            $query->where('jenis_kelamin', $jkDB);
        }

        // Filter agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        // Search
        if ($request->filled('search')) {
            $query->searchSimple($request->search);
        }

        $warga = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.warga.index', compact('warga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        return view('pages.warga.create', compact('agamaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Konversi 'L'/'P' ke 'Laki-laki'/'Perempuan'
        $data = $request->all();

        if ($data['jenis_kelamin'] == 'L') {
            $data['jenis_kelamin'] = 'Laki-laki';
        } elseif ($data['jenis_kelamin'] == 'P') {
            $data['jenis_kelamin'] = 'Perempuan';
        }

        $validator = Validator::make($data, [
            'no_ktp' => 'required|numeric|digits:16|unique:warga',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'telp' => 'required|string|max:15',
            'email' => 'required|email|unique:warga',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Warga::create($data);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $warga = Warga::findOrFail($id);
        return view('pages.warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warga = Warga::findOrFail($id);
        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

        // Konversi untuk form: 'Laki-laki'/'Perempuan' ke 'L'/'P'
        $jenis_kelamin_form = $warga->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';

        return view('pages.warga.edit', compact('warga', 'agamaList', 'jenis_kelamin_form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $data = $request->all();

        // Konversi 'L'/'P' ke 'Laki-laki'/'Perempuan'
        if ($data['jenis_kelamin'] == 'L') {
            $data['jenis_kelamin'] = 'Laki-laki';
        } elseif ($data['jenis_kelamin'] == 'P') {
            $data['jenis_kelamin'] = 'Perempuan';
        }

        $validator = Validator::make($data, [
            'no_ktp' => 'required|numeric|digits:16|unique:warga,no_ktp,' . $id . ',warga_id',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'telp' => 'required|string|max:15',
            'email' => 'required|email|unique:warga,email,' . $id . ',warga_id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $warga->update($data);

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warga = Warga::findOrFail($id);

        // Cek apakah warga punya pengajuan
        if ($warga->memiliki_pengajuan) {
            return redirect()->route('warga.index')
                ->with('error', 'Tidak dapat menghapus warga yang sudah memiliki pengajuan.');
        }

        $warga->delete();

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }
}
