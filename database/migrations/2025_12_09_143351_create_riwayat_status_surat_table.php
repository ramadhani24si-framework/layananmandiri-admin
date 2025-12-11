<?php
// database/migrations/xxxx_create_riwayat_status_surat_table.php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('riwayat_status_surat', function (Blueprint $table) {
            $table->id('riwayat_id');
            $table->unsignedBigInteger('permohonan_id'); // FK ke permohonan_surat
            $table->string('status'); // status saat itu
            $table->unsignedBigInteger('petugas_warga_id')->nullable(); // FK ke warga
            $table->timestamp('waktu')->useCurrent();
            $table->text('keterangan')->nullable();


            // Foreign keys
            $table->foreign('permohonan_id')
                  ->references('permohonan_id')
                  ->on('pengajuans')
                  ->onDelete('cascade');


            $table->foreign('petugas_warga_id')
                  ->references('warga_id')
                  ->on('warga')
                  ->onDelete('set null');
        });
    }


    public function down()
    {
        Schema::dropIfExists('riwayat_status_surat');
    }
};




