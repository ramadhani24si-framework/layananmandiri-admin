<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
      protected $table = 'jenis_surat';
    protected $primaryKey = 'jenis_id';
    protected $fillable = [
        'kode',
        'nama_jenis',
        'syarat_json',
    ];

}
