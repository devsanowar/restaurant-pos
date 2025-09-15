<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::orderBy('id', 'desc')->paginate(10);
        return view('admin.layouts.pages.stock.stock-out.index', compact('stockOuts'));
    }

    public function create()
    {
        $stocks = Stock::all();

        return view('admin.layouts.pages.stock.stock-out.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.stock_item_id' => 'required|exists:stocks,id',
            'items.*.quantity'      => 'required|numeric|min:1',
            'items.*.unit'          => 'required|string',
            'stock_out_date'        => 'required|date',
        ]);

        foreach ($request->items as $item) {
            // Find stock record
            $stock = Stock::find($item['stock_item_id']);

            if (!$stock) {
                return back()->withErrors("Stock record not found!");
            }

            if ($stock->quantity < $item['quantity']) {
                return back()->withErrors("Not enough stock for {$stock->stockItem->stock_item_name}");
            }

            // Deduct stock quantity
            $stock->quantity -= $item['quantity'];
            $stock->save();

            StockOut::create([
                'stock_item_id'  => $stock->id,
                'quantity'       => $item['quantity'],
                'unit'           => $item['unit'],
                'received_by'    => $request->received_by ?? 'N/A',
                'reason'         => $request->reason ?? 'For Kitchen',
                'stock_out_date' => $request->stock_out_date,
            ]);
        }

        return redirect()->route('admin.stock.index')->with('success', 'Stock Out recorded successfully!');
    }

    public function show(StockOut $stockOut)
    {
        //
    }

    public function edit(StockOut $stockOut)
    {
        //
    }

    public function update(Request $request, StockOut $stockOut)
    {
        //
    }

    public function destroy(StockOut $stockOut)
    {
        //
    }
}
