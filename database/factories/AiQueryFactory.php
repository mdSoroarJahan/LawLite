<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AiQueryFactory extends Factory
{
    protected $model = \App\Models\AiQuery::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'query' => $this->faker->sentence(),
        ];
    }
}
