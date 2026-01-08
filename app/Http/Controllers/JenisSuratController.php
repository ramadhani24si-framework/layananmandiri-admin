<?php
// app/Http/Controllers/JenisSuratController.php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JenisSurat::query();

        // Filter kode
        if ($request->filled('kode')) {
            $query->where('kode', 'like', '%' . $request->kode . '%');
        }

        // Filter jumlah syarat
        if ($request->filled('syarat_count')) {
            $query->where(function ($q) use ($request) {
                if ($request->syarat_count == '0') {
                    $q->whereNull('syarat_json')
                        ->orWhere('syarat_json', '[]')
                        ->orWhere('syarat_json', '');
                } elseif ($request->syarat_count == '1-3') {
                    $q->whereRaw("JSON_LENGTH(syarat_json) BETWEEN 1 AND 3");
                } elseif ($request->syarat_count == '4-6') {
                    $q->whereRaw("JSON_LENGTH(syarat_json) BETWEEN 4 AND 6");
                } elseif ($request->syarat_count == '7+') {
                    $q->whereRaw("JSON_LENGTH(syarat_json) >= 7");
                }
            });
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_jenis', 'like', '%' . $request->search . '%');
            });
        }

        $jenisSurat = $query->orderBy('kode')->paginate(10);

        return view('pages.jenis_surat.index', compact('jenisSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.jenis_surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode'             => 'required|unique:jenis_surat,kode|max:10',
            'nama_jenis'       => 'required|max:100',
            'syarat_json'      => 'nullable|json',
            'template_files'   => 'nullable|array',
            'template_files.*' => 'file|mimes:doc,docx,pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Parse syarat_json jika ada
            $syarat_json = null;
            if ($request->filled('syarat_json')) {
                $decoded = json_decode($request->syarat_json);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $syarat_json = $request->syarat_json;
                }
            }

            // Buat jenis surat
            $jenisSurat = JenisSurat::create([
                'kode'        => $request->kode,
                'nama_jenis'  => $request->nama_jenis,
                'syarat_json' => $syarat_json,
            ]);

            // Upload template files
            if ($request->hasFile('template_files')) {
                foreach ($request->file('template_files') as $index => $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $fileName = time() . '_' . uniqid() . '_' . str_replace([' ', '.', '-'], '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

                        // Simpan file ke storage
                        $file->storeAs('public/media/jenis_surat', $fileName);

                        // Simpan ke tabel media
                        Media::create([
                            'ref_table'  => 'jenis_surat',
                            'ref_id'     => $jenisSurat->jenis_id,
                            'file_name'  => $fileName,
                            'caption'    => $originalName,
                            'mime_type'  => $file->getMimeType(),
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('jenis_surat.index')
                ->with('success', 'Jenis surat berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // Tambahkan method ini di JenisSuratController
public function downloadTemplate($id)
{
    try {
        $media = Media::findOrFail($id);

        // Validasi: pastikan file milik jenis_surat
        if ($media->ref_table != 'jenis_surat') {
            abort(403, 'File tidak valid');
        }

        $filePath = storage_path('app/public/media/jenis_surat/' . $media->file_name);

        if (!file_exists($filePath)) {
            abort(404, 'File template tidak ditemukan di server');
        }

        return response()->download($filePath, $media->caption ?? $media->file_name);

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal mendownload file: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jenisSurat = JenisSurat::with('mediaFiles')->findOrFail($id);
        return view('pages.jenis_surat.show', compact('jenisSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenisSurat = JenisSurat::with('mediaFiles')->findOrFail($id);
        return view('pages.jenis_surat.edit', compact('jenisSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode'             => 'required|unique:jenis_surat,kode,' . $id . ',jenis_id|max:10',
            'nama_jenis'       => 'required|max:100',
            'syarat_json'      => 'nullable',
            'template_files'   => 'nullable|array',
            'template_files.*' => 'file|mimes:doc,docx,pdf,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // ✅ PERBAIKAN: Handle syarat_json dengan benar
            $syarat_json = $jenisSurat->syarat_json; // Pertahankan nilai lama default

            if ($request->has('syarat_json')) {
                $input = $request->syarat_json;

                if ($input === null || $input === '' || $input === 'null') {
                    $syarat_json = null;
                } else {
                    // Coba decode sebagai JSON
                    $decoded = json_decode($input);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        // Valid JSON
                        $syarat_json = $input;
                    } else {
                        // Jika bukan JSON valid, mungkin sudah dalam format array dari old()
                        // Pertahankan input asli
                        $syarat_json = $input;
                    }
                }
            }

            // Update data
            $jenisSurat->update([
                'kode'        => $request->kode,
                'nama_jenis'  => $request->nama_jenis,
                'syarat_json' => $syarat_json,
            ]);

            // Upload file baru jika ada
            if ($request->hasFile('template_files')) {
                $existingCount = Media::where('ref_table', 'jenis_surat')
                    ->where('ref_id', $id)
                    ->count();

                foreach ($request->file('template_files') as $index => $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $fileName = time() . '_' . uniqid() . '_' . str_replace([' ', '.', '-'], '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

                        // Simpan file
                        $file->storeAs('public/media/jenis_surat', $fileName);

                        Media::create([
                            'ref_table'  => 'jenis_surat',
                            'ref_id'     => $id,
                            'file_name'  => $fileName,
                            'caption'    => $originalName,
                            'mime_type'  => $file->getMimeType(),
                            'sort_order' => $existingCount + $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('jenis_surat.index')
                ->with('success', 'Jenis surat berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $jenisSurat = JenisSurat::findOrFail($id);

            // Hapus semua file media terkait
            $mediaFiles = Media::where('ref_table', 'jenis_surat')
                ->where('ref_id', $id)
                ->get();

            foreach ($mediaFiles as $media) {
                // Hapus file fisik
                $filePath = storage_path('app/public/media/jenis_surat/' . $media->file_name);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $media->delete();
            }

            // Hapus jenis surat
            $jenisSurat->delete();

            DB::commit();

            return redirect()->route('jenis_surat.index')
                ->with('success', 'Jenis surat berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('jenis_surat.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus file media (AJAX) - DIPERBAIKI
     */
    public function destroyMedia($jenis_id, $media_id)
    {
        try {
            $media = Media::where('ref_table', 'jenis_surat')
                ->where('ref_id', $jenis_id)
                ->where('media_id', $media_id) // ✅ Perbaikan: media_id bukan id
                ->firstOrFail();

            // Hapus file dari storage
            $filePath = storage_path('app/public/media/jenis_surat/' . $media->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'File template berhasil dihapus',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file: ' . $e->getMessage(),
            ], 500);
        }
    }
}
