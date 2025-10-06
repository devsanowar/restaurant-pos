<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\CostCategory;
use App\Models\FieldOfCost;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\ResTable;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\StockOut;
use App\Models\Supplier;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function purchase(Request $request)
    {
        $query = Purchase::query();

        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $query->whereDate('purchase_date', Carbon::today());
        }

        if ($request->filled('start_date')) {
            $query->whereDate('purchase_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('purchase_date', '<=', $request->end_date);
        }

        if ($request->filled('supplier_name')) {
            $query->where('supplier_id', $request->supplier_name);
        }

        $purchases = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $suppliers = Supplier::latest()->get();

        return view('admin.layouts.pages.report.purchase', compact('purchases', 'suppliers'));
    }

    public function stock(Request $request)
    {
        $query = Stock::query();

        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $query->whereDate('stock_entry_date', Carbon::today());
        }

        if ($request->filled('start_date')){
            $query->whereDate('stock_entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')){
            $query->whereDate('stock_entry_date', '<=', $request->end_date);
        }

        if ($request->filled('supplier_name')) {
            $query->where('supplier_id', $request->supplier_name);
        }

        if ($request->filled('stock_item_name')) {
            $query->where('stock_item_id', $request->stock_item_name);
        }

        $stocks = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $suppliers = Supplier::latest()->get();
        $stockItems = StockItem::latest()->get();

        return view('admin.layouts.pages.report.stock', compact('stocks', 'suppliers', 'stockItems'));
    }

    public function stockOut(Request $request)
    {
        $query = StockOut::query();

        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $query->whereDate('stock_out_date', Carbon::today());
        }

        if ($request->filled('start_date')) {
            $query->whereDate('stock_out_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('stock_out_date', '<=', $request->end_date);
        }

        if ($request->filled('stock_item_name')) {
            $query->where('stock_item_id', $request->stock_item_name);
        }

        if ($request->filled('received_by')) {
            $query->where('received_by', $request->received_by);
        }

        $stockOuts = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $stockItems = StockItem::latest()->get();
        $receivers = StockOut::select('received_by')->distinct()->get();

        return view('admin.layouts.pages.report.stock-out', compact('stockOuts', 'stockItems', 'receivers'));
    }

    public function sales(Request $request)
    {
        $query = Order::query();

        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('table_number')) {
            $query->where('res_table_id', $request->table_number);
        }

        if ($request->filled('waiter_name')) {
            $query->where('waiter_id', $request->waiter_name);
        }

        $sales = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $resTables = ResTable::latest()->get();
        $waiters = Waiter::latest()->get();

        return view('admin.layouts.pages.report.sales', compact('sales', 'resTables', 'waiters'));
    }

    public function cost(Request $request)
    {
        $query = Cost::query();

        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $query->whereDate('date', Carbon::today());
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->filled('cost_category_name')) {
            $query->where('category_id', $request->cost_category_name);
        }

        if ($request->filled('cost_field_name')) {
            $query->where('field_id', $request->cost_field_name);
        }

        if ($request->filled('spend_by')) {
            $query->where('spend_by', $request->spend_by);
        }

        $costs = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $costCategories = CostCategory::latest()->get();
        $fieldOfCosts = FieldOfCost::latest()->get();
        $spendBy = Cost::select('spend_by')->distinct()->get();

        return view('admin.layouts.pages.report.cost', compact('costs', 'costCategories', 'fieldOfCosts', 'spendBy'));
    }

}
