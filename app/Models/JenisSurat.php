<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';
    protected $primaryKey = 'jenis_id';

    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'kode',
        'nama_jenis',
        'syarat_json',
    ];

    protected $casts = [
        'syarat_json' => 'array',
    ];

    // === FILTER ===
    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }

        return $query;
    }

    // === SEARCH ===
    public function scopeSearch(Builder $query, $request, array $columns): Builder
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $request->search . '%');
                }
            });
        }

        return $query;
    }

    // 🔥 RELASI KE PENGAJUANS (TABEL: pengajuans)
    public function pengajuans()
    {
        // Asumsi:
        // - Tabel: pengajuans
        // - Model: Pengajuan
        // - Foreign key di pengajuans: jenis_id
        return $this->hasMany(Pengajuan::class, 'jenis_id', 'jenis_id');
    }

    // 🔥 RELASI KE MEDIA (untuk template files)
    public function mediaFiles()
    {
        return $this->hasMany(Media::class, 'ref_id', 'jenis_id')
            ->where('ref_table', 'jenis_surat')
            ->orderBy('sort_order');
    }

    // ✅ TAMBAHKAN METHOD INI UNTUK HANDLE SYARAT_JSON
    /**
     * Get syarat as formatted string for form input
     */
    public function getSyaratForFormAttribute()
    {
        if (empty($this->syarat_json)) {
            return '';
        }

        if (is_array($this->syarat_json)) {
            return json_encode($this->syarat_json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        // Try to decode if it's JSON string
        $decoded = json_decode($this->syarat_json);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return $this->syarat_json;
    }

    /**
     * Get syarat count
     */
    public function getSyaratCountAttribute()
    {
        if (empty($this->syarat_json)) {
            return 0;
        }

        if (is_array($this->syarat_json)) {
            return count($this->syarat_json);
        }

        // Try to decode if it's JSON string
        $decoded = json_decode($this->syarat_json, true);
        if (is_array($decoded)) {
            return count($decoded);
        }

        return 0;
    }
}
