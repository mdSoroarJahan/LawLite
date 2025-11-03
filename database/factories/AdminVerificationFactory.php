<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminVerificationFactory extends Factory
{
    protected $model = \App\Models\AdminVerification::class;

    public function definition()
    {
        return [
            'lawyer_id' => 1,
            'verified_by' => 1,
            'date_verified' => now(),
        ];
    }
}
