<?php

namespace App\Http\Controllers\Admin;

use App\Models\ResTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ResTableController extends Controller
{
    public function index()
    {
        $resTables = ResTable::simplePaginate(20);
        return view('admin.layouts.pages.res_table.index', compact('resTables'));
    }

    public function create()
    {
        return view('admin.layouts.pages.res_table.create');
    }

    public function edit($id)
    {
        $table = ResTable::findOrFail($id);
        return response()->json($table);
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:res_tables,table_number',
            'table_capacity' => 'required|numeric|min:1',
            'is_active' => 'required|boolean',
        ]);

        ResTable::create([
            'table_number' => $request->table_number,
            'table_capacity' => $request->table_capacity,
            'is_active' => $request->is_active,
        ]);

        return Redirect()->route('admin.res-table.index')->with('success', 'Table Created Successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'table_number' => ['required', Rule::unique('res_tables', 'table_number')->ignore($id, 'id')],
            'table_capacity' => 'required|integer|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        $table = ResTable::findOrFail($id);
        $table->table_number = $request->table_number;
        $table->table_capacity = $request->table_capacity;
        $table->is_active = $request->is_active;
        $table->save();

        return redirect()->route('admin.res-table.index')->with('success', 'Table updated successfully.');
    }

    public function destroy($id)
    {
        $table = ResTable::find($id);

        if (!$table) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No Restaurant Table Found',
                ],
                404,
            );
        }

        $table->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Table deleted successfully.',
        ]);
    }

    public function getWaiter($tableId)
    {
        $table = ResTable::with('waiter')->findOrFail($tableId);

        return response()->json($table->waiter);
    }

}
