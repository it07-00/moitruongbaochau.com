<?php

namespace Database\Factories;

use App\Models\PageView;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PageView>
 */
class PageViewFactory extends Factory
{
    protected $model = PageView::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_key' => 'page:'.fake()->slug(2),
            'page_type' => fake()->randomElement(['landing', 'page', 'service', 'project', 'post', 'job_posting']),
            'page_title' => fake()->sentence(4),
            'page_url' => '/'.fake()->slug(2),
            'referrer' => null,
            'ip_address' => fake()->ipv4(),
            'session_id' => fake()->uuid(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
