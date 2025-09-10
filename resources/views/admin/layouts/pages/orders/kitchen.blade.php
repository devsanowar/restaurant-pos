<h2 style="text-align:center; color:#FF9800;">Kitchen Copy</h2>
<p>Table: {{ $order->table->table_number }}</p>
<p>Waiter: {{ $order->waiter->waiter_name }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>#</th><th>Product</th><th>Qty</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $i => $item)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
