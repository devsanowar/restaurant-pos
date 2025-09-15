<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stock;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::orderBy('id', 'desc')->paginate(10);
        return view('admin.layouts.pages.stock.index', compact('stocks'));
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('admin.stock.index')->with('success', 'Stock item delete successfully!');
    }
}
