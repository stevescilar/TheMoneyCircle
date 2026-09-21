<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;

class SavingsGoalController extends Controller
{
    public function index(Request $request)
    {
        $goals = $request->user()->savingsGoals()->get()->map(fn ($goal) => $this->shape($goal));

        return response()->json($goals);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
        ]);

        $goal = $request->user()->savingsGoals()->create($validated);

        return response()->json($this->shape($goal), 201);
    }

    public function contribute(Request $request, SavingsGoal $savingsGoal)
    {
        abort_unless($savingsGoal->member_id === $request->user()->id, 403);

        $validated = $request->validate(['amount' => 'required|numeric|min:0.01']);

        $savingsGoal->increment('saved_amount', $validated['amount']);

        return response()->json($this->shape($savingsGoal->fresh()));
    }

    public function destroy(Request $request, SavingsGoal $savingsGoal)
    {
        abort_unless($savingsGoal->member_id === $request->user()->id, 403);

        $savingsGoal->delete();

        return response()->json(null, 204);
    }

    private function shape(SavingsGoal $goal): array
    {
        return [
            'id'               => $goal->id,
            'goal_name'        => $goal->goal_name,
            'target_amount'    => (float) $goal->target_amount,
            'saved_amount'     => (float) $goal->saved_amount,
            'remaining'        => $goal->remaining(),
            'percent_complete' => $goal->percentComplete(),
        ];
    }
}