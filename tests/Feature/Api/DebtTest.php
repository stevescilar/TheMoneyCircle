<?php

use App\Models\Debt;
use App\Models\Member;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->member = Member::factory()->create();
    Sanctum::actingAs($this->member);
});

// --- index ---
it('returns all debts for the authenticated member', function () {
    Debt::factory()->count(2)->for($this->member)->create();
    Debt::factory()->create(); // another member's debt

    $this->getJson('/api/debts')
        ->assertOk()
        ->assertJsonCount(2);
});

// --- store ---
it('creates a debt for the authenticated member', function () {
    $this->postJson('/api/debts', [
        'lender'          => 'KCB Bank',
        'current_balance' => 50000,
        'target_payoff_date' => now()->addYear()->toDateString(),
    ])
        ->assertCreated()
        ->assertJsonPath('lender', 'KCB Bank')
        ->assertJsonPath('current_balance', '50000.00');

    expect($this->member->debts()->count())->toBe(1);
});

it('rejects a debt with missing required fields', function () {
    $this->postJson('/api/debts', [])->assertUnprocessable();
});

// --- update ---
it('updates a debt owned by the member', function () {
    $debt = Debt::factory()->for($this->member)->create(['current_balance' => 30000]);

    $this->putJson("/api/debts/{$debt->id}", ['current_balance' => 25000])
        ->assertOk()
        ->assertJsonPath('current_balance', '25000.00');
});

it('forbids updating another member\'s debt', function () {
    $debt = Debt::factory()->create();

    $this->putJson("/api/debts/{$debt->id}", ['current_balance' => 1])->assertForbidden();
});

// --- record payment ---
it('records a payment and decrements the balance', function () {
    $debt = Debt::factory()->for($this->member)->create(['current_balance' => 10000]);

    $this->postJson("/api/debts/{$debt->id}/payments", ['amount' => 1000])
        ->assertOk()
        ->assertJsonPath('current_balance', '9000.00');

    expect($debt->fresh()->payments()->count())->toBe(1);
});

it('clamps debt balance to zero when overpaying', function () {
    $debt = Debt::factory()->for($this->member)->create(['current_balance' => 500]);

    $this->postJson("/api/debts/{$debt->id}/payments", ['amount' => 1000])
        ->assertOk()
        ->assertJsonPath('current_balance', '0.00');
});

// --- destroy ---
it('deletes a debt and its payments', function () {
    $debt = Debt::factory()->for($this->member)->create();
    $debt->payments()->create(['amount' => 100, 'paid_at' => now()]);

    $this->deleteJson("/api/debts/{$debt->id}")->assertNoContent();

    expect(Debt::find($debt->id))->toBeNull();
});

it('forbids deleting another member\'s debt', function () {
    $debt = Debt::factory()->create();

    $this->deleteJson("/api/debts/{$debt->id}")->assertForbidden();
});

