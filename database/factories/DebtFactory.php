<?php

namespace Database\Factories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Debt>
 */
class DebtFactory extends Factory
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
            'lender' => fake()->company(),
            'current_balance' => fake()->randomFloat(2, 1000, 100000),
            'target_payoff_date' => now()->addMonths(6),
        ];
    }
}
