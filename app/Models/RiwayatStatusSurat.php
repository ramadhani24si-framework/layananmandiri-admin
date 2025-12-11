<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatusSurat extends Model
{
    use HasFactory;

    protected $table      = 'riwayat_status_surat';
    protected $primaryKey = 'riwayat_id';

    public $incrementing = true;
    public $timestamps   = false; // Karena pakai field 'waktu' manual

    protected $fillable = [
        'permohonan_id',
        'status',
        'petugas_warga_id',
        'waktu',
        'keterangan',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    // 🔥 RELASI KE PENGAJUAN
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'permohonan_id', 'permohonan_id');
    }

    // 🔥 RELASI KE PETUGAS (WARGA)
    public function petugas()
    {
        return $this->belongsTo(Warga::class, 'petugas_warga_id', 'warga_id');
    }

    // 🔥 ACCESSOR UNTUK FORMAT WAKTU
    public function getWaktuFormattedAttribute()
    {
        return $this->waktu->format('d/m/Y H:i');
    }

    // 🔥 SCOPE UNTUK FILTER
    public function scopeFilter($query, $request)
    {
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('permohonan_id')) {
            $query->where('permohonan_id', $request->permohonan_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu', '<=', $request->tanggal_sampai);
        }

        return $query;
    }

    // 🔥 METHOD UNTUK STATUS BADGE COLOR
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft'    => 'secondary',
            'diajukan' => 'info',
            'diproses' => 'warning',
            'selesai'  => 'success',
            'ditolak'  => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
