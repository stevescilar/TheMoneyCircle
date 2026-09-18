<?php

namespace Database\Factories;

use App\Models\MonthlyReflection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MonthlyReflection>
 */
class MonthlyReflectionFactory extends Factory
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
            'financial_score' => fake()->numberBetween(1, 10),
            'wins' => fake()->sentence(),
            'challenges' => fake()->sentence(),
            'period_month' => now()->startOfMonth(),
        ];
    }
}
