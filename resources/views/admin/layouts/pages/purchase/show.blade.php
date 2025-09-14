@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Purchase Detail')

@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <!-- Page Title -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0"><i class="ti ti-shopping-cart me-2"></i> Purchase Detail </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Purchase Detail</li>
                    </ol>
                </div>
            </div>

            <!-- Purchase Detail Card -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Purchase Information</h5>
                </div>

                <div class="card-body">

                    <!-- Purchase Date & Supplier -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Purchase Date</label>
                            <p>{{ $purchase->purchase_date }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Supplier</label>
                            <p>{{ $purchase->supplier->supplier_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Invoice No.</label>
                            <p>{{ $purchase->invoice_no }}</p>
                        </div>
                    </div>

                    <!-- Purchase Items Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($purchase->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->stockItem->stock_item_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ ucfirst($item->unit) }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment & Totals -->
                    <div class="row mt-4">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-8">
                            @if($purchase->note)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Purchase Note</label>
                                    <p>{{ $purchase->note }}</p>
                                </div>
                            @endif

                            @if($purchase->invoice)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Invoice File</label>
                                    <p><a href="{{ asset($purchase->invoice) }}" target="_blank">View Invoice</a></p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                            <div class="card p-3 shadow-sm">
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td>{{ number_format($purchase->items->sum(fn($i) => $i->quantity * $i->unit_price), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount:</th>
                                        <td>{{ number_format($purchase->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Grand Total:</th>
                                        <td>{{ number_format($purchase->total_price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Paid Amount:</th>
                                        <td>{{ number_format($purchase->paid_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Due Amount:</th>
                                        <td>{{ number_format($purchase->due_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method:</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $purchase->payment_method)) }}</td>
                                    </tr>
                                    @if($purchase->transaction_no)
                                        <tr>
                                            <th>Transaction No:</th>
                                            <td>{{ $purchase->transaction_no }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
