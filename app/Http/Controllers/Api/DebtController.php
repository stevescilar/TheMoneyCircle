<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $debts = $request->user()->debts()->get()->map(fn ($debt) => [
            'id' => $debt->id,
            'lender' => $debt->lender,
            'current_balance' => (float) $debt->current_balance,
            'target_payoff_date' => $debt->target_payoff_date?->toDateString(),
        ]);

        return response()->json($debts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lender' => 'required|string|max:255',
            'current_balance' => 'required|numeric|min:0',
            'target_payoff_date' => 'nullable|date',
        ]);

        $debt = $request->user()->debts()->create($validated);

        return response()->json($debt, 201);
    }

    public function update(Request $request, $id)
    {
        $debt = $request->user()->debts()->findOrFail($id);

        $validated = $request->validate([
            'current_balance' => 'required|numeric|min:0',
        ]);

        $debt->update($validated);

        return response()->json($debt);
    }
}