<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Debt;
use App\Models\Member;
use App\Models\MemberNotification;
use App\Models\MonthlyReflection;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;

class MemberDetailController extends Controller
{
    public function show(Member $member)
    {
        abort_unless($member->coach_id === auth()->id(), 403);

        $categories = $member->categories()->get()->map(fn ($category) => [
            'category'     => $category,
            'spent'        => $category->spent(),
            'remaining'    => $category->remaining(),
            'percent'      => $category->percentageComplete(),
            'is_overspent' => $category->spent() > (float) $category->planned_amount,
        ]);

        // Segregate active loans from cleared/paid-off loans
        $activeDebts = $member->debts()->where('current_balance', '>', 0)->get()->map(fn ($debt) => [
            'debt'                     => $debt,
            'months_remaining'         => $debt->monthsUntilTargetPayoff(),
            'required_monthly_payment' => $debt->requiredMonthlyPayment(),
        ]);

        $clearedDebts = $member->debts()->where('current_balance', '<=', 0)->get();
        $totalDebt = (float) $member->debts()->where('current_balance', '>', 0)->sum('current_balance');

        $totalInvestments = $member->totalInvestments();
        $totalSavings = (float) $member->savingsGoals()->sum('saved_amount');
        $emergencyBalance = (float) ($member->emergencyFund?->current_balance ?? 0);
        $totalAssets = $totalInvestments + $totalSavings + $emergencyBalance;
        $estimatedNetWorth = $totalAssets - $totalDebt;

        $totalIncome = (float) $member->totalIncome();
        $totalSpent = (float) $member->totalSpent();
        $netCashflow = $totalIncome - $totalSpent;

        $monthlyExpensesBenchmark = $member->totalBudgeted() > 0 ? $member->totalBudgeted() : ($totalSpent > 0 ? $totalSpent : 0);
        $emergencyRunwayMonths = $monthlyExpensesBenchmark > 0 ? round($emergencyBalance / $monthlyExpensesBenchmark, 1) : 0;

        return view('coach.member-detail', [
            'member'            => $member,
            'categories'        => $categories,
            'debts'             => $activeDebts,
            'clearedDebts'      => $clearedDebts,
            'totalDebt'         => $totalDebt,
            'emergencyFund'     => $member->emergencyFund,
            'savingsGoals'      => $member->savingsGoals,
            'investments'       => $member->investments,
            'totalInvestments'  => $totalInvestments,
            'investmentsByType' => $member->investmentsByType(),
            'reflections'       => $member->monthlyReflections()->orderByDesc('period_month')->get(),
            'vitals'            => [
                'total_assets'            => $totalAssets,
                'estimated_net_worth'     => $estimatedNetWorth,
                'total_income'            => $totalIncome,
                'total_spent'             => $totalSpent,
                'net_cashflow'            => $netCashflow,
                'emergency_runway_months' => $emergencyRunwayMonths,
            ],
        ]);
    }

    public function updateReflectionNotes(Request $request, Member $member, MonthlyReflection $reflection)
    {
        abort_unless($member->coach_id === auth()->id(), 403);
        abort_unless($reflection->member_id === $member->id, 403);

        $validated = $request->validate(['coach_notes' => 'nullable|string']);
        $reflection->update($validated);

        if (!empty($validated['coach_notes'])) {
            MemberNotification::create([
                'member_id'     => $member->id,
                'type'          => 'reflection_note',
                'title'         => 'Feedback on ' . $reflection->period_month->format('M Y') . ' Reflection',
                'message'       => $validated['coach_notes'],
                'action_target' => 'reflections',
            ]);
        }

        return back()->with('status', 'Reflection notes saved and notification sent to member.');
    }

    public function updateDebtNotes(Request $request, Member $member, Debt $debt)
    {
        abort_unless($member->coach_id === auth()->id(), 403);
        abort_unless($debt->member_id === $member->id, 403);

        $validated = $request->validate(['coach_notes' => 'nullable|string']);
        $debt->update($validated);

        if (!empty($validated['coach_notes'])) {
            MemberNotification::create([
                'member_id'     => $member->id,
                'type'          => 'debt_note',
                'title'         => 'Coach Advice on ' . $debt->lender,
                'message'       => $validated['coach_notes'],
                'action_target' => 'debts',
            ]);
        }

        return back()->with('status', 'Debt advice for ' . $debt->lender . ' saved and notification sent to member.');
    }

    public function updateCategoryNotes(Request $request, Member $member, Category $category)
    {
        abort_unless($member->coach_id === auth()->id(), 403);
        abort_unless($category->member_id === $member->id, 403);

        $validated = $request->validate(['coach_notes' => 'nullable|string']);
        $category->update($validated);

        if (!empty($validated['coach_notes'])) {
            MemberNotification::create([
                'member_id'     => $member->id,
                'type'          => 'category_note',
                'title'         => 'Coach Tip on ' . $category->name,
                'message'       => $validated['coach_notes'],
                'action_target' => 'categories',
            ]);
        }

        return back()->with('status', 'Note for ' . $category->name . ' saved and notification sent to member.');
    }

    public function updateSavingsGoalNotes(Request $request, Member $member, SavingsGoal $savingsGoal)
    {
        abort_unless($member->coach_id === auth()->id(), 403);
        abort_unless($savingsGoal->member_id === $member->id, 403);

        $validated = $request->validate(['coach_notes' => 'nullable|string']);
        $savingsGoal->update($validated);

        if (!empty($validated['coach_notes'])) {
            MemberNotification::create([
                'member_id'     => $member->id,
                'type'          => 'savings_note',
                'title'         => 'Coach Encouragement on ' . $savingsGoal->goal_name,
                'message'       => $validated['coach_notes'],
                'action_target' => 'savings_goals',
            ]);
        }

        return back()->with('status', 'Savings goal advice saved and notification sent to member.');
    }

    public function updateEmergencyFundNotes(Request $request, Member $member)
    {
        abort_unless($member->coach_id === auth()->id(), 403);
        abort_unless($member->emergencyFund, 404);

        $validated = $request->validate(['coach_notes' => 'nullable|string']);
        $member->emergencyFund->update($validated);

        if (!empty($validated['coach_notes'])) {
            MemberNotification::create([
                'member_id'     => $member->id,
                'type'          => 'emergency_note',
                'title'         => 'Coach Tip on Emergency Fund',
                'message'       => $validated['coach_notes'],
                'action_target' => 'emergency_fund',
            ]);
        }

        return back()->with('status', 'Emergency fund coach note saved and notification sent to member.');
    }
}