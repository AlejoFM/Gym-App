<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'membership_type' => $this->faker->word,
            'membership_cost' => $this->faker->randomNumber(2),
            'payment_date' => $this->faker->dateTime(),
            'expiry_date' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
            'user_id' => rand(1,4),
        ];
    }
}
