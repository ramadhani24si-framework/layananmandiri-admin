<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Warga;
use App\Models\JenisSurat;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::with(['warga', 'jenisSurat']);

        // Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_id')) {
            $query->where('jenis_id', $request->jenis_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pengajuan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pengajuan', '<=', $request->tanggal_sampai);
        }

        // Search
        if ($request->filled('search')) {
            $query->searchWithRelations($request->search);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->paginate(10);
        $jenisSurat = JenisSurat::all();
        $statusList = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return view('pages.pengajuan.index', compact('pengajuan', 'jenisSurat', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warga = Warga::orderBy('nama')->get();
        $jenisSurat = JenisSurat::orderBy('nama_jenis')->get();
        $nomorPermohonan = Pengajuan::generateNomorPermohonan();

        return view('pages.pengajuan.create', compact('warga', 'jenisSurat', 'nomorPermohonan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_permohonan' => 'required|unique:pengajuans',
            'warga_id' => 'required|exists:warga,warga_id',
            'jenis_id' => 'required|exists:jenis_surat,jenis_id',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:draft,diajukan,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
            'lampiran_files' => 'nullable|array',
            'lampiran_files.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'lampiran_captions.*' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $pengajuan = Pengajuan::create($request->only([
                'nomor_permohonan',
                'warga_id',
                'jenis_id',
                'tanggal_pengajuan',
                'status',
                'catatan'
            ]));

            // ✅ UPLOAD LAMPIRAN FILES
            if ($request->hasFile('lampiran_files')) {
                foreach ($request->file('lampiran_files') as $index => $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $fileName = time() . '_' . uniqid() . '_' . str_replace([' ', '.', '-'], '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                        // Simpan file ke storage
                        Storage::disk('public')->putFileAs(
                            'media/pengajuan',
                            $file,
                            $fileName
                        );

                        // Simpan ke tabel media
                        Media::create([
                            'ref_table'  => 'pengajuans',
                            'ref_id'     => $pengajuan->permohonan_id,
                            'file_name'  => $fileName,
                            'caption'    => $request->lampiran_captions[$index] ?? $originalName,
                            'mime_type'  => $file->getMimeType(),
                            'sort_order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('pengajuan.index')
                ->with('success', 'Pengajuan surat berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pengajuan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuan = Pengajuan::with(['warga', 'jenisSurat', 'lampiranFiles'])
            ->findOrFail($id);

        return view('pages.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengajuan = Pengajuan::with('lampiranFiles')->findOrFail($id);
        $warga = Warga::orderBy('nama')->get();
        $jenisSurat = JenisSurat::orderBy('nama_jenis')->get();
        $statusList = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return view('pages.pengajuan.edit', compact('pengajuan', 'warga', 'jenisSurat', 'statusList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nomor_permohonan' => 'required|unique:pengajuans,nomor_permohonan,' . $id . ',permohonan_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'jenis_id' => 'required|exists:jenis_surat,jenis_id',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:draft,diajukan,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
            'lampiran_files' => 'nullable|array',
            'lampiran_files.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'lampiran_captions.*' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $oldStatus = $pengajuan->status;
            $newStatus = $request->status;

            $pengajuan->update($request->only([
                'nomor_permohonan',
                'warga_id',
                'jenis_id',
                'tanggal_pengajuan',
                'status',
                'catatan'
            ]));

            // ✅ UPLOAD LAMPIRAN FILES BARU
            if ($request->hasFile('lampiran_files')) {
                $existingCount = Media::where('ref_table', 'pengajuans')
                    ->where('ref_id', $id)
                    ->count();

                foreach ($request->file('lampiran_files') as $index => $file) {
                    if ($file->isValid()) {
                        $originalName = $file->getClientOriginalName();
                        $fileName = time() . '_' . uniqid() . '_' . str_replace([' ', '.', '-'], '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                        // Simpan file
                        Storage::disk('public')->putFileAs(
                            'media/pengajuan',
                            $file,
                            $fileName
                        );

                        Media::create([
                            'ref_table'  => 'pengajuans',
                            'ref_id'     => $id,
                            'file_name'  => $fileName,
                            'caption'    => $request->lampiran_captions[$index] ?? $originalName,
                            'mime_type'  => $file->getMimeType(),
                            'sort_order' => $existingCount + $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('pengajuan.index')
                ->with('success', 'Pengajuan surat berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui pengajuan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $pengajuan = Pengajuan::findOrFail($id);

            // Hapus semua file media terkait
            $mediaFiles = Media::where('ref_table', 'pengajuans')
                ->where('ref_id', $id)
                ->get();

            foreach ($mediaFiles as $media) {
                // Hapus file fisik
                if (Storage::disk('public')->exists('media/pengajuan/' . $media->file_name)) {
                    Storage::disk('public')->delete('media/pengajuan/' . $media->file_name);
                }

                $media->delete();
            }

            // Hapus pengajuan
            $pengajuan->delete();

            DB::commit();

            return redirect()->route('pengajuan.index')
                ->with('success', 'Pengajuan surat berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pengajuan.index')
                ->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Update status pengajuan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,diajukan,diproses,selesai,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $oldStatus = $pengajuan->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            $pengajuan->update(['status' => $newStatus]);

            // Buat riwayat status
            // (akan dibuat setelah migration riwayat_status_surat)

            DB::commit();

            return back()->with('success', 'Status pengajuan berhasil diubah.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Hapus file lampiran (AJAX)
     */
    public function destroyLampiran($pengajuan_id, $media_id)
    {
        try {
            $media = Media::where('ref_table', 'pengajuans')
                ->where('ref_id', $pengajuan_id)
                ->where('media_id', $media_id)
                ->firstOrFail();

            // Hapus file dari storage
            if (Storage::disk('public')->exists('media/pengajuan/' . $media->file_name)) {
                Storage::disk('public')->delete('media/pengajuan/' . $media->file_name);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'File lampiran berhasil dihapus',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file: ' . $e->getMessage(),
            ], 500);
        }
    }
}
