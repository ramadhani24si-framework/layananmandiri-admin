<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            // Primary key
            $table->id('media_id');

            // Referensi ke tabel lain (tanpa foreign key)
            $table->string('ref_table', 50); // contoh: 'jenis_surat', 'permohonan_surat'
            $table->unsignedBigInteger('ref_id'); // ID dari tabel referensi

            // Informasi file
            $table->string('file_name', 255); // Nama file fisik
            $table->string('caption', 200)->nullable(); // Keterangan file
            $table->string('mime_type', 100)->nullable(); // Tipe file: image/jpeg, application/pdf
            $table->integer('sort_order')->default(0); // Urutan tampilan

            // Timestamps
            $table->timestamp('created_at')->useCurrent();

            // Index untuk pencarian cepat
            $table->index(['ref_table', 'ref_id'], 'idx_ref_table_ref_id');
            $table->index('ref_table', 'idx_ref_table');
            $table->index('ref_id', 'idx_ref_id');

            // Jika mau tambah untuk tracking
            $table->unsignedBigInteger('uploaded_by')->nullable(); // user_id yang upload
            $table->string('file_size', 20)->nullable(); // Ukuran file dalam bytes
        });

        // Jika ingin partisi (opsional untuk performa)
        // Schema::table('media', function (Blueprint $table) {
        //     $table->index(['ref_table', 'ref_id', 'created_at']);
        // });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
};
