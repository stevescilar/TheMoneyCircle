<?php

namespace Database\Factories;

use App\Models\SavingsGoal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SavingsGoal>
 */
class SavingsGoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => \App\Models\Member::factory(),
            'goal_name' => fake()->words(2, true),
            'target_amount' => 20000,
            'saved_amount' => 0,
        ];
    }
}
