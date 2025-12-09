<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPersyaratan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'berkas_persyaratan';

    // Primary key
    protected $primaryKey = 'berkas_id';

    // Timestamps
    public $timestamps = true;

    // Kolom yang bisa diisi (UBAH KE pengajuan_id)
    protected $fillable = [
        'pengajuan_id', // DIUBAH
        'nama_berkas',
        'valid'
    ];

    // Casting tipe data
    protected $casts = [
        'valid' => 'string'
    ];

    /**
     * RELASI KE PENGAJUANS (BUKAN PERMOHONAN SURAT)
     */
    public function pengajuan() // NAMA METHOD DIUBAH
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    /**
     * AMBIL SEMUA FILE MEDIA UNTUK BERKAS INI
     * Sesuai instruksi: ref_table = 'berkas_persyaratan', ref_id = berkas_id
     */
    public function mediaFiles()
    {
        return Media::where('ref_table', 'berkas_persyaratan')
                   ->where('ref_id', $this->berkas_id)
                   ->orderBy('sort_order', 'asc')
                   ->get();
    }

    /**
     * CEK APAKAH BERKAS SUDAH ADA FILENYA
     */
    public function hasFiles()
    {
        return Media::where('ref_table', 'berkas_persyaratan')
                   ->where('ref_id', $this->berkas_id)
                   ->exists();
    }

    /**
     * JUMLAH FILE YANG DIMILIKI
     */
    public function filesCount()
    {
        return Media::where('ref_table', 'berkas_persyaratan')
                   ->where('ref_id', $this->berkas_id)
                   ->count();
    }

    /**
     * GET STATUS BADGE COLOR (untuk tampilan)
     */
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'ya' => 'success',
            'tidak' => 'danger',
            'proses' => 'warning'
        ];

        return $statuses[$this->valid] ?? 'secondary';
    }

    /**
     * GET STATUS TEXT (untuk tampilan)
     */
    public function getStatusTextAttribute()
    {
        $texts = [
            'ya' => 'Valid',
            'tidak' => 'Tidak Valid',
            'proses' => 'Proses Verifikasi'
        ];

        return $texts[$this->valid] ?? 'Unknown';
    }

    /**
     * HAPUS SEMUA FILE MEDIA TERKAIT
     */
    public function deleteMediaFiles()
    {
        $files = $this->mediaFiles();

        foreach ($files as $file) {
            // Hapus file fisik
            $filePath = public_path('uploads/media/berkas_persyaratan/' . $file->file_name);
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
                    public_path('uploads/media/berkas_persyaratan'),
                    $fileName
                );

                // Simpan ke tabel media
                $media = Media::create([
                    'ref_table' => 'berkas_persyaratan',
                    'ref_id' => $this->berkas_id,
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
}
