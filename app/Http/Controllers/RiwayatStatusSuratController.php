<?php
namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\RiwayatStatusSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatStatusSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RiwayatStatusSurat::with(['pengajuan', 'petugas'])
            ->filter($request);

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('status', 'like', '%' . $request->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $request->search . '%')
                    ->orWhereHas('pengajuan', function ($q2) use ($request) {
                        $q2->where('nomor_permohonan', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('petugas', function ($q2) use ($request) {
                        $q2->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $riwayatStatus = $query->orderBy('waktu', 'desc')->paginate(20);

        // Data untuk filter
        $pengajuanList = Pengajuan::orderBy('created_at', 'desc')->get();
        $statusList    = [
            'draft'    => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
        ];

        return view('pages.riwayat_status_surat.index', compact('riwayatStatus', 'pengajuanList', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengajuanList = Pengajuan::orderBy('created_at', 'desc')->get();

        // AMBIL SEMUA WARGA TANPA FILTER ROLE
        $petugasList = \App\Models\Warga::orderBy('nama')->get();

        $statusList = [
            'draft'    => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
        ];

        return view('pages.riwayat_status_surat.create', compact('pengajuanList', 'petugasList', 'statusList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permohonan_id'    => 'required|exists:pengajuans,permohonan_id',
            'status'           => 'required|in:draft,diajukan,diproses,selesai,ditolak',
            'petugas_warga_id' => 'nullable|exists:warga,warga_id',
            'waktu'            => 'required|date',
            'keterangan'       => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Buat riwayat
            $riwayat = RiwayatStatusSurat::create([
                'permohonan_id'    => $request->permohonan_id,
                'status'           => $request->status,
                'petugas_warga_id' => $request->petugas_warga_id,
                'waktu'            => $request->waktu,
                'keterangan'       => $request->keterangan,
            ]);

            // Update status pengajuan
            $pengajuan = Pengajuan::find($request->permohonan_id);
            $pengajuan->update(['status' => $request->status]);

            DB::commit();

            // ✅ PERBAIKI INI: Redirect ke INDEX, bukan back()
            return redirect()->route('riwayat_status_surat.index')
                ->with('success', 'Riwayat status berhasil ditambahkan dan status pengajuan diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Tetap pakai back() kalau error
            return back()->withInput()->with('error', 'Gagal menyimpan riwayat: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $riwayat = RiwayatStatusSurat::with(['pengajuan', 'petugas'])->findOrFail($id);

        return view('pages.riwayat_status_surat.show', compact('riwayat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $riwayat       = RiwayatStatusSurat::findOrFail($id);
        $pengajuanList = Pengajuan::orderBy('created_at', 'desc')->get();

        // AMBIL SEMUA WARGA TANPA FILTER ROLE
        $petugasList = \App\Models\Warga::orderBy('nama')->get();

        $statusList = [
            'draft'    => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
        ];

        return view('pages.riwayat_status_surat.edit', compact('riwayat', 'pengajuanList', 'petugasList', 'statusList'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $riwayat = RiwayatStatusSurat::findOrFail($id);

        $request->validate([
            'permohonan_id'    => 'required|exists:pengajuans,permohonan_id',
            'status'           => 'required|in:draft,diajukan,diproses,selesai,ditolak',
            'petugas_warga_id' => 'nullable|exists:warga,warga_id',
            'waktu'            => 'required|date',
            'keterangan'       => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Update riwayat
            $riwayat->update([
                'permohonan_id'    => $request->permohonan_id,
                'status'           => $request->status,
                'petugas_warga_id' => $request->petugas_warga_id,
                'waktu'            => $request->waktu,
                'keterangan'       => $request->keterangan,
            ]);

            // Update status pengajuan jika permohonan_id sama
            if ($riwayat->permohonan_id == $request->permohonan_id) {
                $pengajuan = Pengajuan::find($request->permohonan_id);
                $pengajuan->update(['status' => $request->status]);
            }

            DB::commit();

            // ✅ PERBAIKI INI JUGA: Redirect ke INDEX
            return redirect()->route('riwayat_status_surat.index')
                ->with('success', 'Riwayat status berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui riwayat: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $riwayat = RiwayatStatusSurat::findOrFail($id);

        DB::beginTransaction();
        try {
            // Cek apakah ini riwayat terakhir untuk pengajuan ini
            $lastRiwayat = RiwayatStatusSurat::where('permohonan_id', $riwayat->permohonan_id)
                ->orderBy('waktu', 'desc')
                ->first();

            // Jika ini riwayat terakhir, update status pengajuan ke sebelumnya
            if ($lastRiwayat && $lastRiwayat->riwayat_id == $riwayat->riwayat_id) {
                $previousRiwayat = RiwayatStatusSurat::where('permohonan_id', $riwayat->permohonan_id)
                    ->where('riwayat_id', '!=', $riwayat->riwayat_id)
                    ->orderBy('waktu', 'desc')
                    ->first();

                if ($previousRiwayat) {
                    $pengajuan = Pengajuan::find($riwayat->permohonan_id);
                    $pengajuan->update(['status' => $previousRiwayat->status]);
                }
            }

            $riwayat->delete();

            DB::commit();

            return redirect()->route('riwayat-status-surat.index')
                ->with('success', 'Riwayat status berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus riwayat: ' . $e->getMessage());
        }
    }

    /**
     * Get riwayat by pengajuan (AJAX)
     */
    public function getByPengajuan($pengajuan_id)
    {
        $riwayat = RiwayatStatusSurat::with('petugas')
            ->where('permohonan_id', $pengajuan_id)
            ->orderBy('waktu', 'desc')
            ->get();

        return response()->json($riwayat);
    }

    /**
     * Create from pengajuan (quick add)
     */
    public function createFromPengajuan(Request $request, $pengajuan_id)
    {
        $request->validate([
            'status'     => 'required|in:draft,diajukan,diproses,selesai,ditolak',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $riwayat = RiwayatStatusSurat::create([
            'permohonan_id'    => $pengajuan_id,
            'status'           => $request->status,
            'petugas_warga_id' => auth()->user()->warga_id ?? null, // Otomatis dari user login
            'waktu'            => now(),
            'keterangan'       => $request->keterangan,
        ]);

        // Update status pengajuan
        $pengajuan = Pengajuan::find($pengajuan_id);
        $pengajuan->update(['status' => $request->status]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
