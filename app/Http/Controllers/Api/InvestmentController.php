<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $investments = $request->user()->investments()->with('contributions')->get();

        return response()->json($investments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:mmf,sacco,t_bill,shares,bonds',
            'label' => 'nullable|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        $investment = $request->user()->investments()->create($validated);

        return response()->json($investment, 201);
    }

    public function update(Request $request, Investment $investment)
    {
        abort_unless($investment->member_id === $request->user()->id, 403);

        $validated = $request->validate([
            'type' => 'sometimes|in:mmf,sacco,t_bill,shares,bonds',
            'label' => 'sometimes|nullable|string|max:255',
            'balance' => 'sometimes|numeric|min:0',
        ]);

        $investment->update($validated);

        return response()->json($investment);
    }

    public function contribute(Request $request, Investment $investment)
    {
        abort_unless($investment->member_id === $request->user()->id, 403);

        $validated = $request->validate(['amount' => 'required|numeric|min:0.01']);

        $investment->contributions()->create([
            'amount' => $validated['amount'],
            'contributed_at' => now(),
        ]);

        $investment->increment('balance', $validated['amount']);

        return response()->json($investment->fresh('contributions'));
    }

    public function contributions(Request $request, Investment $investment)
    {
        abort_unless($investment->member_id === $request->user()->id, 403);

        $contributions = $investment->contributions()
            ->orderByDesc('contributed_at')
            ->paginate(15);

        return response()->json($contributions);
    }

    public function destroy(Request $request, Investment $investment)
    {
        abort_unless($investment->member_id === $request->user()->id, 403);

        $investment->contributions()->delete();
        $investment->delete();

        return response()->json(null, 204);
    }
}