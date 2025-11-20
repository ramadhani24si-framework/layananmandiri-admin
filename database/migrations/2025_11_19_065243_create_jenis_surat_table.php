<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('jenis_surat', function (Blueprint $table) {

        // Primary Key
        $table->increments('jenis_id');

        // Unique kode surat
        $table->string('kode', 50)->unique();

        // Nama jenis surat
        $table->string('nama_jenis', 150);

        // Syarat dalam format JSON
        $table->json('syarat_json')->nullable();

        // timestamps
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
