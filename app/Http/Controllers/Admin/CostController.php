<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cost;
use App\Models\FieldOfCost;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CostController extends Controller
{
    public function index()
    {
        $categories = CostCategory::select(['id', 'category_name'])->get();
        $fields = FieldOfCost::select(['id', 'field_name'])->get();
        $costs = Cost::with(['category:id,category_name', 'field:id,field_name'])
            ->latest()
            ->paginate(10);


        $deletedCostCount = Cost::onlyTrashed()->count();

        return view('admin.layouts.pages.cost.index', compact('categories', 'fields', 'costs','deletedCostCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:cost_categories,id',
            'field_id' => 'required|exists:field_of_costs,id',
            'branch_name' => 'nullable|string',
            'amount' => 'required|numeric',
            'spend_by' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Cost::create($validated);

        return redirect()->route('admin.cost.index')->with('success', 'Cost added successfully!');
    }

    public function edit($id)
    {
        $cost = Cost::findOrFail($id);
        return response()->json($cost);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|integer',
            'field_id' => 'required|integer',
            'branch_name' => 'nullable|string',
            'amount' => 'required|numeric',
            'spend_by' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $cost = Cost::findOrFail($id);

        $cost->update([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'field_id' => $request->field_id,
            'branch_name' => $request->branch_name,
            'amount' => $request->amount,
            'spend_by' => $request->spend_by,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.cost.index')->with('success', 'Cost updated successfully!');
    }


    public function destroy($id)
    {
        $cost = Cost::findOrFail($id);
        if (!$cost) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No cost Found',
                ],
                404,
            );
        }

        $cost->delete();

        $deletedCount = Cost::onlyTrashed()->count();
        return response()->json([
            'status' => 'success',
            'message' => 'Cost deleted successfully.',
            'deletedCount' => $deletedCount,
        ]);
    }

    public function trashedData()
    {
        $costs = Cost::with(['category:id,category_name'])
            ->onlyTrashed()
            ->get();
        $deletedCount = $costs->count();
        return view('admin.layouts.pages.cost.recycle-bin', compact('costs', 'deletedCount'));
    }

    public function restoreData(Request $request)
    {
        $cost = Cost::onlyTrashed()->where('id', $request->id)->first();

        if ($cost) {
            $cost->restore();

            $deletedCount = Cost::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Cost Restored Successfully.',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'No Cost Found',
            ],
            404,
        );
    }

    public function forceDelete($id)
    {
        $cost = Cost::onlyTrashed()->where('id', $id)->first();

        if ($cost) {
            $cost->forceDelete();
            $deletedCount = Cost::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Cost permanently deleted!',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'Cost not found',
            ],
            404,
        );
    }
}
