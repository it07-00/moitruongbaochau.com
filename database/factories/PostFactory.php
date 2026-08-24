<?php

namespace Database\Factories;

use App\ContentStatus;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(7);

        return [
            'post_category_id' => PostCategory::factory(),
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'excerpt' => fake()->sentence(18),
            'content' => '<p>'.fake()->paragraphs(5, true).'</p>',
            'status' => ContentStatus::Published,
            'is_featured' => false,
            'published_at' => now(),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(18),
        ];
    }
}
