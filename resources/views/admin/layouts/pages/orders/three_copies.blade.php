<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: A5 landscape;
            margin: 10px;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Force three columns side by side for print */
        .all-print-copy-table {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 5px;
        }

        .copy {
            display: table-cell;
            width: 33.33%;
            border: 1px dashed #000;
            padding: 5px;
            vertical-align: top; /* top align all copies */
            box-sizing: border-box;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 5px;
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 4px;
            text-align: center;
        }

        p {
            font-size: 10px;
            margin: 2px 0;
        }
    </style>

</head>
<body>
<div class="all-print-copy-table">
    {{-- Office Copy --}}
    <div class="copy">
        <div class="title">Restaurant POS</div>
        <p style="text-align: center">Mymensingh Sadar, Mymensingh.</p>
        <p style="text-align: center; padding-top: 4px">Memo No. #00{{ $order->id }} | {{ $order->created_at->format('F d, Y') }}</p>
        <p style="text-align: center; font-size: 12px; background-color: black; color: white">
            Invoice <br>
            <span style="font-size: 8px">(Office Copy)</span>
        </p>
        <p style="text-align: center">{{ $order->table->table_number }} | Waiter: {{ $order->waiter->waiter_name }}</p>
        <p style="text-align: center">Customer Phone: {{ $order->customer_phone }}</p>
        <table>
            <thead>
            <tr><th>#</th><th>Product</th><th>Qty</th><th>Rate</th><th>Total</th></tr>
            </thead>
            <tbody>
            @foreach($items as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td style="text-align: left">{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->price * $item->quantity }}.00</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold">Total Amount: </td>
                    <td colspan="2" style="text-align: right; font-weight: bold">{{ $order->total }}.00</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold">Paid Amount: </td>
                    <td colspan="2" style="text-align: right; font-weight: bold">{{ $order->paid }}.00</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold">Return Amount: </td>
                    <td colspan="2" style="text-align: right; font-weight: bold">{{ $order->due }}.00</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Customer Copy --}}
    <div class="copy">
        <div class="title">Restaurant POS</div>
        <p style="text-align: center">Mymensingh Sadar, Mymensingh.</p>
        <p style="text-align: center">Memo No. #00{{ $order->id }} | {{ $order->created_at->format('F d, Y') }}</p>
        <p style="text-align: center; font-size: 12px; background-color: black; color: white">
            Invoice <br>
            <span style="font-size: 8px">(Customer Copy)</span>
        </p>
        <p style="text-align: center">{{ $order->table->table_number }} | Waiter: {{ $order->waiter->waiter_name }}</p>
        <p style="text-align: center">Customer Phone: {{ $order->customer_phone }}</p>
        <table>
            <thead>
            <tr><th>#</th><th>Product</th><th>Qty</th><th>Rate</th><th>Total</th></tr>
            </thead>
            <tbody>
            @foreach($items as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td style="text-align: left">{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->price * $item->quantity }}.00</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold">Total Amount: </td>
                <td colspan="2" style="text-align: right; font-weight: bold">{{ $order->total }}.00</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold">Paid Amount: </td>
                <td colspan="2" style="text-align: right; font-weight: bold">{{ $order->paid }}.00</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold">Return Amount: </td>
                <td colspan="2" style="text-align: right; font-weight: bold">{{ $order->due }}.00</td>
            </tr>
            </tfoot>
        </table>
    </div>

    {{-- Kitchen Copy --}}
    <div class="copy">
        <div class="title">Restaurant POS</div>
        <p style="text-align: center">Mymensingh Sadar, Mymensingh.</p>
        <p style="text-align: center">Memo No. #00{{ $order->id }} | {{ $order->created_at->format('F d, Y') }}</p>
        <p style="text-align: center; font-size: 12px; background-color: black; color: white">
            Invoice <br>
            <span style="font-size: 8px">(Kitchen Copy)</span>
        </p>
        <p style="text-align: center">{{ $order->table->table_number }} | Waiter: {{ $order->waiter->waiter_name }}</p>
        <table>
            <thead>
            <tr><th>#</th><th>Product</th><th>Qty</th></tr>
            </thead>
            <tbody>
            @foreach($items as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td style="text-align: left">{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
