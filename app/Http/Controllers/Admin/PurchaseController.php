<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('id', 'desc')->paginate(10);
        return view('admin.layouts.pages.purchase.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $stockItems = StockItem::all();
        return view('admin.layouts.pages.purchase.create', compact('suppliers', 'stockItems'));
    }

    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'supplier_id'                 => 'required|exists:suppliers,id',
            'purchase_date'               => 'required|date',
            'items'                       => 'required|array|min:1',
            'items.*.stock_item_id'       => 'required|exists:stock_items,id',
            'items.*.item_qty'            => 'required|numeric|min:1',
            'items.*.item_purchase_price' => 'required|numeric|min:0',
            'items.*.item_unit'           => 'required|string',
        ]);

        DB::transaction(function () use ($request) {

            // ✅ Invoice upload
            $invoicePath = null;
            if ($request->hasFile('invoice')) {
                $file = $request->file('invoice');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('uploads/invoices');
                if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
                $file->move($uploadPath, $fileName);
                $invoicePath = 'uploads/invoices/' . $fileName;
            }

            $grandTotal = 0;

            // ✅ 1. Create Purchase Master
            $purchase = Purchase::create([
                'supplier_id'    => $request->supplier_id,
                'invoice_no'     => $request->invoice_no,
                'invoice'        => $invoicePath,
                'purchase_date'  => $request->purchase_date,
                'note'           => $request->note,
                'total_price'    => 0,
                'discount'       => $request->discount ?? 0,
                'paid_amount'    => $request->paid_amount ?? 0,
                'due_amount'     => $request->due_amount ?? 0,
                'payment_method' => $request->payment_method ?? 'cash',
                'transaction_no' => $request->transaction_no,
                'status'         => 'completed',
            ]);

            foreach ($request->items as $item) {

                $itemTotal = $item['item_qty'] * $item['item_purchase_price'];
                $grandTotal += $itemTotal;

                // Save PurchaseItem
                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'stock_item_id' => $item['stock_item_id'],
                    'quantity'      => $item['item_qty'],
                    'unit'          => $item['item_unit'],
                    'unit_price'    => $item['item_purchase_price'],
                    'total_price'   => $itemTotal,
                ]);

                $stock = Stock::firstOrCreate(
                    [
                        'stock_item_id' => $item['stock_item_id'],
                        'supplier_id'   => $request->supplier_id
                    ],
                    [
                        'quantity'         => 0,
                        'purchase_price'   => $item['item_purchase_price'],
                        'unit'             => $item['item_unit'],
                        'stock_entry_date' => $request->purchase_date
                    ]
                );

                $stock->quantity += $item['item_qty'];
                $stock->purchase_price = $item['item_purchase_price'];
                $stock->stock_entry_date = $request->purchase_date;
                $stock->save();
            }

            $purchase->total_price = $grandTotal;
            $purchase->save();
        });

        return redirect()->back()->with('success', 'Purchase saved successfully.');
    }

    public function show(Purchase $purchase)
    {
        //
    }

    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        //
    }
}
