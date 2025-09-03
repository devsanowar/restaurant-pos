<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $incomeCategories = IncomeCategory::latest()->get();
        return view('admin.layouts.pages.income.income-category.index', compact('incomeCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'income_category_name' => 'required|string|max:255',
        ]);

        IncomeCategory::create([
            'income_category_name' => $request->income_category_name,
        ]);

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function edit($id)
    {
        $incomeCategory = IncomeCategory::findOrFail($id);
        return response()->json($incomeCategory);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'income_category_name' => 'required|string|max:255',
        ]);

        $incomeCategory = IncomeCategory::findOrFail($id);
        $incomeCategory->income_category_name = $request->income_category_name;
        $incomeCategory->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Successfully.',
        ]);
    }


    public function destroy($id){
        $deleteIncomeCat = IncomeCategory::findOrfail($id);
        if (!$deleteIncomeCat) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No waiter Found',
                ],
                404,
            );
        }
        $deleteIncomeCat->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Income Category deleted successfully.',
        ]);
    }
}
