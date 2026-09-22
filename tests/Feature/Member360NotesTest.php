<?php

use App\Models\Category;
use App\Models\Debt;
use App\Models\EmergencyFund;
use App\Models\Member;
use App\Models\MonthlyReflection;
use App\Models\SavingsGoal;
use App\Models\User;

it('renders member 360 profile with financial vitals and granular sections', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create([
        'name' => 'Wanjiku Mwangi',
        'email' => 'wanjiku@example.com',
        'phone' => '+254712345678',
    ]);

    $rent = Category::factory()->for($member)->create([
        'name' => 'Rent & Housing',
        'planned_amount' => 25000,
    ]);

    $debt = Debt::create([
        'member_id' => $member->id,
        'lender' => 'KCB M-Pesa Loan',
        'current_balance' => 45000,
        'target_payoff_date' => now()->addMonths(6),
    ]);

    $emergency = EmergencyFund::create([
        'member_id' => $member->id,
        'target_amount' => 100000,
        'current_balance' => 35000,
    ]);

    $goal = SavingsGoal::create([
        'member_id' => $member->id,
        'goal_name' => 'Land Down Payment',
        'target_amount' => 200000,
        'saved_amount' => 50000,
    ]);

    $response = $this->actingAs($coach)->get(route('members.show', $member));

    $response->assertOk();
    $response->assertSee('Wanjiku Mwangi');
    $response->assertSee('Estimated Net Worth');
    $response->assertSee('KCB M-Pesa Loan');
    $response->assertSee('Rent & Housing');
    $response->assertSee('WhatsApp Message');
});

it('allows coach to submit granular advice on a specific debt', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create();

    $debt = Debt::create([
        'member_id' => $member->id,
        'lender' => 'NCBA Stawi Loan',
        'current_balance' => 30000,
    ]);

    $note = 'When are we clearing this loan? Let us allocate any bonus or extra cash directly here.';

    $response = $this->actingAs($coach)->patch(route('members.debts.notes', [$member, $debt]), [
        'coach_notes' => $note,
    ]);

    $response->assertRedirect();
    expect($debt->fresh()->coach_notes)->toBe($note);
});

it('allows coach to submit advice on a specific budget category', function () {
    $coach = User::factory()->create();
    $member = Member::factory()->for($coach, 'coach')->create();

    $category = Category::factory()->for($member)->create([
        'name' => 'Entertainment',
        'planned_amount' => 8000,
    ]);

    $note = 'Spending was high this month, let us freeze dining out for 2 weeks.';

    $response = $this->actingAs($coach)->patch(route('members.categories.notes', [$member, $category]), [
        'coach_notes' => $note,
    ]);

    $response->assertRedirect();
    expect($category->fresh()->coach_notes)->toBe($note);
});

it('prevents another coach from modifying member debt notes', function () {
    $coach1 = User::factory()->create();
    $coach2 = User::factory()->create();
    $member = Member::factory()->for($coach1, 'coach')->create();

    $debt = Debt::create([
        'member_id' => $member->id,
        'lender' => 'Tala Loan',
        'current_balance' => 15000,
    ]);

    $response = $this->actingAs($coach2)->patch(route('members.debts.notes', [$member, $debt]), [
        'coach_notes' => 'Malicious note',
    ]);

    $response->assertForbidden();
    expect($debt->fresh()->coach_notes)->toBeNull();
});

