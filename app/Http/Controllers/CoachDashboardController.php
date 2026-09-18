<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoachDashboardController extends Controller
{
    public function index(Request $request)
{
    $filter = $request->query('filter', 'all');

    $query = $request->user()->members()->withBudgetTotals();

    if ($filter === 'at_risk') {
        $query->havingRaw('COALESCE(total_spent, 0) > COALESCE(total_budgeted, 0)')
              ->groupBy('members.id');
    }

    $members = $query->get()->map(fn ($member) => [
        'member' => $member,
        'total_budgeted' => (float) $member->total_budgeted,
        'total_spent' => (float) $member->total_spent,
        'percent_spent' => $member->total_budgeted > 0
            ? round(($member->total_spent / $member->total_budgeted) * 100, 1)
            : 0,
        'is_overspent' => $member->total_spent > $member->total_budgeted,
    ]);

    return view('coach.dashboard', ['members' => $members, 'filter' => $filter]);
}
}
