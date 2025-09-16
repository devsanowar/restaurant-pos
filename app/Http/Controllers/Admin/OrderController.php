<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.layouts.pages.orders.index', compact('orders'));
    }

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

    public function show(Order $order)
    {
        if (request()->ajax()) {
            $order->load(['table', 'waiter', 'items']);
            return response()->json([
                'id'             => $order->id,
                'date'           => $order->created_at->format('d F, Y'),
                'table_number'   => $order->table->table_number ?? '-',
                'waiter_name'    => $order->waiter->waiter_name ?? '-',
                'customer_phone' => $order->customer_phone,
                'total'          => $order->total,
                'paid'           => $order->paid,
                'due'            => $order->due,
                'status'         => $order->due <= 0 ? 'Completed' : 'Pending',
                'items'          => $order->items->map(function($item) {
                    return [
                        'product_name' => $item->product_name,
                        'price'        => $item->price,
                        'quantity'     => $item->quantity,
                        'subtotal'     => $item->subtotal,
                    ];
                }),
            ]);
        }

        return view('admin.layouts.pages.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'paid' => 'required|numeric|min:0',
        ]);

        // Recalculate due
        $paid = $request->paid;
        $total = $order->total;
        $due = $total - $paid;

        // Update order
        $order->update([
            'paid' => $paid,
            'due'  => $due,
        ]);

        // Reload relations for PDF
        $order->load('table', 'waiter', 'items');

        // Generate PDF receipt
        $pdf = Pdf::loadView('admin.layouts.pages.orders.three_copies', [
            'order' => $order,
            'items' => $order->items,
        ])->setPaper('a4', 'landscape');

        $pdfBase64 = base64_encode($pdf->output());

        // If AJAX request (modal form)
        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'order_id' => $order->id,
                'pdf'      => $pdfBase64,
            ]);
        }

        // Fallback for normal form submit
        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }

}
