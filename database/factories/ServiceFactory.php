<?php

namespace Database\Factories;

use App\ContentStatus;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(5);

        return [
            'service_category_id' => ServiceCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 99999),
            'short_description' => fake()->sentence(18),
            'content' => '<p>'.fake()->paragraphs(4, true).'</p>',
            'status' => ContentStatus::Published,
            'is_featured' => false,
            'published_at' => now(),
            'meta_title' => $name,
            'meta_description' => fake()->sentence(18),
        ];
    }
}
