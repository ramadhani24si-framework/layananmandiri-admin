<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';
    protected $primaryKey = 'warga_id';

    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    // 🔥 ACCESSOR UNTUK JENIS KELAMIN (Text)
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // 🔥 ACCESSOR UNTUK JENIS KELAMIN FULL (Migration: ['Laki-laki', 'Perempuan'])
    public function getJenisKelaminFullAttribute()
    {
        return $this->jenis_kelamin == 'Laki-laki' ? 'Laki-laki' :
               ($this->jenis_kelamin == 'Perempuan' ? 'Perempuan' :
               ($this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'));
    }

    // 🔥 RELASI KE PENGAJUAN
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'warga_id', 'warga_id');
    }

    // 🔥 CEK APAKAH WARGA MEMILIKI PENGAJUAN
    public function getMemilikiPengajuanAttribute()
    {
        return $this->pengajuans()->count() > 0;
    }

    /* -----------------------
       FILTER
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
       SEARCH
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

    // 🔥 SCOPE UNTUK SEARCH SIMPLE
    public function scopeSearchSimple($query, $keyword)
    {
        return $query->where('no_ktp', 'like', '%' . $keyword . '%')
                     ->orWhere('nama', 'like', '%' . $keyword . '%')
                     ->orWhere('telp', 'like', '%' . $keyword . '%')
                     ->orWhere('email', 'like', '%' . $keyword . '%')
                     ->orWhere('pekerjaan', 'like', '%' . $keyword . '%');
    }
}
