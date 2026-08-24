<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uploaded_by' => User::factory(),
            'name' => fake()->words(3, true),
            'file_name' => fake()->uuid().'.webp',
            'disk' => 'public',
            'path' => 'media/'.fake()->unique()->uuid().'.webp',
            'mime_type' => 'image/webp',
            'size' => fake()->numberBetween(1024, 2_000_000),
            'alt_text' => fake()->sentence(6),
        ];
    }
}
