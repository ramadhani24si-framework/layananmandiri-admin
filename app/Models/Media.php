<?php
// app/Models/Media.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $table      = 'media';
    protected $primaryKey = 'media_id';

    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_name',
        'caption',
        'mime_type',
        'sort_order',
    ];

    protected $casts = [
        'ref_id'     => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope untuk mengambil media berdasarkan referensi
     */
    public function scopeByReference($query, $refTable, $refId)
    {
        return $query->where('ref_table', $refTable)
            ->where('ref_id', $refId)
            ->orderBy('sort_order', 'asc');
    }

    /**
     * Get URL untuk mengakses file
     */


    /**
     * Cek apakah file ada di storage
     */
    public function fileExists()
    {
        return Storage::disk('public')->exists('media/jenis_surat/' . $this->file_name);
    }

    /**
     * Get icon berdasarkan tipe file
     */
    public function getIcon()
    {
        $mime = $this->mime_type ?? '';

        // Cek gambar
        if (strpos($mime, 'image/') === 0) {
            return 'fas fa-image';
        }

        // Cek PDF
        if ($mime === 'application/pdf') {
            return 'fas fa-file-pdf';
        }

        // Cek Word
        if (strpos($mime, 'word') !== false ||
            $mime === 'application/msword' ||
            $mime === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            return 'fas fa-file-word';
        }

        // Cek Excel
        if (strpos($mime, 'excel') !== false ||
            strpos($mime, 'sheet') !== false ||
            $mime === 'application/vnd.ms-excel' ||
            $mime === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return 'fas fa-file-excel';
        }

        // Default
        return 'fas fa-file';
    }

    public function getFileUrl()
{
    // Tentukan path berdasarkan ref_table
    if ($this->ref_table === 'jenis_surat') {
        $path = 'media/jenis_surat/' . $this->file_name;
    } elseif ($this->ref_table === 'pengajuans') {
        $path = 'media/pengajuan/' . $this->file_name;
    } elseif ($this->ref_table === 'berkas_persyaratan') {
        $path = 'media/berkas_persyaratan/' . $this->ref_id . '/' . $this->file_name;
    } else {
        $path = 'media/' . $this->file_name;
    }

    return Storage::disk('public')->url($path);
}
}
