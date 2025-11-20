<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreatePengajuanDummy extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 50) as $index) {
            DB::table('pengajuans')->insert([  // DENGAN 's'
                'nama_pemohon' => $faker->name,
                'jenis_surat_id' => $faker->numberBetween(1, 7), // sesuaikan dengan jumlah jenis_surat
                'keterangan' => $faker->optional(0.4)->sentence(8),
                'status' => $faker->randomElement(['Menunggu', 'Diproses', 'Selesai']),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
