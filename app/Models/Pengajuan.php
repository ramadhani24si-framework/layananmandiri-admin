<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuans';
    protected $primaryKey = 'permohonan_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nomor_permohonan',
        'warga_id',
        'jenis_id',
        'tanggal_pengajuan',
        'status',
        'catatan',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_DIAJUKAN = 'diajukan';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';

    // 🔥 ACCESSOR UNTUK STATUS TEXT
    public function getStatusTextAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // 🔥 ACCESSOR UNTUK STATUS BADGE COLOR
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft' => 'secondary',
            'diajukan' => 'info',
            'diproses' => 'warning',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    // 🔥 RELASI KE WARGA
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // 🔥 RELASI KE JENIS SURAT
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_id', 'jenis_id');
    }

    // 🔥 RELASI KE BERKAS PERSYARATAN (nanti)
    public function berkasPersyaratan()
    {
        return $this->hasMany(BerkasPersyaratan::class, 'permohonan_id', 'permohonan_id');
    }

    // 🔥 RELASI KE RIWAYAT STATUS (nanti)
    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatusSurat::class, 'permohonan_id', 'permohonan_id');
    }

    // ✅ TAMBAHKAN RELASI KE MEDIA (untuk lampiran)
    public function lampiranFiles()
    {
        return $this->hasMany(Media::class, 'ref_id', 'permohonan_id')
            ->where('ref_table', 'pengajuans')
            ->orderBy('sort_order');
    }

    /* -----------------------
       SCOPE FILTER
    ------------------------*/
    public function scopeFilter(Builder $query, $request, array $columns): Builder
    {
        foreach ($columns as $col) {
            if ($request->filled($col)) {
                $query->where($col, $request->input($col));
            }
        }
        return $query;
    }

    /* -----------------------
       SCOPE SEARCH
    ------------------------*/
    public function scopeSearch(Builder $query, $request, array $columns): Builder
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'LIKE', "%$search%");
                }
            });
        }
        return $query;
    }

    // 🔥 SCOPE UNTUK SEARCH DENGAN RELASI
    public function scopeSearchWithRelations($query, $keyword)
    {
        return $query->where('nomor_permohonan', 'like', '%' . $keyword . '%')
            ->orWhereHas('warga', function($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('no_ktp', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('jenisSurat', function($q) use ($keyword) {
                $q->where('nama_jenis', 'like', '%' . $keyword . '%')
                  ->orWhere('kode', 'like', '%' . $keyword . '%');
            });
    }

    // 🔥 SCOPE UNTUK STATUS TERTENTU
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // 🔥 METHOD UNTUK GENERATE NOMOR PERMOHONAN
    public static function generateNomorPermohonan()
    {
        $date = now()->format('Ymd');
        $lastNumber = static::where('nomor_permohonan', 'like', "SURAT-$date-%")
            ->orderBy('permohonan_id', 'desc')
            ->first();

        if ($lastNumber) {
            $lastNumber = explode('-', $lastNumber->nomor_permohonan);
            $sequence = intval(end($lastNumber)) + 1;
        } else {
            $sequence = 1;
        }

        return "SURAT-$date-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get jumlah lampiran
     */
    public function getLampiranCountAttribute()
    {
        return $this->lampiranFiles()->count();
    }
}
