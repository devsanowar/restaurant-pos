<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FieldOfCost;
use Illuminate\Http\Request;

class FieldOfCostController extends Controller
{
    public function index()
    {
        $fieldOfCosts = FieldOfCost::latest()->paginate(20);
        return view('admin.layouts.pages.cost.field-of-cost.index', compact('fieldOfCosts'));
    }

    public function create()
    {
        // Logic to show the form for creating a new field of cost
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string|max:255',
            'is_active' => 'required|in:1,0',
        ]); 

        // Logic to store the new field of cost

        FieldOfCost::create($request->all());

        return redirect()->back()->with('success', 'Data created successfully!');
    }

    public function edit($id)
    {
        $fieldOfCosts = FieldOfCost::findOrFail($id);
        return response()->json($fieldOfCosts);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'field_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $fieldOfCost = FieldOfCost::findOrFail($id);
        $fieldOfCost->update($request->only('field_name', 'is_active'));

        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $fieldOfCost = FieldOfCost::findOrFail($id);
        $fieldOfCost->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Data deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Data deleted.');
    }
}
