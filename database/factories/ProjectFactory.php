<?php

namespace Database\Factories;

use App\ContentStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'category' => fake()->randomElement(['giay-phep', 'dtm', 'khi-nha-kinh', 'quan-trac']),
            'client' => fake()->company(),
            'location' => fake()->city(),
            'summary' => fake()->sentence(18),
            'content' => '<p>'.fake()->paragraphs(4, true).'</p>',
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'completed_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(18),
        ];
    }
}
