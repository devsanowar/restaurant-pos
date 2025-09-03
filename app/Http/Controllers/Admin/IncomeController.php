<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::get(['id', 'income_category_name']);
        $incomes = Income::with('incomeCategory')->latest()->paginate(20);
        return view('admin.layouts.pages.income.index', compact('incomes', 'incomeCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'income_category_id' => 'required|exists:income_categories,id',
            'income_source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'income_date' => 'required|date',
            'status' => 'required|in:received,pending',
            'income_by' => 'nullable|string|max:255',
        ]);

        // Create Income
        Income::create([
            'income_category_id' => $validated['income_category_id'],
            'income_source' => $validated['income_source'],
            'amount' => $validated['amount'],
            'income_date' => $validated['income_date'],
            'status' => $validated['status'],
            'income_by' => $validated['income_by'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Income added successfully!');
    }

    public function edit($id)
    {
        $income = Income::findOrFail($id);
        return response()->json($income);
    }
}
