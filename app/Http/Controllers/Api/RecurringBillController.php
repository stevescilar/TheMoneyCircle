<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecurringBill;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RecurringBillController extends Controller
{
    public function index(Request $request)
    {
        $bills = $request->user()
            ->recurringBills()
            ->with('category')
            ->orderBy('due_day')
            ->get()
            ->map(fn (RecurringBill $b) => [
                'id'                 => $b->id,
                'name'               => $b->name,
                'amount'             => (float) $b->amount,
                'due_day'            => (int) $b->due_day,
                'category_id'        => $b->category_id,
                'category_name'      => $b->category?->name,
                'is_active'          => (bool) $b->is_active,
                'is_paid_this_month' => $b->isPaidThisMonth(),
                'last_paid_at'       => $b->last_paid_at?->toDateString(),
                'notes'              => $b->notes,
            ]);

        return response()->json($bills);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0.01',
            'due_day'     => 'nullable|integer|min:1|max:31',
            'category_id' => 'nullable|exists:categories,id',
            'notes'       => 'nullable|string|max:500',
        ]);

        $bill = $request->user()->recurringBills()->create([
            'name'        => $validated['name'],
            'amount'      => $validated['amount'],
            'due_day'     => $validated['due_day'] ?? 1,
            'category_id' => $validated['category_id'] ?? null,
            'notes'       => $validated['notes'] ?? null,
            'is_active'   => true,
        ]);

        return response()->json([
            'id'                 => $bill->id,
            'name'               => $bill->name,
            'amount'             => (float) $bill->amount,
            'due_day'            => (int) $bill->due_day,
            'category_id'        => $bill->category_id,
            'category_name'      => $bill->category?->name,
            'is_active'          => (bool) $bill->is_active,
            'is_paid_this_month' => $bill->isPaidThisMonth(),
            'last_paid_at'       => $bill->last_paid_at?->toDateString(),
            'notes'              => $bill->notes,
        ], 201);
    }

    public function update(Request $request, RecurringBill $recurringBill)
    {
        abort_unless($recurringBill->member_id === $request->user()->id, 403);

        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'amount'      => 'sometimes|required|numeric|min:0.01',
            'due_day'     => 'sometimes|required|integer|min:1|max:31',
            'category_id' => 'nullable|exists:categories,id',
            'is_active'   => 'sometimes|boolean',
            'notes'       => 'nullable|string|max:500',
        ]);

        $recurringBill->update($validated);
        $recurringBill->refresh();

        return response()->json([
            'id'                 => $recurringBill->id,
            'name'               => $recurringBill->name,
            'amount'             => (float) $recurringBill->amount,
            'due_day'            => (int) $recurringBill->due_day,
            'category_id'        => $recurringBill->category_id,
            'category_name'      => $recurringBill->category?->name,
            'is_active'          => (bool) $recurringBill->is_active,
            'is_paid_this_month' => $recurringBill->isPaidThisMonth(),
            'last_paid_at'       => $recurringBill->last_paid_at?->toDateString(),
            'notes'              => $recurringBill->notes,
        ]);
    }

    public function destroy(Request $request, RecurringBill $recurringBill)
    {
        abort_unless($recurringBill->member_id === $request->user()->id, 403);

        $recurringBill->delete();

        return response()->json(['message' => 'Recurring bill deleted successfully']);
    }

    public function pay(Request $request, RecurringBill $recurringBill)
    {
        abort_unless($recurringBill->member_id === $request->user()->id, 403);

        // Record the transaction as expense
        $transaction = $request->user()->transactions()->create([
            'type'          => 'expense',
            'amount'        => $recurringBill->amount,
            'description'   => $recurringBill->name . ' (Bill payment)',
            'category_id'   => $recurringBill->category_id,
            'transacted_at' => now(),
        ]);

        $recurringBill->update([
            'last_paid_at' => now(),
        ]);

        return response()->json([
            'message'        => 'Bill logged and marked as paid for this month',
            'bill'           => [
                'id'                 => $recurringBill->id,
                'name'               => $recurringBill->name,
                'amount'             => (float) $recurringBill->amount,
                'is_paid_this_month' => true,
                'last_paid_at'       => $recurringBill->last_paid_at?->toDateString(),
            ],
            'transaction_id' => $transaction->id,
        ]);
    }
}

