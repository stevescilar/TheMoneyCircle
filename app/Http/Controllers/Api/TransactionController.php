<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()
            ->transactions()
            ->with('category:id,name,type');

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        $perPage = min(100, (int) $request->query('per_page', 50));
        $transactions = $query->orderByDesc('transacted_at')->paginate($perPage);

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'          => 'required|in:income,expense',
            'amount'        => 'required|numeric|min:0.01',
            'description'   => 'nullable|string|max:255',
            'category_id'   => 'nullable|exists:categories,id',
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

        return response()->json($transaction->load('category:id,name,type'), 201);
    }

    public function update(Request $request, \App\Models\Transaction $transaction)
    {
        abort_unless($transaction->member_id === $request->user()->id, 403);

        if (empty($request->all()) && ! empty($request->getContent())) {
            parse_str($request->getContent(), $parsed);
            if (is_array($parsed)) {
                $request->merge($parsed);
            }
        }

        $validated = $request->validate([
            'type'          => 'sometimes|in:income,expense',
            'amount'        => 'sometimes|numeric|min:0.01',
            'description'   => 'sometimes|nullable|string|max:255',
            'category_id'   => 'sometimes|nullable|exists:categories,id',
            'transacted_at' => 'sometimes|nullable|date',
        ]);

        if (isset($validated['category_id']) && ! empty($validated['category_id'])) {
            $ownsCategory = $request->user()->categories()->where('id', $validated['category_id'])->exists();
            abort_unless($ownsCategory, 403, 'That category does not belong to this member.');
        }

        $transaction->update($validated);

        return response()->json($transaction->fresh('category:id,name,type'));
    }

    public function destroy(Request $request, \App\Models\Transaction $transaction)
    {
        abort_unless($transaction->member_id === $request->user()->id, 403);

        $transaction->delete();

        return response()->json(null, 204);
    }

    public function resetExpenses(Request $request)
    {
        $query = $request->user()->transactions()->where('type', 'expense');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        $count = $query->delete();

        return response()->json([
            'message'       => "Successfully reset {$count} expense transactions.",
            'deleted_count' => $count,
        ]);
    }
}