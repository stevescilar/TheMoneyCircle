<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => \App\Models\Member::factory(), //here i nested the member factory to create a member for the transaction
            'category_id' => \App\Models\Category::factory(), //here i nested the category factory to create a category for the transaction
            'type' => 'expense',
            'amount' => fake()->randomFloat(2, 100, 10000),
            'description' => fake()->sentence(3),
            'transacted_at' => now(),
        ];
    }

    public function expense(): static
    {
        return $this->state([
            'type' => 'expense',
        ]);
    }

    public function income(): static
    {
        return $this->state([
            'type' => 'income',
        ]);
    }
}
