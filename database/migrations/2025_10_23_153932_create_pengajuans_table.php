<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id('pengajuan_id');
            $table->string('nama_pemohon');
            $table->string('jenis_surat');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
