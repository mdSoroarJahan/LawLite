<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lawyer;
use App\Models\User;

class LawyerSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('role', 'lawyer')->first();
        if ($user) {
            Lawyer::create([
                'user_id' => $user->id,
                'expertise' => 'Family Law, Civil',
                'bio' => 'Experienced lawyer practicing family and civil law in Dhaka.',
                'license_number' => 'LIC12345',
                'verification_status' => 'verified',
                'documents' => json_encode(['nid' => 'docs/nid.pdf']),
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'city' => 'Dhaka'
            ]);
        }
    }
}
