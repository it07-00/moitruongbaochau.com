<?php

namespace Database\Factories;

use App\ContactStatus;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '09'.fake()->numerify('########'),
            'topic' => fake()->sentence(5),
            'message' => fake()->paragraph(),
            'status' => ContactStatus::New,
        ];
    }
}
