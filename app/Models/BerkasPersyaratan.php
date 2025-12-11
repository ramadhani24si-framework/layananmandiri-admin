<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'berkas_persyaratan';
    protected $primaryKey = 'berkas_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'permohonan_id',
        'nama_berkas',
        'valid',
    ];

    // 🔥 RELASI KE PENGAJUAN
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'permohonan_id', 'permohonan_id');
    }

    // 🔥 RELASI KE MEDIA (MULTIPLE FILES)
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'berkas_id')
            ->where('ref_table', 'berkas_persyaratan')
            ->orderBy('sort_order');
    }

    // 🔥 ACCESSOR UNTUK STATUS BADGE
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu' => 'bg-warning',
            'valid' => 'bg-success',
            'tidak_valid' => 'bg-danger',
        ];

        return $badges[$this->valid] ?? 'bg-secondary';
    }

    // 🔥 ACCESSOR UNTUK STATUS TEXT
    public function getStatusTextAttribute()
    {
        $texts = [
            'menunggu' => 'Menunggu',
            'valid' => 'Valid',
            'tidak_valid' => 'Tidak Valid',
        ];

        return $texts[$this->valid] ?? $this->valid;
    }

    // 🔥 Cek apakah punya file
    public function hasFiles()
    {
        return $this->media()->exists();
    }

    // 🔥 Jumlah file
    public function getFilesCountAttribute()
    {
        return $this->media()->count();
    }
}
