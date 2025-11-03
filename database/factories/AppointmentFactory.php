<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = \App\Models\Appointment::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'lawyer_id' => 1,
            'scheduled_at' => now()->addDays(1),
        ];
    }
}
