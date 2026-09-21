<?php

use App\Models\Category;
use App\Models\Member;
use App\Models\Transaction;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->member = Member::factory()->create();
    Sanctum::actingAs($this->member);
});

// --- index ---
it('returns paginated transactions for the member', function () {
    Transaction::factory()->count(5)->for($this->member)->for(
        Category::factory()->for($this->member)->create()
    )->expense()->create();

    Transaction::factory()->create(); // another member's

    $response = $this->getJson('/api/transactions')->assertOk();

    expect($response->json('total'))->toBe(5);
});

it('returns transactions newest first', function () {
    Transaction::factory()->for($this->member)->expense()->create(['transacted_at' => now()->subDays(2)]);
    Transaction::factory()->for($this->member)->expense()->create(['transacted_at' => now()]);

    $dates = $this->getJson('/api/transactions')
        ->assertOk()
        ->json('data.*.transacted_at');

    expect($dates[0])->toBeGreaterThan($dates[1]);
});

// --- store ---
it('creates an expense transaction', function () {
    $response = $this->postJson('/api/transactions', [
        'type'   => 'expense',
        'amount' => 1500,
    ])->assertCreated();

    expect($response->json('type'))->toBe('expense')
        ->and($response->json('amount'))->toBe('1500.00');
});

it('creates a transaction linked to an owned category', function () {
    $category = Category::factory()->for($this->member)->create();

    $this->postJson('/api/transactions', [
        'type'        => 'expense',
        'amount'      => 500,
        'category_id' => $category->id,
    ])->assertCreated()->assertJsonPath('category.id', $category->id);
});

it('forbids linking to another member\'s category', function () {
    $otherCategory = Category::factory()->create();

    $this->postJson('/api/transactions', [
        'type'        => 'expense',
        'amount'      => 500,
        'category_id' => $otherCategory->id,
    ])->assertForbidden();
});

it('rejects a transaction with invalid type', function () {
    $this->postJson('/api/transactions', ['type' => 'transfer', 'amount' => 100])
        ->assertUnprocessable();
});

it('rejects a transaction with zero amount', function () {
    $this->postJson('/api/transactions', ['type' => 'expense', 'amount' => 0])
        ->assertUnprocessable();
});

