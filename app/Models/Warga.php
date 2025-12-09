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
}
