<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MonthlyReflection;
use Illuminate\Http\Request;

class MemberDetailController extends Controller
{
    public function show(Member $member)
    {
        abort_unless($member->coach_id === auth()->id(), 403);

        $categories = $member->categories()->get()->map(fn ($category) => [
            'category' => $category,
            'spent' => $category->spent(),
            'remaining' => $category->remaining(),
            'percent' => $category->percentageComplete(),
        ]);

        $debts = $member->debts()->get()->map(fn ($debt) => [
            'debt' => $debt,
            'months_remaining' => $debt->monthsUntilTargetPayoff(),
            'required_monthly_payment' => $debt->requiredMonthlyPayment(),
        ]);

        return view('coach.member-detail', [
            'member' => $member,
            'categories' => $categories,
            'debts' => $debts,
            'totalDebt' => $member->totalDebt(),
            'emergencyFund' => $member->emergencyFund,
            'savingsGoals' => $member->savingsGoals,
            'investments' => $member->investments,
            'totalInvestments' => $member->totalInvestments(),
            'investmentsByType' => $member->investmentsByType(),
            'reflections' => $member->monthlyReflections()->orderByDesc('period_month')->get(),
        ]);
    }

    public function updateReflectionNotes(Request $request, Member $member, MonthlyReflection $reflection)
    {
        abort_unless($member->coach_id === auth()->id(), 403);
        abort_unless($reflection->member_id === $member->id, 403);

        $validated = $request->validate(['coach_notes' => 'nullable|string']);
        $reflection->update($validated);

        return back()->with('status', 'Notes saved.');
    }
}