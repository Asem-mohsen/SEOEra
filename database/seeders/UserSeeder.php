<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+20123456789',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Assem Mohsen',
            'email' => 'asemmohsen911@gmail.com',
            'phone' => '+201152992719',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::factory(10)->create();
    }
} 