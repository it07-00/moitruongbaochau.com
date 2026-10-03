<?php

namespace Database\Factories;

use App\Models\EnvironmentSurvey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EnvironmentSurvey>
 */
class EnvironmentSurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'contact_email' => fake()->safeEmail(),
            'data' => [],
            'history' => [],
        ];
    }
}
