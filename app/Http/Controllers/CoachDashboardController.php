<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\MonthlyReflection;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;

class CoachDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $filter = $request->query('filter', 'all');
        $search = trim((string) $request->query('search', ''));

        // All members for coach metrics
        $allMembers = $user->members()->withBudgetTotals()->get();
        $totalMembers = $allMembers->count();
        $atRiskCount = $allMembers->filter(fn ($m) => (float) $m->total_spent > (float) $m->total_budgeted)->count();

        // Calculate total tracked wealth (savings goals + investments)
        $memberIds = $allMembers->pluck('id');
        $totalSavings = (float) SavingsGoal::whereIn('member_id', $memberIds)->sum('saved_amount');
        $totalInvestments = (float) Investment::whereIn('member_id', $memberIds)->sum('balance');
        $totalWealthTracked = $totalSavings + $totalInvestments;

        // Pending monthly reflection reviews (reflections without coach notes)
        $pendingReflectionsCount = MonthlyReflection::whereIn('member_id', $memberIds)
            ->where(function ($q) {
                $q->whereNull('coach_notes')->orWhere('coach_notes', '');
            })
            ->count();

        // Query filtered list
        $query = $filter === 'at_risk'
            ? $user->members()->atRisk()
            : $user->members()->withBudgetTotals();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $members = $query->get()->map(function ($member) {
            $budgeted = (float) $member->total_budgeted;
            $spent = (float) $member->total_spent;
            $percent = $budgeted > 0 ? round(($spent / $budgeted) * 100, 1) : 0;
            $latestReflection = $member->monthlyReflections()->orderByDesc('period_month')->first();

            return [
                'member'            => $member,
                'total_budgeted'    => $budgeted,
                'total_spent'       => $spent,
                'percent_spent'     => $percent,
                'is_overspent'      => $spent > $budgeted,
                'latest_reflection' => $latestReflection,
            ];
        });

        if ($filter === 'needs_notes') {
            $members = $members->filter(function ($item) {
                return $item['latest_reflection'] && empty($item['latest_reflection']->coach_notes);
            })->values();
        }

        return view('coach.dashboard', [
            'members' => $members,
            'filter'  => $filter,
            'search'  => $search,
            'kpis'    => [
                'total_members'             => $totalMembers,
                'at_risk_count'             => $atRiskCount,
                'total_wealth_tracked'      => $totalWealthTracked,
                'pending_reflections_count' => $pendingReflectionsCount,
            ],
        ]);
    }
}

