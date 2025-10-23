<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DevUserSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'admin' => 'admin@example.com',
            'lawyer' => 'lawyer@example.com',
            'user' => 'user@example.com',
        ];

        foreach ($roles as $role => $email) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => ucfirst($role) . ' Tester', 'password' => Hash::make('password')]
            );

            // attach simple role flag if you have a column - safe no-op if column missing
            if (in_array('role', $user->getFillable())) {
                $user->role = $role;
                $user->save();
            }
        }
    }
}
