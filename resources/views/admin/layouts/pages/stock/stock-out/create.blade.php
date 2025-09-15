@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Stock Out')

@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <!-- Page Title -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0"><i class="ti ti-package me-2"></i> Stock Out </h4>
                </div>
            </div>

            <!-- Stock Out Form -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Create Stock Out</h4>
                </div>

                <form action="{{ route('admin.stock-out.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Stock Out Date</label>
                                <input type="date" name="stock_out_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Received By (Optional)</label>
                                <input type="text" name="received_by" class="form-control" placeholder="Name of receiver">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Select Item</label>
                                <select class="form-select" id="itemSelect">
                                    <option value="">Select Item</option>
                                    @foreach ($stocks as $stock)
                                        <option value="{{ $stock->id }}" data-name="{{ $stock->stockItem->stock_item_name }}" data-qty="{{ $stock->quantity }}">
                                            {{ $stock->stockItem->stock_item_name }} (Available: {{ $stock->quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="stockTable">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Reason (Optional)</label>
                            <input type="text" name="reason" class="form-control" placeholder="Sale / Damage / Other">
                        </div>

                        <button class="btn btn-primary mt-3 right" type="submit">Save Stock Out</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tableBody = document.querySelector("#stockTable tbody");
            const itemSelect = document.getElementById("itemSelect");

            function updateRowNumbers() {
                tableBody.querySelectorAll("tr").forEach((row, index) => {
                    row.querySelector(".row-index").innerText = index + 1;
                });
            }

            itemSelect.addEventListener("change", function() {
                const selected = this.options[this.selectedIndex];
                const itemId = selected.value;
                const itemName = selected.dataset.name;
                const availableQty = parseInt(selected.dataset.qty);

                if(!itemId) return;

                if (tableBody.querySelector(`tr[data-item-id="${itemId}"]`)) {
                    alert("Item already added!");
                    this.value = "";
                    return;
                }

                const row = document.createElement("tr");
                row.setAttribute("data-item-id", itemId);
                row.innerHTML = `
            <td class="row-index"></td>
            <td>
                ${itemName}
                <input type="hidden" name="items[${itemId}][stock_item_id]" value="${itemId}">
            </td>
            <td>
                <input type="number" name="items[${itemId}][quantity]" class="form-control qty" value="1" min="1" max="${availableQty}">
            </td>
            <td>
                <select class="form-select unit" name="items[${itemId}][unit]">
                    <option value="pcs">Pcs</option>
                    <option value="kg">Kg</option>
                    <option value="ltr">Ltr</option>
                </select>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-trash"></i></button>
            </td>
        `;
                tableBody.appendChild(row);
                updateRowNumbers();
                this.value = "";
            });

            tableBody.addEventListener("click", function(e) {
                if(e.target.closest(".removeRow")){
                    e.target.closest("tr").remove();
                    updateRowNumbers();
                }
            });
        });
    </script>
@endpush
