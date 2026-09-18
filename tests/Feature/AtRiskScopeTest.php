<?php
use App\Models\Member;
use App\Models\Category;
use App\Models\Transaction;

it('includes an overspent member in atRisk', function () {
    $member = Member::factory()->create();
    $category = Category::factory()->for($member)->create(['planned_amount' => 100]);
    Transaction::factory()->for($category)->for($member)->create(['amount' => 150]);

    expect(Member::atRisk()->get()->contains($member))->toBeTrue();
});

it('excludes a member who is not overspent', function () {
    $member = Member::factory()->create();
    $category = Category::factory()->for($member)->create(['planned_amount' => 100]);
    Transaction::factory()->for($category)->for($member)->create(['amount' => 50]);

    expect(Member::atRisk()->get()->contains($member))->toBeFalse();
});

it('excludes a member with zero categories and zero transactions', function () {
    $member = Member::factory()->create();

    expect(Member::atRisk()->get()->contains($member))->toBeFalse();
});