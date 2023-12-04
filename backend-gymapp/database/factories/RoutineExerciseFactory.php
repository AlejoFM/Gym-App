<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class routineExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "routine_id" => rand(1,4),
            "exercise_id" => rand(1,8),
            "volume_id" => rand(1,4),
            "user_id" => rand(1,4),
        ];


    }
}
