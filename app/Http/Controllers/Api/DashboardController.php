<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->user();

        return response()->json([
            'total_budgeted' => $member->totalBudgeted(),
            'total_spent' => $member->totalSpent(),
            'remaining_to_spend' => $member->remainingToSpend(),
            'percent_budget_spent' => $member->percentBudgetSpent(),
            'is_overspent' => $member->isOverSpent(),
        ]);
    }
}