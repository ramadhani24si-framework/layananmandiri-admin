<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', // role dihapus
    ];

    protected $hidden = [
        'password',
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
