<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'transacted_at' => 'nullable|date',
        ]);

        if (! empty($validated['category_id'])) {
            $ownsCategory = $request->user()->categories()->where('id', $validated['category_id'])->exists();
            abort_unless($ownsCategory, 403, 'That category does not belong to this member.');
        }

        $transaction = $request->user()->transactions()->create([
            ...$validated,
            'transacted_at' => $validated['transacted_at'] ?? now(),
        ]);

        return response()->json($transaction, 201);
    }
}