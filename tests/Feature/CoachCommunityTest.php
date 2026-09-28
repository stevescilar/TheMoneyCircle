<?php

use App\Models\Announcement;
use App\Models\LiveSession;
use App\Models\ResourceItem;
use App\Models\User;

it('allows coach to view announcements dashboard', function () {
    $coach = User::factory()->create();

    $announcement = Announcement::create([
        'coach_id' => $coach->id,
        'title' => 'Test Community Announcement',
        'body' => 'This is a test announcement broadcast for circle members.',
        'pinned' => true,
        'action_label' => 'Explore Live Sessions',
    ]);

    $response = $this->actingAs($coach)->get(route('coach.announcements.index'));

    $response->assertOk();
    $response->assertSee('Community Announcements');
    $response->assertSee('Test Community Announcement');
    $response->assertSee('Pinned to Top');
    $response->assertSee('Explore Live Sessions');
});

it('allows coach to create a new announcement and broadcast to members', function () {
    $coach = User::factory()->create();

    $payload = [
        'title' => '🚀 Q4 Savings Sprint is Live!',
        'body' => 'Save Ksh 2,000 every week towards your emergency fund target.',
        'pinned' => '1',
        'action_label' => 'Go to Challenges',
        'action_url' => 'https://themoneycircle.app/challenges',
    ];

    $response = $this->actingAs($coach)->post(route('coach.announcements.store'), $payload);

    $response->assertRedirect();
    $this->assertDatabaseHas('announcements', [
        'title' => '🚀 Q4 Savings Sprint is Live!',
        'pinned' => true,
        'action_label' => 'Go to Challenges',
    ]);

    // Verify API serves it to mobile app
    $apiResponse = $this->getJson('/api/community/announcements');
    $apiResponse->assertOk();
    $apiResponse->assertJsonFragment([
        'title' => '🚀 Q4 Savings Sprint is Live!',
        'action_label' => 'Go to Challenges',
    ]);
});

it('allows coach to toggle pinned status of an announcement', function () {
    $coach = User::factory()->create();

    $announcement = Announcement::create([
        'coach_id' => $coach->id,
        'title' => 'Toggle Pin Test',
        'body' => 'Testing pin toggle functionality.',
        'pinned' => false,
    ]);

    $response = $this->actingAs($coach)->patch(route('coach.announcements.pin', $announcement));

    $response->assertRedirect();
    expect($announcement->fresh()->pinned)->toBeTrue();

    // Toggle back
    $this->actingAs($coach)->patch(route('coach.announcements.pin', $announcement));
    expect($announcement->fresh()->pinned)->toBeFalse();
});

it('allows coach to delete an announcement', function () {
    $coach = User::factory()->create();

    $announcement = Announcement::create([
        'coach_id' => $coach->id,
        'title' => 'Announcement to Delete',
        'body' => 'Will be deleted.',
    ]);

    $response = $this->actingAs($coach)->delete(route('coach.announcements.destroy', $announcement));

    $response->assertRedirect();
    $this->assertDatabaseMissing('announcements', [
        'id' => $announcement->id,
    ]);
});

it('allows coach to view live sessions and schedule a new session', function () {
    $coach = User::factory()->create();

    $response = $this->actingAs($coach)->get(route('coach.live-sessions.index'));
    $response->assertOk();
    $response->assertSee('Live Group Coaching');

    $sessionTime = now()->addDays(3)->setTime(19, 30);

    $payload = [
        'title' => 'Advanced Wealth Building in MMFs',
        'description' => 'Comparing yields and inflation resistance.',
        'speaker_name' => 'Expert Coach',
        'session_time' => $sessionTime->format('Y-m-d H:i:s'),
        'duration_minutes' => 60,
        'meeting_url' => 'https://meet.google.com/test-session',
    ];

    $storeResponse = $this->actingAs($coach)->post(route('coach.live-sessions.store'), $payload);
    $storeResponse->assertRedirect();

    $this->assertDatabaseHas('live_sessions', [
        'title' => 'Advanced Wealth Building in MMFs',
        'speaker_name' => 'Expert Coach',
        'meeting_url' => 'https://meet.google.com/test-session',
    ]);

    // Verify API serves it to mobile app
    $apiResponse = $this->getJson('/api/community/live-sessions');
    $apiResponse->assertOk();
    $apiResponse->assertJsonFragment([
        'title' => 'Advanced Wealth Building in MMFs',
    ]);
});

it('allows coach to cancel and delete a live session', function () {
    $coach = User::factory()->create();

    $session = LiveSession::create([
        'coach_id' => $coach->id,
        'title' => 'Session to Cancel',
        'speaker_name' => 'Expert Coach',
        'session_time' => now()->addDays(4),
        'duration_minutes' => 45,
    ]);

    $response = $this->actingAs($coach)->delete(route('coach.live-sessions.destroy', $session));

    $response->assertRedirect();
    $this->assertDatabaseMissing('live_sessions', [
        'id' => $session->id,
    ]);
});

it('allows coach to view resources and add a new resource', function () {
    $coach = User::factory()->create();

    $response = $this->actingAs($coach)->get(route('coach.resources.index'));
    $response->assertOk();
    $response->assertSee('Resource Library');

    $payload = [
        'title' => 'Emergency Fund Sizing Calculator',
        'description' => 'Calculate your safety buffer based on monthly fixed costs.',
        'category' => 'templates',
        'file_url' => 'https://microsilsystem.co.ke/resources/emergency-calculator.xlsx',
        'author_or_source' => 'The Money Circle Team',
    ];

    $storeResponse = $this->actingAs($coach)->post(route('coach.resources.store'), $payload);
    $storeResponse->assertRedirect();

    $this->assertDatabaseHas('resources', [
        'title' => 'Emergency Fund Sizing Calculator',
        'category' => 'templates',
    ]);

    // Test category filter
    $filterResponse = $this->actingAs($coach)->get(route('coach.resources.index', ['category' => 'templates']));
    $filterResponse->assertOk();
    $filterResponse->assertSee('Emergency Fund Sizing Calculator');

    // Verify API serves it to mobile app
    $apiResponse = $this->getJson('/api/community/resources?category=templates');
    $apiResponse->assertOk();
    $apiResponse->assertJsonFragment([
        'title' => 'Emergency Fund Sizing Calculator',
    ]);
});

