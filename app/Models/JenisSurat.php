<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    // Nama tabel
    protected $table = 'jenis_surat';

    // Primary key
    protected $primaryKey = 'jenis_id';

    // Kolom yang boleh diisi (fillable)
    protected $fillable = [
    'kode',
    'nama_jenis',
    'syarat_json',
];
}
