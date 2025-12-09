<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStatusSurat;
use App\Models\Pengajuan; // DIUBAH: PermohonanSurat -> Pengajuan
use App\Models\Warga;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RiwayatStatusSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RiwayatStatusSurat::with(['pengajuan', 'petugas']) // DIUBAH
                                  ->latest();

        // Filter by pengajuan_id (UBAH: permohonan_id -> pengajuan_id)
        if ($request->has('pengajuan_id') && $request->pengajuan_id) { // DIUBAH
            $query->where('pengajuan_id', $request->pengajuan_id); // DIUBAH
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by petugas
        if ($request->has('petugas_id') && $request->petugas_id) {
            $query->where('petugas_warga_id', $request->petugas_id);
        }

        $riwayat = $query->paginate(15);

        return view('riwayat_status_surat.index', compact('riwayat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pengajuan = Pengajuan::with(['jenis', 'pemohon'])->get(); // DIUBAH
        $petugas = Warga::where('level', '!=', 'warga')->get(); // Asumsi ada kolom level

        // Default pengajuan jika ada di query string (UBAH)
        $selectedPengajuan = $request->query('pengajuan_id'); // DIUBAH

        return view('riwayat_status_surat.create', compact('pengajuan', 'petugas', 'selectedPengajuan')); // DIUBAH
    }

    /**
     * ✅ STORE dengan MULTIPLE FILE UPLOAD ke MEDIA (SUDAH DIUBAH)
     */
    public function store(Request $request)
    {
        // Validasi (UBAH: permohonan_id -> pengajuan_id)
        $validator = Validator::make($request->all(), [
            'pengajuan_id' => 'required|exists:pengajuans,pengajuan_id', // DIUBAH
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'petugas_warga_id' => 'required|exists:warga,warga_id',
            'keterangan' => 'nullable|string|max:500',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ], [
            'pengajuan_id.required' => 'Pengajuan surat harus dipilih', // DIUBAH
            'pengajuan_id.exists' => 'Pengajuan tidak ditemukan', // DIUBAH
            'status.required' => 'Status harus dipilih',
            'petugas_warga_id.required' => 'Petugas harus dipilih',
            'files.*.mimes' => 'File harus berupa: jpg, jpeg, png, pdf, doc, docx',
            'files.*.max' => 'File maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 1. SIMPAN RIWAYAT STATUS (UBAH: pengajuan_id)
        $riwayat = RiwayatStatusSurat::create([
            'pengajuan_id' => $request->pengajuan_id, // DIUBAH
            'status' => $request->status,
            'petugas_warga_id' => $request->petugas_warga_id,
            'keterangan' => $request->keterangan,
            'waktu' => now(),
        ]);

        // ✅ 2. UPLOAD MULTIPLE FILES KE TABEL MEDIA
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                if ($file->isValid()) {
                    // Generate nama file
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Simpan file ke folder
                    $file->move(
                        public_path('uploads/media/riwayat_status_surat'),
                        $fileName
                    );

                    // ✅ SIMPAN KE TABEL MEDIA
                    Media::create([
                        'ref_table' => 'riwayat_status_surat',
                        'ref_id' => $riwayat->riwayat_id,
                        'file_name' => $fileName,
                        'caption' => $request->keterangan ?: "Bukti status {$request->status}",
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        // 3. Update status di pengajuan (UBAH: PermohonanSurat -> Pengajuan)
        $pengajuan = Pengajuan::find($request->pengajuan_id); // DIUBAH
        if ($pengajuan) {
            $pengajuan->update(['status' => $request->status]);
        }

        return redirect()->route('riwayat-status-surat.index')
            ->with('success', 'Riwayat status berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $riwayat = RiwayatStatusSurat::with(['pengajuan', 'pengajuan.jenis', 'pengajuan.pemohon', 'petugas']) // DIUBAH
                                    ->findOrFail($id);

        // ✅ AMBIL FILE MEDIA
        $mediaFiles = Media::where('ref_table', 'riwayat_status_surat')
                          ->where('ref_id', $id)
                          ->orderBy('sort_order')
                          ->get();

        return view('riwayat_status_surat.show', compact('riwayat', 'mediaFiles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $riwayat = RiwayatStatusSurat::findOrFail($id);
        $pengajuan = Pengajuan::all(); // DIUBAH
        $petugas = Warga::where('level', '!=', 'warga')->get();

        // ✅ AMBIL FILE MEDIA
        $mediaFiles = Media::where('ref_table', 'riwayat_status_surat')
                          ->where('ref_id', $id)
                          ->orderBy('sort_order')
                          ->get();

        return view('riwayat_status_surat.edit', compact('riwayat', 'pengajuan', 'petugas', 'mediaFiles')); // DIUBAH
    }

    /**
     * ✅ UPDATE dengan tambahan file (SUDAH DIUBAH)
     */
    public function update(Request $request, $id)
    {
        $riwayat = RiwayatStatusSurat::findOrFail($id);

        // Validasi (UBAH: permohonan_id -> pengajuan_id)
        $validator = Validator::make($request->all(), [
            'pengajuan_id' => 'required|exists:pengajuans,pengajuan_id', // DIUBAH
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'petugas_warga_id' => 'required|exists:warga,warga_id',
            'keterangan' => 'nullable|string|max:500',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update riwayat (UBAH: pengajuan_id)
        $riwayat->update([
            'pengajuan_id' => $request->pengajuan_id, // DIUBAH
            'status' => $request->status,
            'petugas_warga_id' => $request->petugas_warga_id,
            'keterangan' => $request->keterangan,
        ]);

        // ✅ UPLOAD FILE BARU JIKA ADA
        if ($request->hasFile('files')) {
            $existingCount = Media::where('ref_table', 'riwayat_status_surat')
                                 ->where('ref_id', $id)
                                 ->count();

            foreach ($request->file('files') as $index => $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/media/riwayat_status_surat'), $fileName);

                    Media::create([
                        'ref_table' => 'riwayat_status_surat',
                        'ref_id' => $id,
                        'file_name' => $fileName,
                        'caption' => $request->keterangan ?: "Bukti status {$request->status}",
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $existingCount + $index,
                    ]);
                }
            }
        }

        // Update status di pengajuan jika berbeda (UBAH)
        $pengajuan = Pengajuan::find($request->pengajuan_id); // DIUBAH
        if ($pengajuan && $pengajuan->status != $request->status) {
            $pengajuan->update(['status' => $request->status]);
        }

        return redirect()->route('riwayat-status-surat.show', $riwayat->riwayat_id)
            ->with('success', 'Riwayat status berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $riwayat = RiwayatStatusSurat::findOrFail($id);
        $pengajuan_id = $riwayat->pengajuan_id; // DIUBAH

        // ✅ HAPUS SEMUA FILE MEDIA TERKAIT
        $riwayat->deleteMediaFiles();

        // Hapus riwayat
        $riwayat->delete();

        return redirect()->route('pengajuan.show', $pengajuan_id) // DIUBAH
            ->with('success', 'Riwayat status berhasil dihapus');
    }

    /**
     * ✅ HAPUS FILE MEDIA SATUAN (AJAX)
     */
    public function destroyMedia($riwayat_id, $media_id)
    {
        // Pastikan media milik riwayat yang benar
        $media = Media::where('ref_table', 'riwayat_status_surat')
                     ->where('ref_id', $riwayat_id)
                     ->where('media_id', $media_id)
                     ->firstOrFail();

        // Hapus file fisik
        $filePath = public_path('uploads/media/riwayat_status_surat/' . $media->file_name);
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
     * BUAT RIWAYAT DARI PENGAJUAN (Modal/Quick Action) - SUDAH DIUBAH
     */
    public function createFromPengajuan(Request $request, $pengajuan_id) // DIUBAH
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai,ditolak',
            'keterangan' => 'nullable|string|max:500',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $petugas_id = auth()->user()->warga_id ?? 1; // Asumsi user terkait warga

        // Buat riwayat (UBAH: pengajuan_id)
        $riwayat = RiwayatStatusSurat::create([
            'pengajuan_id' => $pengajuan_id, // DIUBAH
            'status' => $request->status,
            'petugas_warga_id' => $petugas_id,
            'keterangan' => $request->keterangan,
            'waktu' => now(),
        ]);

        // Upload files jika ada
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/media/riwayat_status_surat'), $fileName);

                    Media::create([
                        'ref_table' => 'riwayat_status_surat',
                        'ref_id' => $riwayat->riwayat_id,
                        'file_name' => $fileName,
                        'caption' => $request->keterangan ?: "Bukti status {$request->status}",
                        'mime_type' => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        // Update status pengajuan (UBAH)
        Pengajuan::where('pengajuan_id', $pengajuan_id) // DIUBAH
                ->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Status pengajuan berhasil diperbarui'); // DIUBAH
    }

    /**
     * GET RIWAYAT BY PENGAJUAN (AJAX/JSON) - SUDAH DIUBAH
     */
    public function getByPengajuan($pengajuan_id) // DIUBAH
    {
        $riwayat = RiwayatStatusSurat::with(['petugas', 'mediaFiles'])
                                    ->where('pengajuan_id', $pengajuan_id) // DIUBAH
                                    ->orderBy('waktu', 'desc')
                                    ->get();

        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }
}
