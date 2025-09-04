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
        $deletedIncomeCount = Income::onlyTrashed()->count();
        return view('admin.layouts.pages.income.index', compact('incomes', 'incomeCategories','deletedIncomeCount'));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'income_source' => 'required|string|max:255',
            'income_category_id' => 'required|exists:income_categories,id',
            'amount' => 'required|numeric',
            'income_date' => 'required|date',
            'status' => 'required|in:pending,received',
            'income_by' => 'nullable|string|max:255',
        ]);

        $income = Income::findOrFail($id);
        $income->update([
            'income_source' => $request->income_source,
            'income_category_id' => $request->income_category_id,
            'amount' => $request->amount,
            'income_date' => $request->income_date,
            'status' => $request->status,
            'income_by' => $request->income_by,
        ]);

        return response()->json(['message' => 'Income updated successfully']);
    }

    public function destroy($id)
    {
        $income = Income::findOrfail($id);
        if (!$income) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No income Found',
                ],
                404,
            );
        }
        $income->delete();

        $deletedCount = Income::onlyTrashed()->count();
        return response()->json([
            'status' => 'success',
            'message' => 'income deleted successfully.',
            'deletedCount' => $deletedCount,
        ]);
    }



    public function trashedData()
    {
        $incomes = Income::with(['incomeCategory:id,income_category_name'])
            ->onlyTrashed()
            ->get();
        $deletedCount = $incomes->count();
        return view('admin.layouts.pages.income.recycle-bin', compact('incomes', 'deletedCount'));
    }



    public function restoreData(Request $request)
    {
        $income = Income::onlyTrashed()->where('id', $request->id)->first();

        if ($income) {
            $income->restore();

            $deletedCount = Income::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Income Restored Successfully.',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'No Income Found',
            ],
            404,
        );
    }

    public function forceDelete($id)
    {
        $income = Income::onlyTrashed()->where('id', $id)->first();

        if ($income) {
            $income->forceDelete();
            $deletedCount = Income::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Income permanently deleted!',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'Income not found',
            ],
            404,
        );
    }
}
