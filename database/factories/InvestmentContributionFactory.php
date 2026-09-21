<?php

namespace Database\Factories;

use App\Models\InvestmentContribution;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvestmentContribution>
 */
class InvestmentContributionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'investment_id'  => \App\Models\Investment::factory(),
            'amount'         => fake()->randomFloat(2, 100, 10000),
            'contributed_at' => now(),
        ];
    }
}

