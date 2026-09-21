<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $debts = $request->user()->debts()->with('payments')->get();

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

    public function update(Request $request, Debt $debt)
    {
        abort_unless($debt->member_id === $request->user()->id, 403);

        $validated = $request->validate([
            'lender' => 'sometimes|string|max:255',
            'current_balance' => 'sometimes|numeric|min:0',
            'target_payoff_date' => 'sometimes|nullable|date',
        ]);

        $debt->update($validated);

        return response()->json($debt);
    }

    public function recordPayment(Request $request, Debt $debt)
    {
        abort_unless($debt->member_id === $request->user()->id, 403);

        $validated = $request->validate(['amount' => 'required|numeric|min:0.01']);

        $debt->payments()->create([
            'amount' => $validated['amount'],
            'paid_at' => now(),
        ]);

        $debt->decrement('current_balance', $validated['amount']);
        $debt->current_balance = max(0, $debt->current_balance);
        $debt->save();

        return response()->json($debt->fresh('payments'));
    }

    public function destroy(Request $request, Debt $debt)
    {
        abort_unless($debt->member_id === $request->user()->id, 403);

        $debt->payments()->delete();
        $debt->delete();

        return response()->json(null, 204);
    }
}