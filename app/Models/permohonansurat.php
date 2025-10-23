<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan_surat extends Model
{
    protected $table = 'permohonan_surat';
    protected $primaryKey = 'permohonan_id';

    protected $fillable = [
        'nomor_permohonan',
        'pemohon_warga_id',
        'jenis_id',
        'tanggal_pengajuan',
        'status',
        'catatan',
    ];

    /**
     * Relasi ke model Warga (setiap permohonan dimiliki oleh satu warga)
     */
     public function warga()
{
    return $this->belongsTo(Warga::class, 'pemohon_warga_id', 'id');
}


    /**
     * Relasi ke model Jenis (setiap permohonan memiliki satu jenis surat)
     */
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'jenis_id');
    }
}
