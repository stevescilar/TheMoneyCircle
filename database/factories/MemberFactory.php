<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coach_id' => \App\Models\User::factory(), //here i nested the user factory to create a coach for the member
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'join_date' => now(),
            'status' =>'active',
            'password' => 'password'
        ];
    }
}
