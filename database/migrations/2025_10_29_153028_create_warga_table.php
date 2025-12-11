<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id('warga_id'); // Primary Key
            $table->string('no_ktp')->unique(); // Nomor KTP (unik)
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->string('pekerjaan')->nullable();
            $table->string('telp', 15)->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }



    /**
     * Undo migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};





