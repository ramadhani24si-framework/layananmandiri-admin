<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateWargaDummy extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 30) as $index) {
            DB::table('warga')->insert([
                'no_ktp' => $faker->unique()->numerify('32##############'),
                'nama' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['L', 'P']), // SINGKATAN
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan' => $faker->randomElement([
                    'Wiraswasta', 'PNS', 'Karyawan Swasta', 'Petani', 'Nelayan',
                    'Guru', 'Dokter', 'Perawat', 'Pedagang', 'Buruh', 'Mahasiswa'
                ]),
                'telp' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
