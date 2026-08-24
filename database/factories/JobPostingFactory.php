<?php

namespace Database\Factories;

use App\ContentStatus;
use App\Models\JobPosting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JobPosting>
 */
class JobPostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->jobTitle();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'location' => 'TP. Hồ Chí Minh',
            'employment_type' => 'Toàn thời gian',
            'summary' => fake()->sentence(18),
            'content' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'requirements' => '<ul><li>'.fake()->sentence().'</li></ul>',
            'benefits' => '<ul><li>'.fake()->sentence().'</li></ul>',
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'expires_at' => now()->addMonth(),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(18),
        ];
    }
}
