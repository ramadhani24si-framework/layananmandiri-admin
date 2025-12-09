<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'media';

    // Primary key
    protected $primaryKey = 'media_id';

    // Non-aktifkan timestamps otomatis (karena kita pakai created_at manual)
    public $timestamps = false;

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_name',
        'caption',
        'mime_type',
        'sort_order',
        'uploaded_by',
        'file_size'
    ];

    // Casting tipe data
    protected $casts = [
        'ref_id' => 'integer',
        'sort_order' => 'integer',
        'uploaded_by' => 'integer',
        'created_at' => 'datetime'
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
     * Scope untuk tabel tertentu
     */
    public function scopeByTable($query, $refTable)
    {
        return $query->where('ref_table', $refTable);
    }

    /**
     * Get file URL untuk diakses publik
     */
    public function getFileUrlAttribute()
    {
        // Sesuaikan dengan path folder Anda
        $baseUrl = config('app.url', url('/'));
        return $baseUrl . '/uploads/media/' . $this->ref_table . '/' . $this->file_name;
    }

    /**
     * Get file path fisik di server
     */
    public function getFilePathAttribute()
    {
        return public_path('uploads/media/' . $this->ref_table . '/' . $this->file_name);
    }

    /**
     * Cek apakah file adalah gambar
     */
    public function getIsImageAttribute()
    {
        return strpos($this->mime_type, 'image/') === 0;
    }

    /**
     * Cek apakah file adalah PDF
     */
    public function getIsPdfAttribute()
    {
        return $this->mime_type === 'application/pdf';
    }

    /**
     * Cek apakah file adalah dokumen office
     */
    public function getIsDocumentAttribute()
    {
        $officeMimes = [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        return in_array($this->mime_type, $officeMimes);
    }
}
