<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostCategory;
use Illuminate\Http\Request;

class CostCategoryController extends Controller
{
    public function index()
    {
        $categories = CostCategory::latest()->paginate(20);
        return view('admin.layouts.pages.cost.cost-category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'is_active' => 'required|in:1,0',
        ]);
        // Logic to store the new cost category
        CostCategory::create($request->all());

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = CostCategory::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $category = CostCategory::findOrFail($id);
        $category->update($request->only('category_name', 'is_active'));

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = CostCategory::findOrFail($id);
        $category->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Category deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Category deleted.');
    }
}
