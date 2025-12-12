<?php
// database/migrations/xxxx_create_berkas_persyaratan_table.php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('berkas_persyaratan', function (Blueprint $table) {
            $table->id('berkas_id');
            $table->unsignedBigInteger('permohonan_id'); // FK ke permohonan_surat
            $table->string('nama_berkas'); // Contoh: "KTP", "KK", dll
            $table->enum('valid', ['menunggu', 'valid', 'tidak_valid'])->default('menunggu');
            $table->timestamps();


            // Foreign key
            $table->foreign('permohonan_id')
                  ->references('permohonan_id')
                  ->on('pengajuans')
                  ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('berkas_persyaratan');
    }
};



