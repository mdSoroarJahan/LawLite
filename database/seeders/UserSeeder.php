<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lawlite.test',
            'phone' => '01234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'language_preference' => 'en',
        ]);

        User::create([
            'name' => 'Adv Rahman',
            'email' => 'rahman@lawlite.test',
            'phone' => '01700000001',
            'password' => Hash::make('password'),
            'role' => 'lawyer',
            'language_preference' => 'bn',
        ]);

        User::create([
            'name' => 'User One',
            'email' => 'user1@lawlite.test',
            'phone' => '01700000002',
            'password' => Hash::make('password'),
            'role' => 'user',
            'language_preference' => 'bn',
        ]);
    }
}
