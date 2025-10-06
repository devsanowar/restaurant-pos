<?php

namespace App\Http\Controllers\Admin;

use App\Models\Waiter;
use App\Models\ResTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WaiterController extends Controller
{
    public function index()
    {
        $waiters = Waiter::simplePaginate(20);
        $resTables = ResTable::where('is_active', 1)->get();
        return view('admin.layouts.pages.waiter.index', compact('waiters', 'resTables'));
    }

    public function create()
    {
        return view('admin.layouts.pages.waiter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'res_table_id' => 'required|exists:res_tables,id',
            'waiter_name' => 'required|string|max:255',
            'waiter_email' => 'required|email|unique:waiters,waiter_email',
            'waiter_phone' => 'required|string|max:15|unique:waiters,waiter_phone',
            'waiter_address' => 'nullable|string',
        ]);

        Waiter::create([
            'res_table_id' => $request->res_table_id,
            'waiter_name' => $request->waiter_name,
            'waiter_email' => $request->waiter_email,
            'waiter_phone' => $request->waiter_phone,
            'waiter_address' => $request->waiter_address,
        ]);

        return Redirect()->route('admin.waiter.index')->with('success', 'Waiter Created Successfully.');
    }

    public function edit($id)
    {
        $waiter = Waiter::findOrFail($id);
        return response()->json($waiter);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'res_table_id' => 'required|exists:res_tables,id',
            'waiter_name' => 'required|string|max:255',
            'waiter_email' => 'required|email|unique:waiters,waiter_email,' . $id,
            'waiter_phone' => 'required|string|max:15|unique:waiters,waiter_phone,' . $id,
            'waiter_address' => 'nullable|string',
        ]);

        $waiter = Waiter::findOrFail($id);
        $waiter->res_table_id = $request->res_table_id;
        $waiter->waiter_name = $request->waiter_name;
        $waiter->waiter_email = $request->waiter_email;
        $waiter->waiter_phone = $request->waiter_phone;
        $waiter->waiter_address = $request->waiter_address;
        $waiter->is_active = $request->is_active;
        $waiter->save();

        return Redirect()->route('admin.waiter.index')->with('success', 'Waiter Updated Successfully.');
    }

    public function destroy($id)
    {
        $waiter = Waiter::find($id);

        if (!$waiter) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No waiter Found',
                ],
                404,
            );
        }

        $waiter->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Waiter deleted successfully.',
        ]);
    }

    public function getWaiters($table_id)
    {
        $waiters = Waiter::where('res_table_id', $table_id)
            ->where('is_active', 1)
            ->get();

        return response()->json($waiters);
    }

}
