<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id('jenis_id'); // Primary Key
            $table->string('kode')->unique(); // Kode unik untuk jenis surat
            $table->string('nama_jenis'); // Nama jenis surat
            $table->json('syarat_json')->nullable(); // Syarat dalam format JSON
            $table->timestamps(); // created_at & updated_at
        });
    }


    /**
     * Undo migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};



