<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AiDocumentFactory extends Factory
{
    protected $model = \App\Models\AiDocument::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
}
