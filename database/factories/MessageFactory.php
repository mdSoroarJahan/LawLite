<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = \App\Models\Message::class;

    public function definition()
    {
        return [
            'sender_id' => 1,
            'receiver_id' => 2,
            'content' => $this->faker->sentence(),
            'is_read' => false,
        ];
    }
}
