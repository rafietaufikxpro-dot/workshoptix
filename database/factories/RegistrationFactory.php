<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'workshop_id' => Workshop::factory(),
            'amount' => fake()->numberBetween(20, 80) * 1000,
            'payment_status' => 'pending',
        ];
    }
}
