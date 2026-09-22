<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->user()->categories()->get()->map(fn ($c) => $this->shape($c));

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'planned_amount' => 'required|numeric|min:0',
            'type'          => 'required|in:expense,debt,emergency_fund,savings_goal,investment',
            'period_start'  => 'required|date',
            'period_end'    => 'required|date|after_or_equal:period_start',
        ]);

        $category = $request->user()->categories()->create($validated);

        return response()->json($this->shape($category), 201);
    }

    private function shape(Category $category): array
    {
        return [
            'id'              => $category->id,
            'name'            => $category->name,
            'type'            => $category->type,
            'planned_amount'  => (float) $category->planned_amount,
            'spent'           => $category->spent(),
            'remaining'       => $category->remaining(),
            'percent_complete' => $category->percentageComplete(),
            'period_start'    => $category->period_start->toDateString(),
            'period_end'      => $category->period_end->toDateString(),
            'coach_notes'     => $category->coach_notes,
        ];
    }
}