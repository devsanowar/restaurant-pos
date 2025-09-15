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

            $subTotal = 0;

            foreach ($request->items as $item) {
                $subTotal += $item['item_qty'] * $item['item_purchase_price'];
            }

            $discount = $request->discount ?? 0;
            $totalPrice = $subTotal - $discount;
            $paid = $request->paid_amount ?? 0;
            $due = $totalPrice - $paid;

            // ✅ Now save purchase in one go
            $purchase = Purchase::create([
                'supplier_id'     => $request->supplier_id,
                'invoice_no'      => $request->invoice_no,
                'invoice'         => $invoicePath ?? null,
                'purchase_date'   => $request->purchase_date,
                'note'            => $request->note,
                'sub_total_price' => $subTotal,
                'total_price'     => $totalPrice,
                'discount'        => $discount,
                'paid_amount'     => $paid,
                'due_amount'      => $due,
                'payment_method'  => $request->payment_method ?? 'cash',
                'transaction_no'  => $request->transaction_no,
                'status'          => 'completed',
            ]);

            // now loop and save items + stock
            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'stock_item_id' => $item['stock_item_id'],
                    'quantity'      => $item['item_qty'],
                    'unit'          => $item['item_unit'],
                    'unit_price'    => $item['item_purchase_price'],
                    'total_price'   => $item['item_qty'] * $item['item_purchase_price'],
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
        });

        return redirect()->back()->with('success', 'Purchase saved successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.stockItem']);

        return view('admin.layouts.pages.purchase.show', compact('purchase'));
    }


    public function edit(Purchase $purchase)
    {
        // ✅ Load related items
        $purchase->load('items.stockItem', 'supplier');

        // ✅ Get suppliers and stock items for dropdowns
        $suppliers = Supplier::all();
        $stockItems = StockItem::all();

        return view('admin.layouts.pages.purchase.edit', compact('purchase', 'suppliers', 'stockItems'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        // ✅ Validation
        $request->validate([
            'supplier_id'           => 'required|exists:suppliers,id',
            'purchase_date'         => 'required|date',
            'items'                 => 'required|array|min:1',
            'items.*.stock_item_id' => 'required|exists:stock_items,id',
            'items.*.quantity'      => 'required|numeric|min:1',
            'items.*.unit_price'    => 'required|numeric|min:0',
            'items.*.unit'          => 'required|string',
        ]);

        DB::transaction(function () use ($request, $purchase) {

            // ✅ Handle invoice upload (replace old file if new one uploaded)
            $invoicePath = $purchase->invoice;
            if ($request->hasFile('invoice')) {
                if ($invoicePath && file_exists(public_path($invoicePath))) {
                    unlink(public_path($invoicePath));
                }
                $file = $request->file('invoice');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('uploads/invoices');
                if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
                $file->move($uploadPath, $fileName);
                $invoicePath = 'uploads/invoices/' . $fileName;
            }

            // ✅ Before updating, revert stock quantities of old items
            foreach ($purchase->items as $oldItem) {
                $stock = Stock::where('stock_item_id', $oldItem->stock_item_id)
                    ->where('supplier_id', $purchase->supplier_id)
                    ->first();
                if ($stock) {
                    $stock->quantity -= $oldItem->quantity;
                    $stock->save();
                }
            }

            // ✅ Delete old purchase items
            $purchase->items()->delete();

            // ✅ Recalculate totals
            $subTotal = 0;
            foreach ($request->items as $item) {
                $subTotal += $item['quantity'] * $item['unit_price'];
            }

            $discount = $request->discount ?? 0;
            $totalPrice = $subTotal - $discount;
            $paid = $request->paid_amount ?? 0;
            $due = $totalPrice - $paid;

            // ✅ Update purchase
            $purchase->update([
                'supplier_id'     => $request->supplier_id,
                'invoice_no'      => $request->invoice_no,
                'invoice'         => $invoicePath,
                'purchase_date'   => $request->purchase_date,
                'note'            => $request->note,
                'sub_total_price' => $subTotal,
                'total_price'     => $totalPrice,
                'discount'        => $discount,
                'paid_amount'     => $paid,
                'due_amount'      => $due,
                'payment_method'  => $request->payment_method ?? 'cash',
                'transaction_no'  => $request->transaction_no,
                'status'          => 'completed',
            ]);

            // ✅ Save new items & update stock
            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'stock_item_id' => $item['stock_item_id'],
                    'quantity'      => $item['quantity'],
                    'unit'          => $item['unit'],
                    'unit_price'    => $item['unit_price'],
                    'total_price'   => $item['quantity'] * $item['unit_price'],
                ]);

                $stock = Stock::firstOrCreate(
                    [
                        'stock_item_id' => $item['stock_item_id'],
                        'supplier_id'   => $request->supplier_id
                    ],
                    [
                        'quantity'         => 0,
                        'purchase_price'   => $item['unit_price'],
                        'unit'             => $item['unit'],
                        'stock_entry_date' => $request->purchase_date
                    ]
                );

                $stock->quantity += $item['quantity'];
                $stock->purchase_price = $item['unit_price'];
                $stock->stock_entry_date = $request->purchase_date;
                $stock->save();
            }
        });

        return redirect()->route('admin.purchase.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        if ($purchase->invoice && file_exists(public_path('uploads/purchases/' . $purchase->invoice))) {
            unlink(public_path('uploads/purchases/' . $purchase->invoice));
        }

        $purchase->items()->delete();

        $purchase->delete();

        return redirect()->route('admin.purchase.index')->with('success', 'Purchase deleted successfully!');
    }

}
