<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostCategory;
use Illuminate\Http\Request;

class CostCategoryController extends Controller
{
    public function index()
    {
        $categories = CostCategory::latest()->get();
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
        // Logic to show form for editing an existing cost category
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing cost category
    }

    public function destroy($id)
    {
        // Logic to delete an existing cost category
    }   
}
