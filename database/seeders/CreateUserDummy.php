<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CreateUserDummy extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $users = [];

        // Generate 100 user dummy
        for ($i = 0; $i < 100; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);

        $this->command->info('Berhasil menambahkan 100 data user dummy!');
    }
}
