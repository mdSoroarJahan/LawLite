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
            'city' => $this->faker->city(),
            'education' => [
                'LLB (Honours) from ' . $this->faker->randomElement(['University of Dhaka', 'North South University', 'BRAC University']),
                'LLM from ' . $this->faker->randomElement(['University of London', 'Dhaka University'])
            ],
            'experience' => [
                $this->faker->numberBetween(1, 15) . ' years of practice in High Court',
                'Associate at ' . $this->faker->company()
            ],
            'languages' => $this->faker->randomElements(['English', 'Bengali', 'Hindi'], 2),
        ];
    }
}
