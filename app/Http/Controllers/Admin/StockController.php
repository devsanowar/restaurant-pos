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
        $stocks = Stock::git ;
        return view('admin.layouts.pages.stock.index', compact('stocks'));
    }
}
