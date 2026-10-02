<?php

namespace Database\Factories;

use App\Models\GhgDeclaration;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<GhgDeclaration>
 */
class GhgDeclarationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => (string) Str::ulid(),
            'company_name' => fake()->company(),
            'contact_email' => fake()->safeEmail(),
            'status' => 'draft',
            'current_step' => 1,
            'data' => [],
            'evidence' => [],
        ];
    }
}
