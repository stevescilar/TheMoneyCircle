<?php

namespace Database\Factories;

use App\Models\Investment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Investment>
 */
class InvestmentFactory extends Factory
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
            'type' => 'mmf',
            'label' => fake()->words(2, true),
            'balance' => 0,
        ];
    }
}
