<?php

use App\Models\EmergencyFund;
use App\Models\Member;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->member = Member::factory()->create();
    Sanctum::actingAs($this->member);
});

// --- show ---
it('returns zeros when no emergency fund exists', function () {
    $this->getJson('/api/emergency-fund')
        ->assertOk()
        ->assertJson([
            'target_amount'   => 0.0,
            'current_balance' => 0.0,
            'percent_funded'  => 0.0,
        ]);
});

it('returns fund data when fund exists', function () {
    EmergencyFund::factory()->for($this->member)->create([
        'target_amount'   => 50000,
        'current_balance' => 25000,
    ]);

    $data = $this->getJson('/api/emergency-fund')->assertOk()->json();

    expect((float) $data['target_amount'])->toBe(50000.0)
        ->and((float) $data['current_balance'])->toBe(25000.0)
        ->and((float) $data['percent_funded'])->toBe(50.0);
});

// --- store (create) ---
it('creates an emergency fund and returns 201', function () {
    $data = $this->postJson('/api/emergency-fund', ['target_amount' => 60000])
        ->assertCreated()
        ->json();

    expect((float) $data['target_amount'])->toBe(60000.0)
        ->and((float) $data['current_balance'])->toBe(0.0);
});

// --- store (update existing) ---
it('updates an existing emergency fund target and returns 200', function () {
    EmergencyFund::factory()->for($this->member)->create(['target_amount' => 50000]);

    $data = $this->postJson('/api/emergency-fund', ['target_amount' => 75000])
        ->assertOk()
        ->json();

    expect((float) $data['target_amount'])->toBe(75000.0);
});

// --- update ---
it('updates the current balance via PUT', function () {
    EmergencyFund::factory()->for($this->member)->create([
        'target_amount'   => 50000,
        'current_balance' => 0,
    ]);

    $data = $this->putJson('/api/emergency-fund', ['current_balance' => 20000])
        ->assertOk()
        ->json();

    expect((float) $data['current_balance'])->toBe(20000.0)
        ->and((float) $data['percent_funded'])->toBe(40.0);
});

it('returns 404 on PUT when no fund exists', function () {
    $this->putJson('/api/emergency-fund', ['current_balance' => 1000])->assertNotFound();
});

// --- contribute ---
it('adds a contribution and increments the balance', function () {
    EmergencyFund::factory()->for($this->member)->create([
        'target_amount'   => 50000,
        'current_balance' => 10000,
    ]);

    $data = $this->postJson('/api/emergency-fund/contribute', ['amount' => 5000])
        ->assertOk()
        ->json();

    expect((float) $data['current_balance'])->toBe(15000.0)
        ->and((float) $data['percent_funded'])->toBe(30.0);
});

it('returns 404 on contribute when no fund exists', function () {
    $this->postJson('/api/emergency-fund/contribute', ['amount' => 100])->assertNotFound();
});

