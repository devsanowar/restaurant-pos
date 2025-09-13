<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockItemController extends Controller
{
    public function index(){
        $stockItems = StockItem::latest()->simplepaginate(30);
        $deletedItemCount = StockItem::onlyTrashed()->count();
        return view('admin.layouts.pages.stock.stock-item.index', compact('stockItems', 'deletedItemCount'));
    }

    public function store(Request $request){
        $request->validate([
            'stock_item_name' => 'required|string|max:255'
        ]);

        StockItem::create([
            'stock_item_name' => $request->stock_item_name
        ]);

        return redirect()->back()->with('success', 'Stock item added successfully.');
    }

    public function edit($id){
        $stockItem = StockItem::findOrFail($id);
        return response()->json($stockItem);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stock_item_name' => 'required|string|max:255',
        ]);

        $stockItem = StockItem::findOrFail($id);
        $stockItem->stock_item_name = $request->stock_item_name;
        $stockItem->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Updated Successfully.',
        ]);
    }

    public function destroy($id){
        $stockItem = StockItem::findOrfail($id);
        if (!$stockItem) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No stock item Found',
                ],
                404,
            );
        }
        $stockItem->delete();

        $deletedCount = StockItem::onlyTrashed()->count();
        return response()->json([
            'status' => 'success',
            'message' => 'Stock Item deleted successfully.',
            'deletedCount' => $deletedCount,
        ]);
    }


    public function trashedData()
    {
        $stockItems = StockItem::onlyTrashed()->get();
        $deletedCount = $stockItems->count();
        return view('admin.layouts.pages.stock.stock-item.recycle-bin', compact('stockItems', 'deletedCount'));
    }



    public function restoreData(Request $request)
    {
        $stockItem = StockItem::onlyTrashed()->where('id', $request->id)->first();

        if ($stockItem) {
            $stockItem->restore();

            $deletedCount = StockItem::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Stock Item Restored Successfully.',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'No Stock Item Found',
            ],
            404,
        );
    }

    public function forceDelete($id)
    {
        $stockItem = StockItem::onlyTrashed()->where('id', $id)->first();

        if ($stockItem) {
            $stockItem->forceDelete();
            $deletedCount = StockItem::onlyTrashed()->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Stock Item permanently deleted!',
                'deletedCount' => $deletedCount,
            ]);
        }

        return response()->json(
            [
                'status' => 'error',
                'message' => 'Stock Item not found',
            ],
            404,
        );
    }


}
