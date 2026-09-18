<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmergencyFundController extends Controller
{
    public function show(Request $request)
    {
        $fund = $request->user()->emergencyFund;

        if (! $fund) {
            return response()->json(null);
        }

        return response()->json([
            'target_amount' => (float) $fund->target_amount,
            'current_balance' => (float) $fund->current_balance,
            'percent_funded' => $fund->percentFunded(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'target_amount' => 'required|numeric|min:0',
        ]);

        $fund = $request->user()->emergencyFund()->updateOrCreate([], $validated);

        return response()->json($fund, 201);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_balance' => 'required|numeric|min:0',
        ]);

        $fund = $request->user()->emergencyFund;
        abort_unless($fund, 404, 'No emergency fund set up yet.');

        $fund->update($validated);

        return response()->json($fund);
    }
}