<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berkas_persyaratan', function (Blueprint $table) {
            $table->id('berkas_id');
            $table->unsignedBigInteger('pengajuan_id'); // FK ke tabel pengajuans
            $table->string('nama_berkas', 200);
            $table->enum('valid', ['ya', 'tidak', 'proses'])->default('proses');
            $table->timestamps();

            // Foreign key ke tabel pengajuans (bukan permohonan_surat)
            $table->foreign('pengajuan_id')
                  ->references('pengajuan_id')
                  ->on('pengajuans') // NAMA TABEL: pengajuans
                  ->onDelete('cascade');

            // Index untuk performa query
            $table->index('pengajuan_id');
            $table->index('valid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_persyaratan');
    }
};
