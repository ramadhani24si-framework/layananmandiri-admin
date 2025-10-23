<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengajuan_id';

    protected $fillable = [
        'nama_pemohon',
        'jenis_surat',
        'keterangan',
        'status',
    ];
}
