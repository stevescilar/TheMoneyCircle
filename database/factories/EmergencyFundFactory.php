<?php

namespace Database\Factories;

use App\Models\EmergencyFund;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmergencyFund>
 */
class EmergencyFundFactory extends Factory
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
            'target_amount' => 50000,
            'current_balance' => 0,
        ];
    }
}
