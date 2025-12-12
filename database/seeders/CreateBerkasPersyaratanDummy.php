<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateBerkasPersyaratanDummy extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('berkas_persyaratan')->truncate();
        DB::statement('ALTER TABLE berkas_persyaratan AUTO_INCREMENT = 1');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $pengajuans = DB::table('pengajuans')->get();
        if ($pengajuans->isEmpty()) {
            return;
        }

        $daftarBerkas = [
            'KTP',
            'KK',
            'Surat Pengantar RT/RW',
            'Foto 3x4',
            'Foto 4x6',
            'Surat Keterangan Kerja',
            'Slip Gaji',
            'Akta Kelahiran',
            'Akta Nikah',
            'Ijazah',
            'Surat Keterangan Dokter',
            'Surat Keterangan Bidan',
            'Sertifikat Tanah',
            'BPKB',
            'STNK',
            'NPWP',
            'BPJS',
            'Surat Tidak Mampu',
            'Surat Pernyataan',
            'Denah Lokasi',
            'Foto Tempat Usaha',
            'Izin Usaha',
            'SKCK',
            'Pas Foto',
            'Buku Nikah',
            'Surat Domisili',
            'Surat Penghasilan',
            'Bukti Pajak',
            'Surat Kuasa',
            'Surat Kematian'
        ];

        $berkasData = [];

        foreach ($pengajuans as $pengajuan) {
            $jumlahBerkas = $faker->numberBetween(3, 7);
            $selectedBerkas = $faker->randomElements($daftarBerkas, $jumlahBerkas);

            $statusValid = 'menunggu';
            if ($pengajuan->status === 'diproses') {
                $statusValid = $faker->randomElement(['menunggu', 'valid', 'tidak_valid']);
            } elseif ($pengajuan->status === 'selesai') {
                $statusValid = 'valid';
            } elseif ($pengajuan->status === 'ditolak') {
                $statusValid = $faker->randomElement(['valid', 'tidak_valid']);
            }

            foreach ($selectedBerkas as $namaBerkas) {
                $finalStatusValid = $statusValid;
                if ($pengajuan->status !== 'menunggu' && $statusValid !== 'valid') {
                    $rand = $faker->numberBetween(1, 10);
                    if ($rand <= 2) {
                        $finalStatusValid = 'tidak_valid';
                    } elseif ($rand <= 7) {
                        $finalStatusValid = 'valid';
                    } else {
                        $finalStatusValid = 'menunggu';
                    }
                }

                $berkasData[] = [
                    'permohonan_id' => $pengajuan->permohonan_id,
                    'nama_berkas' => $namaBerkas,
                    'valid' => $finalStatusValid,
                    'created_at' => $pengajuan->created_at,
                    'updated_at' => now(),
                ];

                if (count($berkasData) >= 50) {
                    DB::table('berkas_persyaratan')->insert($berkasData);
                    $berkasData = [];
                }
            }
        }

        if (!empty($berkasData)) {
            DB::table('berkas_persyaratan')->insert($berkasData);
        }
    }
}
