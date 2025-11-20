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

        // Data admin default
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@desa.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operator Desa',
                'email' => 'operator@desa.id',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Tambah beberapa user dummy
        foreach (range(1, 8) as $index) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => $faker->randomElement(['user', 'operator']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);
    }
}
