<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Workshop>
 */
class WorkshopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(4),
            'description' => fake()->paragraph(),
            'speaker' => fake()->name(),
            'venue' => fake()->randomElement(['Lab RPL', 'Lab RPL 2', 'Aula', 'Lab Multimedia']),
            'starts_at' => now()->addDays(fake()->numberBetween(3, 20))->setTime(9, 0),
            'ends_at' => now()->addDays(fake()->numberBetween(3, 20))->setTime(12, 0),
            'price' => fake()->numberBetween(20, 80) * 1000,
            'quota' => fake()->numberBetween(20, 50),
            'created_by' => User::factory(),
        ];
    }
}
