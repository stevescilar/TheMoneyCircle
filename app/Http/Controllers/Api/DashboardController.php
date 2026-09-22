<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::withBudgetTotals()->findOrFail($request->user()->id);

        $budgeted = (float) ($member->total_budgeted ?? 0);
        $spent    = (float) ($member->total_spent ?? 0);
        $income   = (float) ($member->total_income ?? 0);

        return response()->json([
            'total_income'        => $income,
            'total_budgeted'      => $budgeted,
            'total_spent'         => $spent,
            'remaining_to_spend'  => $budgeted - $spent,
            'net_cashflow'        => $income - $spent,
            'percent_budget_spent' => $budgeted > 0 ? round(($spent / $budgeted) * 100, 1) : 0.0,
            'is_overspent'        => $spent > $budgeted,
        ]);
    }
}