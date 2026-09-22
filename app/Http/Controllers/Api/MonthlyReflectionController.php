<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonthlyReflectionController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->monthlyReflections()->orderByDesc('period_month')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'financial_score' => 'required|integer|min:1|max:10',
            'wins' => 'nullable|string',
            'challenges' => 'nullable|string',
            'period_month' => 'required|date',
        ]);

        $reflection = $request->user()->monthlyReflections()->updateOrCreate(
            ['period_month' => $validated['period_month']],
            $validated
        );

        return response()->json($reflection, $reflection->wasRecentlyCreated ? 201 : 200);
    }

    public function update(Request $request, $id)
    {
        $reflection = $request->user()->monthlyReflections()->findOrFail($id);

        $validated = $request->validate([
            'financial_score' => 'sometimes|required|integer|min:1|max:10',
            'wins' => 'nullable|string',
            'challenges' => 'nullable|string',
        ]);

        $reflection->update($validated);

        return response()->json($reflection);
    }
}