<?php
use App\Models\Member;
use App\Models\Category;
use App\Models\Transaction;

it('Calculates total budgeted as the sum of all categories', function () {
    $member = Member::factory()->create();

    Category::factory()->for($member)->create(['planned_amount' => 13000]);
    Category::factory()->for($member)->create(['planned_amount' => 5000]);
    Category::factory()->for($member)->create(['planned_amount' => 1000]);

    expect($member->totalBudgeted())->toBe(19000.0);
});

it ('calculates percent budget spent across multiple categories', function () {
    $member = Member::factory()->create();

    $rent = Category::factory()->for($member)->create(['planned_amount' => 13000]);
    $sacco = Category::factory()->for($member)->create(['planned_amount' => 5000]);

    Transaction::factory()->for($rent)->for($member)->expense()->create(['amount' => 5000]);
    Transaction::factory()->for($sacco)->for($member)->expense()->create(['amount' => 5000]);

    expect($member->percentBudgetSpent())->toBe(55.6);
});

it('return zero for a member with no categories', function () {
    $member = Member::factory()->create();

    expect($member->totalBudgeted())->toBe(0.0);
    expect($member->percentBudgetSpent())->toBe(0.0);
    expect($member->isOverSpent())->toBeFalse();

});

it('detects when a member is overspent', function () {
    $member = Member::factory()->create();

    $rent = Category::factory()->for($member)->create(['planned_amount' => 5000]);
    

    Transaction::factory()->for($rent)->for($member)->expense()->create(['amount' => 6000]);
    

    expect($member->isOverSpent())->toBeTrue();
});