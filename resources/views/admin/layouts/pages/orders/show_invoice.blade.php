@extends('admin.layouts.app')

@section('content')
    <h2>Order #{{ $order->id }} Invoice</h2>

    <iframe id="pdfFrame" src="data:application/pdf;base64,{{ base64_encode($pdf) }}" width="100%" height="800px"></iframe>

    <div class="mt-2">
        <button onclick="printPdf()" class="btn btn-success">Print</button>
        <a href="{{ route('admin.orders.download', $order->id) }}" class="btn btn-primary">Download</a>
    </div>

    <script>
        function printPdf() {
            const iframe = document.getElementById('pdfFrame');
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }
    </script>
@endsection
