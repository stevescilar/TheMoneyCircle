<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->investments()->get()->map(fn ($inv) => [
                'id' => $inv->id,
                'type' => $inv->type,
                'label' => $inv->label,
                'balance' => (float) $inv->balance,
            ])
        );
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

    public function update(Request $request, $id)
    {
        $investment = $request->user()->investments()->findOrFail($id);

        $validated = $request->validate([
            'balance' => 'required|numeric|min:0',
        ]);

        $investment->update($validated);

        return response()->json($investment);
    }
}