<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateJenisSuratDummy extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $jenisSurat = [
            [
                'kode' => 'SKTM',
                'nama_jenis' => 'Surat Keterangan Tidak Mampu',
                'syarat_json' => json_encode(['KTP', 'KK', 'Surat Pengantar RT'])
            ],
            [
                'kode' => 'SKU',
                'nama_jenis' => 'Surat Keterangan Usaha',
                'syarat_json' => json_encode(['KTP', 'KK', 'Surat Pengantar RT', 'Foto Usaha'])
            ],
            [
                'kode' => 'SKK',
                'nama_jenis' => 'Surat Keterangan Kelahiran',
                'syarat_json' => json_encode(['KTP Orang Tua', 'KK', 'Surat Keterangan Lahir dari Bidan/Rumah Sakit'])
            ],
            [
                'kode' => 'SKM',
                'nama_jenis' => 'Surat Keterangan Kematian',
                'syarat_json' => json_encode(['KTP Alm', 'KK', 'Surat Keterangan Kematian dari Rumah Sakit'])
            ],
            [
                'kode' => 'SP',
                'nama_jenis' => 'Surat Pengantar',
                'syarat_json' => json_encode(['KTP', 'KK'])
            ],
            [
                'kode' => 'SKKP',
                'nama_jenis' => 'Surat Keterangan Kehilangan',
                'syarat_json' => json_encode(['KTP', 'KK', 'Surat Pengantar RT', 'Laporan Polisi'])
            ],
            [
                'kode' => 'SKBM',
                'nama_jenis' => 'Surat Keterangan Belum Menikah',
                'syarat_json' => json_encode(['KTP', 'KK', 'Surat Pengantar RT'])
            ]
        ];

        foreach ($jenisSurat as $jenis) {
            DB::table('jenis_surat')->insert([
                'kode' => $jenis['kode'],
                'nama_jenis' => $jenis['nama_jenis'],
                'syarat_json' => $jenis['syarat_json'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
