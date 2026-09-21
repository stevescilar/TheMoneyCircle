<?php

use App\Models\Member;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('authenticates a member via api and returns token and member info', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create([
        'email' => 'api_member@example.com',
        'password' => 'secret123',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'api_member@example.com',
        'password' => 'secret123',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['token', 'member'])
        ->assertJsonPath('member.email', 'api_member@example.com');
});

it('rejects invalid credentials on api login', function () {
    $coach = User::factory()->create();
    Member::factory()->for($coach, 'coach')->create([
        'email' => 'api_member2@example.com',
        'password' => 'secret123',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'api_member2@example.com',
        'password' => 'wrong-pass',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('returns authenticated member on GET /api/me', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create();

    Sanctum::actingAs($member);

    $response = $this->getJson('/api/me');

    $response->assertOk()
        ->assertJsonPath('id', $member->id)
        ->assertJsonPath('email', $member->email);
});

it('logs out member and revokes token', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create();

    $token = $member->createToken('test-token')->plainTextToken;

    $response = $this->withToken($token)->postJson('/api/logout');

    $response->assertOk()
        ->assertJson(['message' => 'Logged out']);

    expect($member->tokens()->count())->toBe(0);
});

