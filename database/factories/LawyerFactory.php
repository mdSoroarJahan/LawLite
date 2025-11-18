<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LawyerFactory extends Factory
{
    protected $model = \App\Models\Lawyer::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'expertise' => $this->faker->word(),
            'bio' => $this->faker->paragraph(),
            'license_number' => null,
            'verification_status' => 'pending',
            'documents' => null,
            'latitude' => null,
            'longitude' => null,
            'city' => null,
        ];
    }
}
