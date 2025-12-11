<?php
// database/migrations/xxxx_create_media_table.php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('ref_table', 50); // jenis_surat, permohonan_surat, warga
            $table->unsignedBigInteger('ref_id'); // ID dari tabel referensi
            $table->string('file_name');
            $table->string('caption')->nullable();
            $table->string('mime_type', 100);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('media');
    }
};



