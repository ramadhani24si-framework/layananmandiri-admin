<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CreateWargaDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel jika sudah ada data
        DB::table('warga')->truncate();

        // Reset auto increment
        DB::statement('ALTER TABLE warga AUTO_INCREMENT = 1');

        // Aktifkan kembali foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $wargas = [];
        $usedEmails = [];

        // Generate 100 data warga dummy
        for ($i = 1; $i <= 100; $i++) {
            // Generate NIK/KTP 16 digit
            $nik = $this->generateNIK($i);

            // Jenis kelamin sesuai enum
            $jenisKelamin = $faker->randomElement(['Laki-laki', 'Perempuan']);

            // Agama
            $agama = $faker->randomElement(['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu']);

            // Pekerjaan (bisa null)
            $pekerjaan = $faker->randomElement([
                'PNS', 'Karyawan Swasta', 'Wiraswasta', 'Pedagang', 'Petani', 'Nelayan',
                'Guru', 'Dokter', 'Perawat', 'Supir', 'Buruh', 'Mahasiswa', null
            ]);

            // Telepon (80% punya)
            if ($faker->boolean(80)) {
                $telp = '08' . $faker->numerify('##########');
                if (strlen($telp) > 15) {
                    $telp = substr($telp, 0, 15);
                }
            } else {
                $telp = null;
            }

            // Email (70% punya)
            if ($faker->boolean(70)) {
                $firstName = strtolower(preg_replace('/[^a-z]/i', '', $faker->firstName()));
                $lastName = strtolower(preg_replace('/[^a-z]/i', '', $faker->lastName()));

                $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
                $domain = $faker->randomElement($domains);

                $email = $firstName . '.' . $lastName . rand(1, 999) . '@' . $domain;

                // Pastikan email unik
                while (in_array($email, $usedEmails)) {
                    $email = $firstName . '.' . $lastName . rand(1000, 9999) . '@' . $domain;
                }

                $usedEmails[] = $email;
            } else {
                $email = null;
            }

            $wargas[] = [
                'no_ktp' => $nik,
                'nama' => $faker->name(),
                'jenis_kelamin' => $jenisKelamin,
                'agama' => $agama,
                'pekerjaan' => $pekerjaan,
                'telp' => $telp,
                'email' => $email,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert batch setiap 25 data
            if ($i % 25 == 0) {
                DB::table('warga')->insert($wargas);
                $wargas = [];
            }
        }

        // Insert sisa data
        if (!empty($wargas)) {
            DB::table('warga')->insert($wargas);
        }

        // Hitung statistik
        $total = DB::table('warga')->count();
        $laki = DB::table('warga')->where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = DB::table('warga')->where('jenis_kelamin', 'Perempuan')->count();
        $withEmail = DB::table('warga')->whereNotNull('email')->count();
        $withTelp = DB::table('warga')->whereNotNull('telp')->count();
    }

    /**
     * Generate NIK 16 digit
     */
    private function generateNIK(int $index): string
    {
        $tanggal = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
        $bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $tahun = str_pad(rand(65, 99), 2, '0', STR_PAD_LEFT);
        $wilayah = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $urut = str_pad($index, 4, '0', STR_PAD_LEFT);

        return $tanggal . $bulan . $tahun . $wilayah . $urut;
    }
}
