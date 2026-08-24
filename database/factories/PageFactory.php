<?php

namespace Database\Factories;

use App\ContentStatus;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'excerpt' => fake()->sentence(14),
            'content' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(18),
        ];
    }
}
