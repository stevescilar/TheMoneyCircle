<?php

use App\Models\Member;
use App\Models\SavingsGoal;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->member = Member::factory()->create();
    Sanctum::actingAs($this->member);
});

$shapeKeys = ['id', 'goal_name', 'target_amount', 'saved_amount', 'remaining', 'percent_complete'];

// --- index ---
it('returns shaped savings goals for the member', function () use ($shapeKeys) {
    SavingsGoal::factory()->count(2)->for($this->member)->create();

    $response = $this->getJson('/api/savings-goals')->assertOk();

    foreach ($shapeKeys as $key) {
        expect($response->json('0'))->toHaveKey($key);
    }
});

// --- store ---
it('creates a savings goal with the correct shape', function () use ($shapeKeys) {
    $data = $this->postJson('/api/savings-goals', [
        'goal_name'     => 'Emergency Laptop',
        'target_amount' => 80000,
    ])->assertCreated()->json();

    foreach ($shapeKeys as $key) {
        expect($data)->toHaveKey($key);
    }

    expect($data['goal_name'])->toBe('Emergency Laptop')
        ->and((float) $data['remaining'])->toBe(80000.0)
        ->and((float) $data['percent_complete'])->toBe(0.0);
});

it('rejects store with missing goal_name', function () {
    $this->postJson('/api/savings-goals', ['target_amount' => 1000])->assertUnprocessable();
});

// --- contribute ---
it('contributes to a savings goal and updates saved_amount', function () {
    $goal = SavingsGoal::factory()->for($this->member)->create([
        'target_amount' => 20000,
        'saved_amount'  => 0,
    ]);

    $data = $this->postJson("/api/savings-goals/{$goal->id}/contribute", ['amount' => 5000])
        ->assertOk()
        ->json();

    expect((float) $data['saved_amount'])->toBe(5000.0)
        ->and((float) $data['remaining'])->toBe(15000.0)
        ->and((float) $data['percent_complete'])->toBe(25.0);
});

it('forbids contributing to another member\'s goal', function () {
    $goal = SavingsGoal::factory()->create();

    $this->postJson("/api/savings-goals/{$goal->id}/contribute", ['amount' => 100])->assertForbidden();
});

// --- destroy ---
it('deletes a savings goal', function () {
    $goal = SavingsGoal::factory()->for($this->member)->create();

    $this->deleteJson("/api/savings-goals/{$goal->id}")->assertNoContent();

    expect(SavingsGoal::find($goal->id))->toBeNull();
});

it('forbids deleting another member\'s savings goal', function () {
    $goal = SavingsGoal::factory()->create();

    $this->deleteJson("/api/savings-goals/{$goal->id}")->assertForbidden();
});

