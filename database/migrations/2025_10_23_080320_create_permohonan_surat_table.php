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
    Schema::create('permohonan_surat', function (Blueprint $table) {
        $table->increments('permohonan_id'); // Primary Key
        $table->string('nomor_permohonan', 50)->unique(); // Unique
        $table->unsignedInteger('pemohon_warga_id'); // FK ke tabel warga
        $table->unsignedInteger('jenis_id'); // FK ke tabel jenis
        $table->date('tanggal_pengajuan');
        $table->enum('status', ['Diajukan', 'Diproses', 'Selesai', 'Ditolak'])->default('Diajukan');
        $table->text('catatan')->nullable();
        $table->timestamps();

        // Relasi ke tabel warga
        $table->foreign('pemohon_warga_id')
              ->references('warga_id')
              ->on('warga')
              ->onDelete('cascade');

        // Relasi ke tabel jenis
        $table->foreign('jenis_id')
              ->references('jenis_id')
              ->on('jenis')
              ->onDelete('restrict');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_surat');
    }
};
