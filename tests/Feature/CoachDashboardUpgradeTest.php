<?php

use App\Models\Category;
use App\Models\Member;
use App\Models\MonthlyReflection;
use App\Models\SavingsGoal;
use App\Models\Transaction;
use App\Models\User;

it('displays coach dashboard with kpi metrics and members list', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create(['name' => 'Alice Wambui', 'email' => 'alice@example.com']);

    $rent = Category::factory()->for($member)->create(['planned_amount' => 10000]);
    Transaction::factory()->for($rent)->for($member)->expense()->create(['amount' => 12000]);

    SavingsGoal::create([
        'member_id'     => $member->id,
        'goal_name'     => 'Emergency Fund',
        'target_amount' => 50000,
        'saved_amount'  => 25000,
    ]);

    MonthlyReflection::create([
        'member_id'       => $member->id,
        'period_month'    => now()->startOfMonth(),
        'financial_score' => 7,
        'wins'            => 'Saved 5k',
        'challenges'      => 'Unexpected repair',
        'coach_notes'     => null,
    ]);

    $response = $this->actingAs($coach)->get(route('coach.dashboard'));

    $response->assertOk();
    $response->assertSee('Coach Command Center');
    $response->assertSee('Alice Wambui');
    $response->assertSee('At Risk (Overspent)');
    $response->assertSee('Needs Notes');
});

it('can filter members by search query', function () {
    $coach = User::factory()->create();
    $member1 = Member::factory()->for($coach, 'coach')->create(['name' => 'John Doe', 'email' => 'john@test.com']);
    $member2 = Member::factory()->for($coach, 'coach')->create(['name' => 'Jane Smith', 'email' => 'jane@test.com']);

    $response = $this->actingAs($coach)->get(route('coach.dashboard', ['search' => 'Jane']));

    $response->assertOk();
    $response->assertSee('Jane Smith');
    $response->assertDontSee('John Doe');
});

it('can filter members who need reflection notes', function () {
    $coach = User::factory()->create();
    $member1 = Member::factory()->for($coach, 'coach')->create(['name' => 'Needs Notes User']);
    $member2 = Member::factory()->for($coach, 'coach')->create(['name' => 'Already Reviewed User']);

    MonthlyReflection::create([
        'member_id'       => $member1->id,
        'period_month'    => now()->startOfMonth(),
        'financial_score' => 6,
        'coach_notes'     => null,
    ]);

    MonthlyReflection::create([
        'member_id'       => $member2->id,
        'period_month'    => now()->startOfMonth(),
        'financial_score' => 9,
        'coach_notes'     => 'Great job!',
    ]);

    $response = $this->actingAs($coach)->get(route('coach.dashboard', ['filter' => 'needs_notes']));

    $response->assertOk();
    $response->assertSee('Needs Notes User');
    $response->assertDontSee('Already Reviewed User');
});

