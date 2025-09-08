<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stock;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StockItem;
use App\Models\Supplier;
use Intervention\Image\Laravel\Facades\Image;
class StockController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $stockItems = StockItem::all();
        return view('admin.layouts.pages.stock.index', compact('suppliers', 'stockItems'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'supplier_id' => 'required|exists:suppliers,id',
        //     'stock_entry_date' => 'required|date',
        //     'items' => 'required|array|min:1',
        //     'items.*.stock_item_id' => 'required|exists:stock_items,id',
        //     'items.*.item_qty' => 'required|numeric|min:1',
        //     'items.*.item_purchase_price' => 'required|numeric|min:0',
        //     'items.*.item_unit' => 'required|string',
        // ]);

        // invoice file upload
        $newInvoicePath = null;
        if ($request->hasFile('invoice')) {
            $invoice = $request->file('invoice');
            $fileName = time() . '_' . uniqid() . '.' . $invoice->getClientOriginalExtension();
            $uploadPath = public_path('uploads/invoices');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $invoice->move($uploadPath, $fileName);

            $newInvoicePath = 'uploads/invoices/' . $fileName;
        }

        // 1. প্রথমে master stock create করবো
        $stock = new Stock();
        $stock->supplier_id = $request->supplier_id;
        $stock->stock_entry_date = $request->stock_entry_date ?? now()->toDateString();
        $stock->stock_type = 'stock_in';
        $stock->stock_note = $request->stock_note ?? null;
        $stock->invoice = $newInvoicePath;
        $stock->total_price = 0; // পরে আপডেট হবে
        $stock->save();

        $grandTotal = 0;

        // 2. Purchase items save করবো
        foreach ($request->items as $item) {
            $itemTotal = $item['item_qty'] * $item['item_purchase_price'];
            $grandTotal += $itemTotal;

            PurchaseItem::create([
                'stock_id' => $stock->id,
                'stock_item_id' => $item['stock_item_id'],
                'item_qty' => $item['item_qty'],
                'item_unit' => $item['item_unit'],
                'item_purchase_price' => $item['item_purchase_price'],
                'item_total_price' => $itemTotal,
            ]);
        }

        // 3. Master stock এ total update করবো
        $stock->total_price = $grandTotal;
        $stock->save();

        return redirect()->back()->with('success', 'Stock purchase saved successfully.');
    }
}
