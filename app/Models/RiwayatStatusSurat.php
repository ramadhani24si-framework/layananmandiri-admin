<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatusSurat extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'riwayat_status_surat';

    // Primary key
    protected $primaryKey = 'riwayat_id';

    // Timestamps
    public $timestamps = true;

    // Kolom yang bisa diisi (UBAH: permohonan_id -> pengajuan_id)
    protected $fillable = [
        'pengajuan_id', // DIUBAH
        'status',
        'petugas_warga_id',
        'waktu',
        'keterangan'
    ];

    // Casting tipe data
    protected $casts = [
        'waktu' => 'datetime'
    ];

    /**
     * RELASI KE PENGAJUAN (BUKAN PERMOHONAN SURAT)
     */
    public function pengajuan() // DIUBAH NAMA METHOD
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id'); // DIUBAH
    }

    /**
     * RELASI KE PETUGAS (WARGA)
     */
    public function petugas()
    {
        return $this->belongsTo(Warga::class, 'petugas_warga_id', 'warga_id');
    }

    /**
     * AMBIL SEMUA FILE MEDIA UNTUK RIWAYAT INI
     * Sesuai instruksi: ref_table = 'riwayat_status_surat', ref_id = riwayat_id
     */
    public function mediaFiles()
    {
        return Media::where('ref_table', 'riwayat_status_surat')
                   ->where('ref_id', $this->riwayat_id)
                   ->orderBy('sort_order', 'asc')
                   ->get();
    }

    /**
     * CEK APAKAH RIWAYAT SUDAH ADA FILENYA
     */
    public function hasFiles()
    {
        return Media::where('ref_table', 'riwayat_status_surat')
                   ->where('ref_id', $this->riwayat_id)
                   ->exists();
    }

    /**
     * JUMLAH FILE YANG DIMILIKI
     */
    public function filesCount()
    {
        return Media::where('ref_table', 'riwayat_status_surat')
                   ->where('ref_id', $this->riwayat_id)
                   ->count();
    }

    /**
     * GET STATUS BADGE COLOR (untuk tampilan)
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'menunggu' => 'secondary',
            'diproses' => 'warning',
            'selesai' => 'success',
            'ditolak' => 'danger'
        ];

        return $statuses[$this->status] ?? 'dark';
    }

    /**
     * GET STATUS TEXT (untuk tampilan)
     */
    public function getStatusTextAttribute()
    {
        $texts = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return $texts[$this->status] ?? $this->status;
    }

    /**
     * GET WAKTU FORMATTED
     */
    public function getWaktuFormattedAttribute()
    {
        return $this->waktu ? $this->waktu->format('d/m/Y H:i') : '-';
    }

    /**
     * HAPUS SEMUA FILE MEDIA TERKAIT
     */
    public function deleteMediaFiles()
    {
        $files = $this->mediaFiles();

        foreach ($files as $file) {
            // Hapus file fisik
            $filePath = public_path('uploads/media/riwayat_status_surat/' . $file->file_name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus record media
            $file->delete();
        }

        return true;
    }

    /**
     * UPLOAD FILES KE MEDIA
     */
    public function uploadFiles($files, $caption = '')
    {
        $uploaded = [];

        foreach ($files as $index => $file) {
            if ($file->isValid()) {
                // Generate nama file unik
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Simpan file ke folder
                $file->move(
                    public_path('uploads/media/riwayat_status_surat'),
                    $fileName
                );

                // Simpan ke tabel media
                $media = Media::create([
                    'ref_table' => 'riwayat_status_surat',
                    'ref_id' => $this->riwayat_id,
                    'file_name' => $fileName,
                    'caption' => $caption ?: $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'sort_order' => $index,
                ]);

                $uploaded[] = $media;
            }
        }

        return $uploaded;
    }

    /**
     * BUAT RIWAYAT BARU DARI PENGAJUAN (UBAH: permohonan -> pengajuan)
     */
    public static function createFromPengajuan($pengajuan_id, $status, $petugas_id, $keterangan = null, $files = null) // DIUBAH
    {
        $riwayat = self::create([
            'pengajuan_id' => $pengajuan_id, // DIUBAH
            'status' => $status,
            'petugas_warga_id' => $petugas_id,
            'keterangan' => $keterangan,
            'waktu' => now(),
        ]);

        // Upload files jika ada
        if ($files) {
            $riwayat->uploadFiles($files, "Bukti status {$status}");
        }

        return $riwayat;
    }
}
