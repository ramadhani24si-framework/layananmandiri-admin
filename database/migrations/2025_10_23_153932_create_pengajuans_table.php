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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id('permohonan_id');                  // PK
            $table->string('nomor_permohonan')->unique(); // UNQ

            $table->unsignedBigInteger('warga_id'); // FK ke tabel warga
            $table->unsignedBigInteger('jenis_id'); // FK ke tabel jenis_surat

            $table->date('tanggal_pengajuan');
            $table->string('status');
            $table->text('catatan')->nullable();

            $table->timestamps();

            // FK -> jenis_surat
            $table->foreign('jenis_id')
                ->references('jenis_id')
                ->on('jenis_surat')
                ->cascadeOnDelete();

            // FK -> warga
            $table->foreign('warga_id')
                ->references('warga_id') // PK tabel warga
                ->on('warga')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
