<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = \App\Models\Notification::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'type' => 'info',
            'message' => $this->faker->sentence(),
            'read_status' => false,
        ];
    }
}
