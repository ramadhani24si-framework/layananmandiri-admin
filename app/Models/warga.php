<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class warga extends Model
{
    //
    protected $table = 'warga';
    protected $primarykey = 'warga_id';
    protected $fillable = [
         'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];
}
