<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ Use the correct facade

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'res_table_id'   => 'required|exists:res_tables,id',
            'waiter_id'      => 'required|exists:waiters,id',
            'customer_phone' => 'required|string',
            'paid'           => 'required|numeric',
            'items'          => 'required|array|min:1',
        ]);

        $order = Order::create([
            'res_table_id'   => $request->res_table_id,
            'waiter_id'      => $request->waiter_id,
            'customer_phone' => $request->customer_phone,
            'total'          => $request->total,
            'paid'           => $request->paid,
            'due'            => $request->due,
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['qty'],
            ]);
        }

        $order->load('table', 'waiter', 'items');

        // Generate PDFs
        $pdf = Pdf::loadView('admin.layouts.pages.orders.three_copies', [
            'order' => $order,
            'items' => $order->items,
        ])->setPaper('a4', 'landscape');

        $pdfBase64 = base64_encode($pdf->output());

        return response()->json([
            'success'     => true,
            'order_id'    => $order->id,
            'pdf'         => $pdfBase64,
        ]);
    }

}
