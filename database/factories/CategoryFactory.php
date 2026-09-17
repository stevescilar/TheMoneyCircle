<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => \App\Models\Member::factory(), //here i nested the member factory to create a member for the category
            'name' => 'Rent',
            'planned_amount' => 13000,
            'type' => 'expense',
            'period_start' => now()->startOfMonth(),
            'period_end' => now()->endOfMonth(),
        ];
    }
}
