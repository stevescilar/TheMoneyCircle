<?php

use App\Models\Investment;
use App\Models\InvestmentContribution;
use App\Models\Member;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->member = Member::factory()->create();
    Sanctum::actingAs($this->member);
});

// --- index ---
it('returns all investments with contributions for the member', function () {
    Investment::factory()->count(2)->for($this->member)->create();
    Investment::factory()->create(); // another member's

    $this->getJson('/api/investments')
        ->assertOk()
        ->assertJsonCount(2);
});

// --- store ---
it('creates an investment', function () {
    $this->postJson('/api/investments', [
        'type'    => 'mmf',
        'label'   => 'CIC MMF',
        'balance' => 5000,
    ])
        ->assertCreated()
        ->assertJsonPath('type', 'mmf')
        ->assertJsonPath('balance', '5000.00');
});

it('rejects an invalid investment type', function () {
    $this->postJson('/api/investments', ['type' => 'crypto', 'balance' => 0])
        ->assertUnprocessable();
});

// --- update ---
it('updates an investment', function () {
    $inv = Investment::factory()->for($this->member)->create(['balance' => 1000]);

    $this->putJson("/api/investments/{$inv->id}", ['balance' => 2000])
        ->assertOk()
        ->assertJsonPath('balance', '2000.00');
});

it('forbids updating another member\'s investment', function () {
    $inv = Investment::factory()->create();

    $this->putJson("/api/investments/{$inv->id}", ['balance' => 1])->assertForbidden();
});

// --- contribute ---
it('adds a contribution and increments the balance', function () {
    $inv = Investment::factory()->for($this->member)->create(['balance' => 0]);

    $this->postJson("/api/investments/{$inv->id}/contributions", ['amount' => 2500])
        ->assertOk()
        ->assertJsonPath('balance', '2500.00');

    expect($inv->fresh()->contributions()->count())->toBe(1);
});

// --- contributions history ---
it('returns paginated contribution history', function () {
    $inv = Investment::factory()->for($this->member)->create();
    InvestmentContribution::factory()->count(3)->for($inv)->create();

    $this->getJson("/api/investments/{$inv->id}/contributions")
        ->assertOk()
        ->assertJsonPath('total', 3);
});

it('forbids viewing another member\'s contributions', function () {
    $inv = Investment::factory()->create();

    $this->getJson("/api/investments/{$inv->id}/contributions")->assertForbidden();
});

// --- destroy ---
it('deletes an investment and its contributions', function () {
    $inv = Investment::factory()->for($this->member)->create();
    InvestmentContribution::factory()->count(2)->for($inv)->create();

    $this->deleteJson("/api/investments/{$inv->id}")->assertNoContent();

    expect(Investment::find($inv->id))->toBeNull();
    expect(InvestmentContribution::where('investment_id', $inv->id)->count())->toBe(0);
});

it('forbids deleting another member\'s investment', function () {
    $inv = Investment::factory()->create();

    $this->deleteJson("/api/investments/{$inv->id}")->assertForbidden();
});

