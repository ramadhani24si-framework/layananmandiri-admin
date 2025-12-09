<?php
namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JenisSuratController extends Controller
{
    // ========== SEMUA METHOD UNTUK CRUD ==========

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Dengan search/filter jika perlu
        $query = JenisSurat::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('kode', 'like', '%' . $request->search . '%')
                ->orWhere('nama_jenis', 'like', '%' . $request->search . '%');
        }

        $jenisSurat = $query->orderBy('created_at', 'desc')->paginate(10);

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
     * ✅ Store dengan multiple file upload
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode'             => 'required|unique:jenis_surat',
            'nama_jenis'       => 'required|max:100',
            'syarat_json'      => 'nullable|json',
            'template_files'   => 'nullable|array',
            'template_files.*' => 'file|mimes:doc,docx,pdf|max:5120',
        ], [
            'template_files.*.mimes' => 'Template harus DOC, DOCX, atau PDF',
            'template_files.*.max'   => 'File maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan jenis surat
        $jenisSurat = JenisSurat::create([
            'kode'        => $request->kode,
            'nama_jenis'  => $request->nama_jenis,
            'syarat_json' => $request->syarat_json,
        ]);

        // ✅ Upload multiple files ke tabel media
        if ($request->hasFile('template_files')) {
            foreach ($request->file('template_files') as $index => $file) {
                if ($file->isValid()) {
                    // Generate nama file unik
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Simpan file ke folder
                    $file->move(
                        public_path('uploads/media/jenis_surat'),
                        $fileName
                    );

                    // Simpan ke tabel media
                    Media::create([
                        'ref_table'  => 'jenis_surat',
                        'ref_id'     => $jenisSurat->jenis_id,
                        'file_name'  => $fileName,
                        'caption'    => $file->getClientOriginalName(),
                        'mime_type'  => $file->getMimeType(),
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('jenis-surat.index')
            ->with('success', 'Jenis surat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        // ✅ Ambil semua file media untuk jenis_surat ini
        $mediaFiles = Media::where('ref_table', 'jenis_surat')
            ->where('ref_id', $id)
            ->orderBy('sort_order')
            ->get();

        return view('pages.jenis_surat.show', compact('jenisSurat', 'mediaFiles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        // ✅ Ambil semua file media untuk jenis_surat ini
        $mediaFiles = Media::where('ref_table', 'jenis_surat')
            ->where('ref_id', $id)
            ->orderBy('sort_order')
            ->get();

        return view('pages.jenis_surat.edit', compact('jenisSurat', 'mediaFiles'));
    }

    /**
     * ✅ Update dengan multiple file upload
     */
    public function update(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'kode'             => 'required|unique:jenis_surat,kode,' . $id . ',jenis_id',
            'nama_jenis'       => 'required|max:100',
            'syarat_json'      => 'nullable|json',
            'template_files'   => 'nullable|array',
            'template_files.*' => 'file|mimes:doc,docx,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update data
        $jenisSurat->update([
            'kode'        => $request->kode,
            'nama_jenis'  => $request->nama_jenis,
            'syarat_json' => $request->syarat_json,
        ]);

        // ✅ Upload file baru jika ada
        if ($request->hasFile('template_files')) {
            // Hitung jumlah file yang sudah ada
            $existingCount = Media::where('ref_table', 'jenis_surat')
                ->where('ref_id', $id)
                ->count();

            foreach ($request->file('template_files') as $index => $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/media/jenis_surat'), $fileName);

                    Media::create([
                        'ref_table'  => 'jenis_surat',
                        'ref_id'     => $id,
                        'file_name'  => $fileName,
                        'caption'    => $file->getClientOriginalName(),
                        'mime_type'  => $file->getMimeType(),
                        'sort_order' => $existingCount + $index,
                    ]);
                }
            }
        }

        return redirect()->route('jenis-surat.index')
            ->with('success', 'Jenis surat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        // ✅ Hapus semua file media terkait
        $mediaFiles = Media::where('ref_table', 'jenis_surat')
            ->where('ref_id', $id)
            ->get();

        foreach ($mediaFiles as $media) {
            // Hapus file fisik
            $filePath = public_path('uploads/media/jenis_surat/' . $media->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus record
            $media->delete();
        }

        // Hapus jenis surat
        $jenisSurat->delete();

        return redirect()->route('jenis-surat.index')
            ->with('success', 'Jenis surat berhasil dihapus');
    }

    /**
     * ✅ Hapus file media (AJAX) - PINTING!
     */
    public function destroyMedia($jenis_id, $media_id)
    {
        // Pastikan file milik jenis_surat yang benar
        $media = Media::where('ref_table', 'jenis_surat')
            ->where('ref_id', $jenis_id)
            ->where('media_id', $media_id)
            ->firstOrFail();

        // Hapus file dari storage
        $filePath = public_path('uploads/media/jenis_surat/' . $media->file_name);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus dari database
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'File template berhasil dihapus',
        ]);
    }
}
