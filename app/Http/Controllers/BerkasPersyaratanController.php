<?php

namespace App\Http\Controllers;

use App\Models\BerkasPersyaratan;
use App\Models\Pengajuan; // DIUBAH: PermohonanSurat menjadi Pengajuan
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BerkasPersyaratanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil semua berkas dengan relasi (UBAH permohonan menjadi pengajuan)
        $berkas = BerkasPersyaratan::with(['pengajuan', 'pengajuan.jenis', 'pengajuan.pemohon']) // DIUBAH
                                  ->latest()
                                  ->paginate(10);

        return view('berkas_persyaratan.index', compact('berkas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil pengajuan yang masih aktif (UBAH PermohonanSurat menjadi Pengajuan)
        $pengajuans = Pengajuan::whereIn('status', ['menunggu', 'diproses']) // DIUBAH
                              ->with(['jenis', 'pemohon'])
                              ->get();

        return view('berkas_persyaratan.create', compact('pengajuans')); // DIUBAH variable name
    }

    /**
     * ✅ STORE dengan MULTIPLE FILE UPLOAD ke MEDIA (SUDAH DIUBAH)
     */
    public function store(Request $request)
    {
        // Validasi (UBAH permohonan_id menjadi pengajuan_id)
        $validator = Validator::make($request->all(), [
            'pengajuan_id' => 'required|exists:pengajuans,pengajuan_id', // DIUBAH
            'nama_berkas' => 'required|string|max:200',
            'valid' => 'required|in:ya,tidak,proses',
            'files' => 'required|array|min:1',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ], [
            'pengajuan_id.required' => 'Pengajuan harus dipilih', // DIUBAH pesan
            'pengajuan_id.exists' => 'Pengajuan tidak ditemukan', // DIUBAH pesan
            'nama_berkas.required' => 'Nama berkas harus diisi',
            'files.required' => 'Minimal upload 1 file',
            'files.*.mimes' => 'File harus berupa: jpg, jpeg, png, pdf, doc, docx',
            'files.*.max' => 'File maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 1. SIMPAN BERKAS PERSYARATAN (UBAH pengajuan_id)
        $berkas = BerkasPersyaratan::create([
            'pengajuan_id' => $request->pengajuan_id, // DIUBAH
            'nama_berkas' => $request->nama_berkas,
            'valid' => $request->valid,
        ]);

        // ✅ 2. UPLOAD MULTIPLE FILES KE TABEL MEDIA
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                if ($file->isValid()) {
                    // Generate nama file
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Simpan file ke folder
                    $file->move(
                        public_path('uploads/media/berkas_persyaratan'),
                        $fileName
                    );

                    // ✅ SIMPAN KE TABEL MEDIA
                    Media::create([
                        'ref_table' => 'berkas_persyaratan',
                        'ref_id' => $berkas->berkas_id,
                        'file_name' => $fileName,
                        'caption' => $request->nama_berkas,
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('berkas-persyaratan.index')
            ->with('success', 'Berkas persyaratan berhasil ditambahkan dengan ' . count($request->file('files')) . ' file');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $berkas = BerkasPersyaratan::with(['pengajuan', 'pengajuan.jenis', 'pengajuan.pemohon']) // DIUBAH
                                  ->findOrFail($id);

        // ✅ AMBIL FILE MEDIA
        $mediaFiles = Media::where('ref_table', 'berkas_persyaratan')
                          ->where('ref_id', $id)
                          ->orderBy('sort_order')
                          ->get();

        return view('berkas_persyaratan.show', compact('berkas', 'mediaFiles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berkas = BerkasPersyaratan::findOrFail($id);
        $pengajuans = Pengajuan::all(); // DIUBAH: PermohonanSurat menjadi Pengajuan

        // ✅ AMBIL FILE MEDIA
        $mediaFiles = Media::where('ref_table', 'berkas_persyaratan')
                          ->where('ref_id', $id)
                          ->orderBy('sort_order')
                          ->get();

        return view('berkas_persyaratan.edit', compact('berkas', 'pengajuans', 'mediaFiles')); // DIUBAH variable name
    }

    /**
     * ✅ UPDATE dengan tambahan file (SUDAH DIUBAH)
     */
    public function update(Request $request, $id)
    {
        $berkas = BerkasPersyaratan::findOrFail($id);

        // Validasi (UBAH permohonan_id menjadi pengajuan_id)
        $validator = Validator::make($request->all(), [
            'pengajuan_id' => 'required|exists:pengajuans,pengajuan_id', // DIUBAH
            'nama_berkas' => 'required|string|max:200',
            'valid' => 'required|in:ya,tidak,proses',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update berkas (UBAH pengajuan_id)
        $berkas->update([
            'pengajuan_id' => $request->pengajuan_id, // DIUBAH
            'nama_berkas' => $request->nama_berkas,
            'valid' => $request->valid,
        ]);

        // ✅ UPLOAD FILE BARU JIKA ADA
        if ($request->hasFile('files')) {
            $existingCount = Media::where('ref_table', 'berkas_persyaratan')
                                 ->where('ref_id', $id)
                                 ->count();

            foreach ($request->file('files') as $index => $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/media/berkas_persyaratan'), $fileName);

                    Media::create([
                        'ref_table' => 'berkas_persyaratan',
                        'ref_id' => $id,
                        'file_name' => $fileName,
                        'caption' => $request->nama_berkas,
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $existingCount + $index,
                    ]);
                }
            }
        }

        return redirect()->route('berkas-persyaratan.index')
            ->with('success', 'Berkas persyaratan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berkas = BerkasPersyaratan::findOrFail($id);

        // ✅ HAPUS SEMUA FILE MEDIA TERKAIT
        $berkas->deleteMediaFiles();

        // Hapus berkas
        $berkas->delete();

        return redirect()->route('berkas-persyaratan.index')
            ->with('success', 'Berkas persyaratan berhasil dihapus');
    }

    /**
     * ✅ HAPUS FILE MEDIA SATUAN (AJAX)
     */
    public function destroyMedia($berkas_id, $media_id)
    {
        // Pastikan media milik berkas yang benar
        $media = Media::where('ref_table', 'berkas_persyaratan')
                     ->where('ref_id', $berkas_id)
                     ->where('media_id', $media_id)
                     ->firstOrFail();

        // Hapus file fisik
        $filePath = public_path('uploads/media/berkas_persyaratan/' . $media->file_name);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus dari database
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus'
        ]);
    }

    /**
     * UPDATE STATUS VALIDASI
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'valid' => 'required|in:ya,tidak'
        ]);

        $berkas = BerkasPersyaratan::findOrFail($id);
        $berkas->update(['valid' => $request->valid]);

        return response()->json([
            'success' => true,
            'message' => 'Status validasi diperbarui'
        ]);
    }

    /**
     * GET BERKAS BY PENGAJUAN (AJAX)
     */
    public function getByPengajuan($pengajuan_id)
    {
        $berkas = BerkasPersyaratan::with(['mediaFiles'])
                                  ->where('pengajuan_id', $pengajuan_id)
                                  ->get();

        return response()->json([
            'success' => true,
            'data' => $berkas
        ]);
    }
}
