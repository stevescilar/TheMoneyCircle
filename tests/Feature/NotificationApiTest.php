<?php

use App\Models\Debt;
use App\Models\Member;
use App\Models\MemberNotification;
use App\Models\User;

it('creates an in-app notification when coach saves debt advice', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create();

    $debt = Debt::create([
        'member_id'       => $member->id,
        'lender'          => 'KCB Bank Loan',
        'current_balance' => 50000,
    ]);

    $response = $this->actingAs($coach)->patch(route('members.debts.notes', [$member, $debt]), [
        'coach_notes' => 'When are we clearing this loan? Let us prioritize with snowball.',
    ]);

    $response->assertRedirect();

    $notification = MemberNotification::where('member_id', $member->id)->first();
    expect($notification)->not->toBeNull();
    expect($notification->title)->toBe('Coach Advice on KCB Bank Loan');
    expect($notification->message)->toContain('When are we clearing this loan?');
    expect($notification->action_target)->toBe('debts');
    expect($notification->read_at)->toBeNull();
});

it('allows member to fetch in-app notifications and unread count via api', function () {
    $member = Member::factory()->create();

    MemberNotification::create([
        'member_id'     => $member->id,
        'type'          => 'debt_note',
        'title'         => 'Coach Advice on NCBA Loan',
        'message'       => 'Please check your payoff progress.',
        'action_target' => 'debts',
        'read_at'       => null,
    ]);

    MemberNotification::create([
        'member_id'     => $member->id,
        'type'          => 'category_note',
        'title'         => 'Coach Tip on Groceries',
        'message'       => 'Great budget management!',
        'action_target' => 'categories',
        'read_at'       => now(),
    ]);

    $response = $this->actingAs($member, 'sanctum')->getJson('/api/notifications');

    $response->assertOk();
    $response->assertJsonPath('unread_count', 1);
    $response->assertJsonCount(2, 'notifications');
});

it('allows member to mark a notification as read and mark all as read', function () {
    $member = Member::factory()->create();

    $notification = MemberNotification::create([
        'member_id'     => $member->id,
        'type'          => 'debt_note',
        'title'         => 'Coach Advice',
        'message'       => 'Test message',
        'action_target' => 'debts',
        'read_at'       => null,
    ]);

    $response = $this->actingAs($member, 'sanctum')
        ->postJson("/api/notifications/{$notification->id}/read");

    $response->assertOk();
    expect($notification->fresh()->read_at)->not->toBeNull();

    // Create another unread
    MemberNotification::create([
        'member_id'     => $member->id,
        'type'          => 'general',
        'title'         => 'Another notification',
        'message'       => 'Test message 2',
        'read_at'       => null,
    ]);

    $allResponse = $this->actingAs($member, 'sanctum')
        ->postJson('/api/notifications/read-all');

    $allResponse->assertOk();
    expect(MemberNotification::where('member_id', $member->id)->unread()->count())->toBe(0);
});

it('segregates 0-balance debts so they do not show in active payoff list in backoffice', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create(['name' => 'Zero Debt Member']);

    // Active debt
    Debt::create([
        'member_id'       => $member->id,
        'lender'          => 'Active M-Shwari Loan',
        'current_balance' => 20000,
    ]);

    // Cleared debt with 0 balance
    Debt::create([
        'member_id'       => $member->id,
        'lender'          => 'Cleared Tala Loan',
        'current_balance' => 0,
    ]);

    $response = $this->actingAs($coach)->get(route('members.show', $member));

    $response->assertOk();
    $response->assertSee('Active M-Shwari Loan');
    $response->assertSee('Cleared & Fully Paid Off (1)', false);
    $response->assertSee('Cleared Tala Loan');
    // Total debt should be 20,000, not including the 0 loan
    $response->assertSee('Ksh 20,000');
});
