<?php

use App\Models\Category;
use App\Models\Member;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->member = Member::factory()->create();
    Sanctum::actingAs($this->member);
});

$shapeKeys = ['id', 'name', 'type', 'planned_amount', 'spent', 'remaining', 'percent_complete', 'period_start', 'period_end', 'coach_notes'];

it('returns shaped categories for the member', function () use ($shapeKeys) {
    Category::factory()->count(2)->for($this->member)->create();

    $response = $this->getJson('/api/categories')->assertOk();

    foreach ($shapeKeys as $key) {
        expect($response->json('0'))->toHaveKey($key);
    }
});

it('creates a category with the correct shape', function () use ($shapeKeys) {
    $data = $this->postJson('/api/categories', [
        'name'           => 'Groceries',
        'planned_amount' => 15000,
        'type'           => 'expense',
        'period_start'   => '2026-10-01',
        'period_end'     => '2026-10-31',
    ])->assertCreated()->json();

    foreach ($shapeKeys as $key) {
        expect($data)->toHaveKey($key);
    }

    expect($data['name'])->toBe('Groceries')
        ->and((float) $data['planned_amount'])->toBe(15000.0)
        ->and($data['type'])->toBe('expense');
});

it('updates a category successfully', function () use ($shapeKeys) {
    $category = Category::factory()->for($this->member)->create([
        'name'           => 'Old Category',
        'planned_amount' => 10000,
        'type'           => 'expense',
    ]);

    $data = $this->putJson("/api/categories/{$category->id}", [
        'name'           => 'Updated Groceries',
        'planned_amount' => 20000,
    ])->assertOk()->json();

    foreach ($shapeKeys as $key) {
        expect($data)->toHaveKey($key);
    }

    expect($data['name'])->toBe('Updated Groceries')
        ->and((float) $data['planned_amount'])->toBe(20000.0);
});

it('forbids updating another member\'s category', function () {
    $category = Category::factory()->create();

    $this->putJson("/api/categories/{$category->id}", [
        'name' => 'Hacked Category',
    ])->assertForbidden();
});

it('deletes a category', function () {
    $category = Category::factory()->for($this->member)->create();

    $this->deleteJson("/api/categories/{$category->id}")->assertNoContent();

    expect(Category::find($category->id))->toBeNull();
});

it('forbids deleting another member\'s category', function () {
    $category = Category::factory()->create();

    $this->deleteJson("/api/categories/{$category->id}")->assertForbidden();
});
