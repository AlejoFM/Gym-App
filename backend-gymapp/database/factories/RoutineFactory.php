<?php

namespace Database\Factories;

use App\Enums\RoutineDaysEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Routine>
 */
class RoutineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "train_day" => RoutineDaysEnums::cases()[rand(0,6)]->value,
            "user_id" => rand(1,2),
        ];
    }
}
