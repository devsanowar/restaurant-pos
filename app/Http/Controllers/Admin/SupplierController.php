<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::select(['id', 'supplier_name', 'contact_person', 'phone', 'email', 'opening_balance', 'current_balance', 'balance_type', 'address', 'is_active'])
            ->latest()
            ->simplePaginate(20);

        $deletedSupplierCount = Supplier::onlyTrashed()->count();

        return view('admin.layouts.pages.supplier.index', compact('suppliers', 'deletedSupplierCount'));
    }

    public function create()
    {
        return view('admin.layouts.pages.supplier.create');
    }

    public function store(SupplierStoreRequest $request)
    {
        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'opening_balance' => $request->opening_balance ?? 0,
            'current_balance' => $request->current_balance ?? 0,
            'balance_type' => $request->balance_type,
            'is_active' => $request->is_active,
        ]);
        return Redirect()->route('admin.supplier.index')->with('success', 'Supplier Created Successfully.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'supplier_name' => $request->supplier_name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'opening_balance' => $request->opening_balance,
            'current_balance' => $request->current_balance ?? 0,
            'balance_type' => $request->balance_type,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier Updated Successfully.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        if (!$supplier) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No Supplier Found',
                ],
                404,
            );
        }

        $supplier->delete();

        $deletedCount = Supplier::onlyTrashed()->count();
        return response()->json([
            'status' => 'success',
            'message' => 'Supplier deleted successfully.',
            'deletedCount' => $deletedCount,
        ]);
    }

    public function trashedData()
    {
        $suppliers = Supplier::onlyTrashed()->get();
        $deletedCount = $suppliers->count();
        return view('admin.layouts.pages.supplier.trashed', compact('suppliers', 'deletedCount'));
    }

    public function restoreData(Request $request)
    {
        $supplier = Supplier::onlyTrashed()->where('id', $request->id)->first();

        if ($supplier) {
            $supplier->restore();

            $deletedCount = Supplier::onlyTrashed()->count(); // restore করার পর নতুন count

            return response()->json([
                'status' => 'success',
                'message' => 'Supplier Restored Successfully.',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'No Supplier Found',
            ],
            404,
        );
    }

    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()->where('id', $id)->first();

        if ($supplier) {
            $supplier->forceDelete();
            $deletedCount = Supplier::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Supplier permanently deleted!',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'Supplier not found',
            ],
            404,
        );
    }
}
