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
        Schema::create('riwayat_status_surat', function (Blueprint $table) {
            $table->id('riwayat_id');
            $table->unsignedBigInteger('pengajuan_id'); // DIUBAH: permohonan_id -> pengajuan_id
            $table->string('status', 50); // menunggu, diproses, selesai, ditolak
            $table->unsignedBigInteger('petugas_warga_id'); // FK ke warga
            $table->timestamp('waktu')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign keys (UBAH: permohonan_surat -> pengajuans)
            $table->foreign('pengajuan_id')
                  ->references('pengajuan_id')
                  ->on('pengajuans') // DIUBAH
                  ->onDelete('cascade');

            $table->foreign('petugas_warga_id')
                  ->references('warga_id')
                  ->on('warga')
                  ->onDelete('cascade');

            // Indexes (UBAH nama kolom)
            $table->index('pengajuan_id'); // DIUBAH
            $table->index('status');
            $table->index('petugas_warga_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_surat');
    }
};
