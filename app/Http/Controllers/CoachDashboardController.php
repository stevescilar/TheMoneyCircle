<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachDashboardController extends Controller
{
    public function index(Request $request)
    {
        $members = $request->user()
        ->members()
        ->get()
        ->map(fn($member) =>[
            'member' => $member,
            'total_budgeted' => $member->totalBudgeted(),
            'total_spent' => $member->totalSpent(),
            'percent_spent' => $member->percentBudgetSpent(),
            'is_overspent' => $member->isOverSpent(),
        ]);

        return view('coach.dashboard', [
            'members' => $members,
        ]);
    }
}
