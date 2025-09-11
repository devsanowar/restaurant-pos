@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Purchase Page')

@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <!-- Page Title -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0"><i class="ti ti-shopping-cart me-2"></i> Purchase </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Purchase</li>
                    </ol>
                </div>
            </div>

            <!-- Purchase Form -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Create Purchase</h4>
                    <div class="d-flex gap-2">
                        <!-- Add Purchase Button -->
                        <a href="{{ route('admin.purchase.index') }}" class="btn btn-primary btn-sm">
                            All Purchase
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.purchase.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <!-- Purchase Date & Supplier -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Supplier</label>
                                <select class="form-select" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Select Item</label>
                                <select class="form-select" id="itemSelect">
                                    <option value="">Select Item</option>
                                    @foreach ($stockItems as $stockItem)
                                        <option value="{{ $stockItem->id }}" data-name="{{ $stockItem->stock_item_name }}">{{ $stockItem->stock_item_name }}</option>
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
                                <tbody></tbody>
                            </table>
                        </div>

                        <!-- Totals, Invoice, Note -->
                        <div class="row mt-4">
                            <div class="col-md-4 offset-md-8">
                                <div class="card p-3 shadow-sm">

                                    <div class="d-flex justify-content-between gap-2 mb-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Invoice No.</label>
                                            <input type="text" class="form-control" name="invoice_no">
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label">Upload Invoice</label>
                                            <input type="file" class="form-control" name="invoice">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between gap-2 mb-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Payment Method</label>
                                            <select name="payment_method" id="" class="form-control">
                                                <option value="cash">Cash</option>
                                                <option value="bank">Bank</option>
                                                <option value="mobile_banking">Mobile Manking</option>
                                                <option value="credit">Credit</option>
                                            </select>
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label">Transaction No.</label>
                                            <input type="text" class="form-control" name="transaction_no">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Purchase Note (Optional)</label>
                                        <textarea name="note" class="form-control" rows="3"></textarea>
                                    </div>

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th style="width:60%">Subtotal:</th>
                                            <td><span id="subTotal">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <th>Discount:</th>
                                            <td>
                                                <input type="number" id="discount" name="discount" class="form-control" value="0.00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Grand Total:</th>
                                            <td>
                                                <span id="grandTotal">0.00</span>
                                                <input type="hidden" id="grandTotalInput" name="total_price" value="0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Paid Amount:</th>
                                            <td>
                                                <input type="number" id="paidAmount" name="paid_amount" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Due Amount:</th>
                                            <td>
                                                <span id="dueAmount">0.00</span>
                                                <input type="hidden" id="dueAmountInput" name="due_amount" value="0">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <button class="btn btn-primary mt-2 w-100" type="submit">Save Purchase</button>
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
