<?php

use App\Models\CommunityAnswer;
use App\Models\CommunityQuestion;
use App\Models\CommunityWin;
use App\Models\Member;
use App\Models\User;

it('allows coach to view Q&A Desk index with questions and metrics', function () {
    $coach = User::factory()->create(['name' => 'Expert Coach']);

    $q1 = CommunityQuestion::create([
        'author_name' => 'Dennis K.',
        'category' => 'investing',
        'title' => 'Should I pay Sacco loan or MMF first?',
        'body' => 'Need advice on prioritizing debt vs investments.',
        'is_resolved' => false,
        'views_count' => 10,
    ]);

    $response = $this->actingAs($coach)->get(route('coach.questions.index'));

    $response->assertOk();
    $response->assertSee('Coach Q&A Desk', false);
    $response->assertSee('Should I pay Sacco loan or MMF first?');
    $response->assertSee('Dennis K.');
    $response->assertSee('Awaiting Coach Advice');
});

it('allows coach to filter questions by category and status', function () {
    $coach = User::factory()->create();

    $q1 = CommunityQuestion::create([
        'author_name' => 'Alice M.',
        'category' => 'saving',
        'title' => 'Emergency fund target question',
        'body' => 'How much to save?',
        'is_resolved' => false,
    ]);

    $q2 = CommunityQuestion::create([
        'author_name' => 'Bob K.',
        'category' => 'debt',
        'title' => 'Credit card interest question',
        'body' => 'How to negotiate APR?',
        'is_resolved' => true,
    ]);

    // Filter by category
    $resCat = $this->actingAs($coach)->get(route('coach.questions.index', ['category' => 'saving']));
    $resCat->assertOk();
    $resCat->assertSee('Emergency fund target question');
    $resCat->assertDontSee('Credit card interest question');

    // Filter by status: resolved
    $resResolved = $this->actingAs($coach)->get(route('coach.questions.index', ['filter' => 'resolved']));
    $resResolved->assertOk();
    $resResolved->assertSee('Credit card interest question');
    $resResolved->assertDontSee('Emergency fund target question');
});

it('allows coach to view question discussion thread', function () {
    $coach = User::factory()->create(['name' => 'Expert Coach']);

    $q = CommunityQuestion::create([
        'author_name' => 'Mercy A.',
        'category' => 'budgeting',
        'title' => 'Freelance income budgeting system',
        'body' => 'Some months high, other months low.',
        'is_resolved' => false,
    ]);

    CommunityAnswer::create([
        'question_id' => $q->id,
        'author_name' => 'John D.',
        'author_role' => 'member',
        'body' => 'I use a holding account.',
        'is_coach_verified' => false,
    ]);

    $response = $this->actingAs($coach)->get(route('coach.questions.show', $q));

    $response->assertOk();
    $response->assertSee('Freelance income budgeting system');
    $response->assertSee('I use a holding account.');
    $response->assertSee('Post Verified Coach Answer');
});

it('allows coach to post an official verified answer and badges correctly in API', function () {
    $coach = User::factory()->create(['name' => 'Expert Coach']);

    $q = CommunityQuestion::create([
        'author_name' => 'Faith W.',
        'category' => 'debt',
        'title' => 'Snowball vs Avalanche comparison',
        'body' => 'Which one should I start with?',
        'is_resolved' => false,
    ]);

    $answerText = 'Start with the Snowball method to secure early psychological wins and build momentum!';

    $response = $this->actingAs($coach)->post(route('coach.questions.answers.store', $q), [
        'body' => $answerText,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('community_answers', [
        'question_id' => $q->id,
        'author_name' => 'Expert Coach',
        'author_role' => 'coach',
        'is_coach_verified' => true,
        'body' => $answerText,
    ]);

    // Check API endpoint for question detail (returns verified coach answer)
    $apiRes = $this->getJson("/api/community/questions/{$q->id}");
    $apiRes->assertOk();
    $apiRes->assertJsonFragment([
        'author_name' => 'Expert Coach',
        'author_role' => 'coach',
        'is_coach_verified' => true,
    ]);

    // Check questions list API (has_coach_answer should now be true)
    $apiList = $this->getJson('/api/community/questions');
    $apiList->assertOk();
    $found = collect($apiList->json())->firstWhere('id', $q->id);
    expect($found['has_coach_answer'])->toBeTrue();
});

it('allows coach to toggle resolve state of a question', function () {
    $coach = User::factory()->create();

    $q = CommunityQuestion::create([
        'author_name' => 'Peter M.',
        'category' => 'general',
        'title' => 'How to setup Money Circle account?',
        'body' => 'Account setup instructions needed.',
        'is_resolved' => false,
    ]);

    $response = $this->actingAs($coach)->patch(route('coach.questions.resolve', $q));
    $response->assertRedirect();
    expect($q->fresh()->is_resolved)->toBeTrue();

    // Toggle back
    $this->actingAs($coach)->patch(route('coach.questions.resolve', $q));
    expect($q->fresh()->is_resolved)->toBeFalse();
});

it('allows coach to delete a question and its answers', function () {
    $coach = User::factory()->create();

    $q = CommunityQuestion::create([
        'author_name' => 'Spammer',
        'category' => 'general',
        'title' => 'Spam Title',
        'body' => 'Spam content',
        'is_resolved' => false,
    ]);

    CommunityAnswer::create([
        'question_id' => $q->id,
        'author_name' => 'Spam reply',
        'body' => 'Spam link',
    ]);

    $response = $this->actingAs($coach)->delete(route('coach.questions.destroy', $q));

    $response->assertRedirect(route('coach.questions.index'));
    $this->assertDatabaseMissing('community_questions', ['id' => $q->id]);
    $this->assertDatabaseMissing('community_answers', ['question_id' => $q->id]);
});

it('allows coach to view Wins Wall index and view metrics', function () {
    $coach = User::factory()->create();

    CommunityWin::create([
        'member_name' => 'Grace K.',
        'category' => 'debt_cleared',
        'title' => 'Zero debt milestone!',
        'story' => 'Paid off my 2-year loan.',
        'amount_celebrated' => 75000.00,
        'cheers_count' => 15,
    ]);

    $response = $this->actingAs($coach)->get(route('coach.wins.index'));

    $response->assertOk();
    $response->assertSee('Community Wins Wall');
    $response->assertSee('Zero debt milestone!');
    $response->assertSee('Grace K.');
    $response->assertSee('75,000');
});

it('allows coach to publish a spotlight win milestone', function () {
    $coach = User::factory()->create();

    $payload = [
        'member_name' => 'David O.',
        'category' => 'savings_goal',
        'title' => 'Achieved Ksh 100k emergency fund!',
        'story' => 'Consistently set aside money every month.',
        'amount_celebrated' => '100000',
    ];

    $response = $this->actingAs($coach)->post(route('coach.wins.store'), $payload);

    $response->assertRedirect();
    $this->assertDatabaseHas('community_wins', [
        'member_name' => 'David O.',
        'title' => 'Achieved Ksh 100k emergency fund!',
        'amount_celebrated' => 100000.00,
    ]);

    // Check API endpoint for mobile app
    $apiRes = $this->getJson('/api/community/wins');
    $apiRes->assertOk();
    $apiRes->assertJsonFragment([
        'member_name' => 'David O.',
        'title' => 'Achieved Ksh 100k emergency fund!',
    ]);
});

it('allows coach to cheer a win milestone', function () {
    $coach = User::factory()->create();

    $win = CommunityWin::create([
        'member_name' => 'Sarah T.',
        'category' => 'budget_habit',
        'title' => 'No unnecessary spend month',
        'story' => 'Saved 20k.',
        'cheers_count' => 5,
    ]);

    $response = $this->actingAs($coach)->post(route('coach.wins.cheer', $win));

    $response->assertRedirect();
    expect($win->fresh()->cheers_count)->toBe(6);
});

it('allows coach to delete an inappropriate win', function () {
    $coach = User::factory()->create();

    $win = CommunityWin::create([
        'member_name' => 'Test',
        'category' => 'general',
        'title' => 'Test to delete',
        'story' => 'To be deleted',
    ]);

    $response = $this->actingAs($coach)->delete(route('coach.wins.destroy', $win));

    $response->assertRedirect();
    $this->assertDatabaseMissing('community_wins', ['id' => $win->id]);
});
