<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateJenisSuratDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel jika sudah ada data
        DB::table('jenis_surat')->truncate();

        // Reset auto increment
        DB::statement('ALTER TABLE jenis_surat AUTO_INCREMENT = 1');

        // Aktifkan kembali foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data jenis surat dummy
        $jenisSurats = [
            [
                'kode' => 'SKTM',
                'nama_jenis' => 'Surat Keterangan Tidak Mampu',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Surat pengantar RT/RW',
                    'Foto 3x4'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKD',
                'nama_jenis' => 'Surat Keterangan Domisili',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Bukti alamat'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKK',
                'nama_jenis' => 'Surat Keterangan Kelahiran',
                'syarat_json' => json_encode([
                    'Fotokopi KTP orang tua',
                    'Fotokopi KK',
                    'Surat keterangan bidan'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKM',
                'nama_jenis' => 'Surat Keterangan Kematian',
                'syarat_json' => json_encode([
                    'Fotokopi KTP almarhum',
                    'Fotokopi KK',
                    'Surat keterangan dokter'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKBM',
                'nama_jenis' => 'Surat Keterangan Belum Menikah',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Surat pengantar RT/RW'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKP',
                'nama_jenis' => 'Surat Keterangan Penghasilan',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Slip gaji'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKU',
                'nama_jenis' => 'Surat Keterangan Usaha',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Foto usaha'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SKCK',
                'nama_jenis' => 'Surat Keterangan Catatan Kepolisian',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi KK',
                    'Foto 4x6'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SPIK',
                'nama_jenis' => 'Surat Pengantar Izin Keramaian',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Surat permohonan',
                    'Denah lokasi'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SPIKB',
                'nama_jenis' => 'Surat Pengantar Izin Kerja Bangunan',
                'syarat_json' => json_encode([
                    'Fotokopi KTP',
                    'Fotokopi sertifikat',
                    'Gambar bangunan'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert ke database
        DB::table('jenis_surat')->insert($jenisSurats);

        // Hitung total
        $total = count($jenisSurats);
    }
}
