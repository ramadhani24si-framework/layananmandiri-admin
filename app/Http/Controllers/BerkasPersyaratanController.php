<?php

namespace App\Http\Controllers;

use App\Models\BerkasPersyaratan;
use App\Models\Pengajuan;
use App\Models\Media; // ✅ TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BerkasPersyaratanController extends Controller
{
    public function index(Request $request)
    {
        $query = BerkasPersyaratan::with(['pengajuan.warga', 'media']); // ✅ TAMBAH 'media'

        if ($request->filled('valid')) {
            $query->where('valid', $request->valid);
        }

        if ($request->filled('search')) {
            $query->where('nama_berkas', 'like', '%' . $request->search . '%');
        }

        $berkas = $query->orderBy('created_at', 'desc')->paginate(10);
        $statusList = [
            'menunggu' => 'Menunggu',
            'valid' => 'Valid',
            'tidak_valid' => 'Tidak Valid'
        ];

        return view('pages.berkas_persyaratan.index', compact('berkas', 'statusList'));
    }

    public function create()
    {
        $pengajuan = Pengajuan::with('warga')->orderBy('created_at', 'desc')->get();
        return view('pages.berkas_persyaratan.create', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'permohonan_id' => 'required|exists:pengajuans,permohonan_id',
            'nama_berkas' => 'required|string|max:100',
            'valid' => 'required|in:menunggu,valid,tidak_valid',
            'berkas_files' => 'required|array|min:1',
            'berkas_files.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'captions.*' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // 1. Simpan data ke tabel berkas_persyaratan
            $berkas = BerkasPersyaratan::create([
                'permohonan_id' => $request->permohonan_id,
                'nama_berkas' => $request->nama_berkas,
                'valid' => $request->valid,
            ]);

            // 2. Upload multiple files ke tabel media
            $uploadedCount = 0;
            foreach ($request->file('berkas_files') as $index => $file) {
                if ($file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $fileName = time() . '_' . $index . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $originalName);

                    // Path: media/berkas_persyaratan/[berkas_id]/[file_name]
                    $path = 'media/berkas_persyaratan/' . $berkas->berkas_id;
                    $filePath = $file->storeAs($path, $fileName, 'public');

                    // Simpan ke tabel media
                    Media::create([
                        'ref_table' => 'berkas_persyaratan',
                        'ref_id' => $berkas->berkas_id,
                        'file_name' => $fileName,
                        'caption' => $request->captions[$index] ?? $originalName,
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);

                    $uploadedCount++;
                }
            }

            return redirect()->route('berkas_persyaratan.index')
                ->with('success', "Berkas '{$request->nama_berkas}' dengan {$uploadedCount} file berhasil ditambahkan.");

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan berkas: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $berkas = BerkasPersyaratan::with(['pengajuan.warga', 'media'])->findOrFail($id);
        return view('pages.berkas_persyaratan.show', compact('berkas'));
    }

    public function edit($id)
    {
        $berkas = BerkasPersyaratan::with('media')->findOrFail($id);
        $pengajuan = Pengajuan::with('warga')->orderBy('created_at', 'desc')->get();
        $statusList = [
            'menunggu' => 'Menunggu',
            'valid' => 'Valid',
            'tidak_valid' => 'Tidak Valid'
        ];

        return view('pages.berkas_persyaratan.edit', compact('berkas', 'pengajuan', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $berkas = BerkasPersyaratan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'permohonan_id' => 'required|exists:pengajuans,permohonan_id',
            'nama_berkas' => 'required|string|max:100',
            'valid' => 'required|in:menunggu,valid,tidak_valid',
            'new_files' => 'nullable|array',
            'new_files.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'new_captions.*' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // 1. Update data utama
            $berkas->update([
                'permohonan_id' => $request->permohonan_id,
                'nama_berkas' => $request->nama_berkas,
                'valid' => $request->valid,
            ]);

            // 2. Tambah file baru jika ada
            if ($request->hasFile('new_files')) {
                $existingCount = Media::where('ref_table', 'berkas_persyaratan')
                    ->where('ref_id', $id)
                    ->count();

                foreach ($request->file('new_files') as $index => $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $fileName = time() . '_' . ($existingCount + $index) . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $originalName);

                        $path = 'media/berkas_persyaratan/' . $id;
                        $filePath = $file->storeAs($path, $fileName, 'public');

                        Media::create([
                            'ref_table' => 'berkas_persyaratan',
                            'ref_id' => $id,
                            'file_name' => $fileName,
                            'caption' => $request->new_captions[$index] ?? $originalName,
                            'mime_type' => $file->getMimeType(),
                            'sort_order' => $existingCount + $index,
                        ]);
                    }
                }
            }

            return redirect()->route('berkas_persyaratan.index')
                ->with('success', 'Berkas persyaratan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui berkas: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $berkas = BerkasPersyaratan::findOrFail($id);

        try {
            // 1. Hapus semua file media terkait
            $mediaFiles = Media::where('ref_table', 'berkas_persyaratan')
                ->where('ref_id', $id)
                ->get();

            foreach ($mediaFiles as $media) {
                // Hapus file fisik
                $filePath = 'media/berkas_persyaratan/' . $id . '/' . $media->file_name;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                // Hapus dari database
                $media->delete();
            }

            // 2. Hapus berkas utama
            $berkas->delete();

            return redirect()->route('berkas_persyaratan.index')
                ->with('success', 'Berkas persyaratan dan semua file berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('berkas_persyaratan.index')
                ->with('error', 'Gagal menghapus berkas: ' . $e->getMessage());
        }
    }

    // ✅ METHOD BARU: Hapus file individual dari media
    public function destroyMedia($berkas_id, $media_id)
    {
        try {
            $media = Media::where('ref_table', 'berkas_persyaratan')
                ->where('ref_id', $berkas_id)
                ->where('media_id', $media_id)
                ->firstOrFail();

            // Hapus file fisik
            $filePath = 'media/berkas_persyaratan/' . $berkas_id . '/' . $media->file_name;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Hapus dari database
            $media->delete();

            return back()->with('success', 'File berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    // ✅ METHOD BARU: Download file
    public function downloadMedia($berkas_id, $media_id)
    {
        $media = Media::where('ref_table', 'berkas_persyaratan')
            ->where('ref_id', $berkas_id)
            ->where('media_id', $media_id)
            ->firstOrFail();

        $filePath = 'media/berkas_persyaratan/' . $berkas_id . '/' . $media->file_name;

        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath, $media->caption . '.' . pathinfo($media->file_name, PATHINFO_EXTENSION));
    }
}
