<?php

namespace App\Http\Controllers;

use App\Models\Member;

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

        return view('coach.member-detail', [
            'member' => $member,
            'categories' => $categories,
            'debts' => $member->debts,
            'emergencyFund' => $member->emergencyFund,
            'savingsGoals' => $member->savingsGoals,
            'investments' => $member->investments,
        ]);
    }
}