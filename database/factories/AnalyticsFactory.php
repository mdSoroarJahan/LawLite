<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnalyticsFactory extends Factory
{
    protected $model = \App\Models\Analytics::class;

    public function definition()
    {
        return [
            'lawyer_id' => 1,
            'views' => 0,
        ];
    }
}
