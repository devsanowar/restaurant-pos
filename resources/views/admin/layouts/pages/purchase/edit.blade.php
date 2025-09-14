@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Edit Purchase')

@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <!-- Page Title -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0"><i class="ti ti-shopping-cart me-2"></i> Edit Purchase </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Purchase</li>
                    </ol>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Update Purchase</h5>
                </div>

                <form action="{{ route('admin.purchase.update', $purchase->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <!-- Purchase Date & Supplier -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control"
                                       value="{{ $purchase->purchase_date }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Supplier</label>
                                <select class="form-select" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->supplier_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Select Item</label>
                                <select class="form-select" id="itemSelect">
                                    <option value="">Select Item</option>
                                    @foreach ($stockItems as $stockItem)
                                        <option value="{{ $stockItem->id }}"
                                                data-name="{{ $stockItem->stock_item_name }}">
                                            {{ $stockItem->stock_item_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Purchase Items Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="stockTable">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($purchase->items as $index => $item)
                                    <tr data-item-id="{{ $item->stock_item_id }}">
                                        <td class="row-index">{{ $index + 1 }}</td>
                                        <td>
                                            {{ $item->stockItem->stock_item_name }}
                                            <input type="hidden" name="items[{{ $item->stock_item_id }}][stock_item_id]" value="{{ $item->stock_item_id }}">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $item->stock_item_id }}][quantity]"
                                                   class="form-control qty" value="{{ $item->quantity }}" min="1">
                                        </td>
                                        <td>
                                            <select class="form-select unit" name="items[{{ $item->stock_item_id }}][unit]">
                                                <option value="pcs" {{ $item->unit == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                                <option value="kg" {{ $item->unit == 'kg' ? 'selected' : '' }}>Kg</option>
                                                <option value="ltr" {{ $item->unit == 'ltr' ? 'selected' : '' }}>Ltr</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $item->stock_item_id }}][unit_price]"
                                                   class="form-control price" value="{{ $item->unit_price }}" min="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control total"
                                                   value="{{ number_format($item->quantity * $item->unit_price, 2) }}" readonly>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger removeRow">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals, Invoice, Note -->
                        <div class="row mt-4">
                            <div class="col-md-6 col-lg-12 col-xl-6 col-xxl-8">

                            </div>
                            <div class="col-md-6 col-lg-12 col-xl-6 col-xxl-4">
                                <div class="card p-3 shadow-sm">

                                    <div class="d-flex justify-content-between gap-2 mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Invoice No.</label>
                                            <input type="text" class="form-control" name="invoice_no" value="{{ $purchase->invoice_no }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Upload Invoice</label>
                                            <input type="file" class="form-control" name="invoice">
                                            @if ($purchase->invoice)
                                                <small class="text-muted">Current: {{ asset($purchase->invoice) }}</small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between gap-2 mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Payment Method</label>
                                            <select name="payment_method" class="form-control">
                                                <option value="cash" {{ $purchase->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="bank" {{ $purchase->payment_method == 'bank' ? 'selected' : '' }}>Bank</option>
                                                <option value="mobile_banking" {{ $purchase->payment_method == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                                                <option value="credit" {{ $purchase->payment_method == 'credit' ? 'selected' : '' }}>Credit</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Transaction No.</label>
                                            <input type="text" class="form-control" name="transaction_no" value="{{ $purchase->transaction_no }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Purchase Note (Optional)</label>
                                        <textarea name="note" class="form-control" rows="3">{{ $purchase->note }}</textarea>
                                    </div>

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th style="width:60%">Subtotal:</th>
                                            <td><span id="subTotal">{{ number_format($purchase->items->sum(fn($i) => $i->quantity * $i->unit_price), 2) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Discount:</th>
                                            <td>
                                                <input type="number" id="discount" name="discount" class="form-control" value="{{ number_format($purchase->discount, 2) }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Grand Total:</th>
                                            <td>
                                                <span id="grandTotal">{{ $purchase->total_price }}</span>
                                                <input type="hidden" id="grandTotalInput" name="total_price" value="{{ $purchase->total_price }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Paid Amount:</th>
                                            <td>
                                                <input type="number" id="paidAmount" name="paid_amount" class="form-control" value="{{ $purchase->paid_amount }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Due Amount:</th>
                                            <td>
                                                <span id="dueAmount">{{ $purchase->due_amount }}</span>
                                                <input type="hidden" id="dueAmountInput" name="due_amount" value="{{ number_format($purchase->due_amount, 2) }}">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <button class="btn btn-primary mt-2 w-100" type="submit">Update Purchase</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('admin.layouts.pages.purchase.partials.purchase-script')
@endpush
