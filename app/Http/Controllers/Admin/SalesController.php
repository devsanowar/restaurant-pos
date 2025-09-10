<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ResTable;
use App\Models\Sales;
use App\Models\Waiter;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $productCategories = ProductCategory::where('is_active', 1)
            ->with('products')
            ->get();

        $tables = ResTable::where('is_active', 1)
            ->with('waiter')
            ->get();

        $waiters = Waiter::where('is_active', 1)->get();

        return view('admin.layouts.pages.sales.index', compact('productCategories', 'tables', 'waiters'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Sales $sales)
    {
        //
    }

    public function edit(Sales $sales)
    {
        //
    }

    public function update(Request $request, Sales $sales)
    {
        //
    }

    public function destroy(Sales $sales)
    {
        //
    }
}
