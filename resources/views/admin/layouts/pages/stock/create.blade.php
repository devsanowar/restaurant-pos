@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Stock Page')

@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <!-- Page Title and Breadcrumb -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">
                        <i class="ti ti-shopping-cart me-2"></i> Purchase </h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Purchase</li>
                    </ol>
                </div>
            </div>

            <!-- Stock Content -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Create Purchase</h5>
                </div>

                <form action="{{ route('admin.stock.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <!-- Supplier & Stock Item Dropdowns -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Purchase Date</label>
                                <input type="date" name="stock_entry_date" class="form-control"
                                       value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Supplier</label>
                                <select class="form-select" name="supplier_id" required >
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Select Purchase Item</label>
                                <select class="form-select" id="itemSelect">
                                    <option value="">Select Item</option>
                                    @foreach ($stockItems as $stockItem)
                                        <option value="{{ $stockItem->id }}" data-name="{{ $stockItem->stock_item_name }}">
                                            {{ $stockItem->stock_item_name }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                        <!-- Stock Table -->
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

                                </tbody>
                            </table>
                        </div>

                        <!-- Totals & File Upload -->
                        <div class="row mt-4">
                            <div class="col-md-4 offset-md-8">
                                <div class="card p-3 shadow-sm">
                                    <!-- Invoice Upload -->
                                    <div class="mb-3">
                                        <label class="form-label">Upload Invoice</label>
                                        <input type="file" class="form-control" name="invoice">
                                    </div>

                                    <!-- Stock Note -->
                                    <div class="mb-3">
                                        <label class="form-label">Purchase Note (Optional)</label>
                                        <textarea name="stock_note" class="form-control" rows="3"></textarea>
                                    </div>

                                    <!-- Totals & Save Button -->
                                    <div class="mb-2"><strong>Subtotal:</strong> <span id="subTotal">0</span></div>
                                    <div class="mb-2"><strong>Total:</strong> <span id="grandTotal">0</span></div>
                                    <button class="btn btn-primary mt-2 w-100">Save Purchase</button>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let tableBody = document.querySelector("#stockTable tbody");

            function updateRowNumbers() {
                document.querySelectorAll("#stockTable tbody tr").forEach((row, index) => {
                    row.querySelector(".row-index").innerText = index + 1;
                });
            }

            function updateTotals() {
                let subTotal = 0;
                document.querySelectorAll("#stockTable tbody tr").forEach((row) => {
                    let qty = parseFloat(row.querySelector(".qty").value) || 0;
                    let price = parseFloat(row.querySelector(".price").value) || 0;
                    let total = qty * price;
                    row.querySelector(".total").value = total.toFixed(2);
                    subTotal += total;
                });
                document.getElementById("subTotal").innerText = subTotal.toFixed(2);
                document.getElementById("grandTotal").innerText = subTotal.toFixed(2);
            }

            // When stock item is selected
            document.getElementById("itemSelect").addEventListener("change", function() {
                let selected = this.options[this.selectedIndex];
                let itemId = selected.value;
                let itemName = selected.dataset.name;

                if (itemId) {
                    let newRow = document.createElement("tr");
                    newRow.innerHTML = `
                        <td class="row-index"></td>
                        <td>
                            ${itemName}
                            <input type="hidden" name="items[${itemId}][stock_item_id]" value="${itemId}">
                        </td>
                        <td>
                            <input type="number" class="form-control qty" name="items[${itemId}][item_qty]" value="1" min="1">
                        </td>
                        <td>
                            <select class="form-select unit" name="items[${itemId}][item_unit]">
                                <option value="pcs">Pcs</option>
                                <option value="kg">Kg</option>
                                <option value="ltr">Ltr</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control price" name="items[${itemId}][item_purchase_price]" value="0" min="0">
                        </td>
                        <td>
                            <input type="text" class="form-control total" value="0" readonly>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-trash"></i></button>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                    updateRowNumbers();
                    updateTotals();
                    this.value = ""; // reset select after adding row
                }
            });

            // Delete row
            document.addEventListener("click", function(e) {
                if (e.target.closest(".removeRow")) {
                    e.target.closest("tr").remove();
                    updateRowNumbers();
                    updateTotals();
                }
            });

            // Update totals on qty/price change
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("qty") || e.target.classList.contains("price")) {
                    updateTotals();
                }
            });
        });
    </script>
@endpush
