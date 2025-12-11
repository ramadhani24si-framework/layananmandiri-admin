<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Faker bahasa Indonesia

        // Kosongkan tabel jika sudah ada data
        DB::table('users')->truncate();

        // Array untuk menyimpan data users
        $users = [];

        // 1. Data admin utama
        $users[] = [
            'name'              => 'Super Administrator',
            'email'             => 'admin@layananmandiri.test',
            'email_verified_at' => now(),
            'password'          => Hash::make('admin123'),
            'remember_token'    => \Illuminate\Support\Str::random(10),
            'created_at'        => now(),
            'updated_at'        => now(),
        ];

        // 2. Data petugas (15 user)
        for ($i = 1; $i <= 15; $i++) {
            $name      = $faker->name();
            $firstName = explode(' ', $name)[0];

            $users[] = [
                'name'              => $name,
                'email'             => strtolower(str_replace(' ', '.', $firstName)) . $i . '@petugas.test',
                'email_verified_at' => $faker->boolean(90) ? now() : null,
                'password'          => Hash::make('petugas123'),
                'remember_token'    => $faker->boolean(40) ? \Illuminate\Support\Str::random(10) : null,
                'created_at'        => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at'        => $faker->dateTimeBetween('-1 month', 'now'),
            ];
        }

        // 3. Data warga (84 user, total jadi 100)
        for ($i = 1; $i <= 84; $i++) {
            // Nama lengkap dengan faker
            $name = $faker->name();

            // Generate email unik dari nama
            $nameParts = explode(' ', $name);
            $firstName = strtolower($nameParts[0]);
            $lastName  = isset($nameParts[1]) ? '.' . strtolower($nameParts[1]) : '';

            // Variasi domain email
            $domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'ymail.com'];
            $domain  = $faker->randomElement($domains);

            $email = $firstName . $lastName . $faker->numberBetween(1, 999) . '@' . $domain;

            // Pastikan email unique
            $email = $this->makeEmailUnique($email, $users);

            $users[] = [
                'name'              => $name,
                'email'             => $email,
                'email_verified_at' => $faker->boolean(70) ? now() : null,
                'password'          => Hash::make('password123'),
                'remember_token'    => $faker->boolean(30) ? \Illuminate\Support\Str::random(10) : null,
                'created_at'        => $faker->dateTimeBetween('-2 years', 'now'),
                'updated_at'        => $faker->dateTimeBetween('-1 month', 'now'),
            ];
        }

        // Insert ke database
        DB::table('users')->insert($users);

    }

    /**
     * Helper function untuk membuat email unique
     */
    private function makeEmailUnique(string $email, array $existingUsers): string
    {
        $emails = array_column($existingUsers, 'email');

        // Jika email sudah ada, tambahkan angka random
        if (in_array($email, $emails)) {
            $parts = explode('@', $email);
            $email = $parts[0] . rand(1000, 9999) . '@' . $parts[1];
        }

        return $email;
    }
}
