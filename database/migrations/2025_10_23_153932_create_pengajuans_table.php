<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id('pengajuan_id');
            $table->string('nama_pemohon');
            $table->unsignedInteger('jenis_id');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->timestamps();

            // // TAMBAH FOREIGN KEY DI SINI
            // $table->foreign('jenis_surat_id')
            //     ->references('jenis_id')
            //     ->on('jenis_surat')
            //     ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
