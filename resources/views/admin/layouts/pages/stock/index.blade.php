@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Stock Page')
@section('admin_content')
    <div class="page-content">

        <div class="page-container">

            <!-- Stock Content -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Stock Out Items</h5>
                </div>

                <div class="card-body">
                    <!-- Supplier & Stock Item Dropdowns -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <select class="form-select">
                                <option value="">Select Supplier</option>
                                <option value="1">Supplier A</option>
                                <option value="2">Supplier B</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Select Stock Item</label>
                            <select class="form-select" id="itemSelect">
                                <option value="">Select Item</option>
                                <option value="1" data-name="Chicken Breast">Chicken Breast</option>
                                <option value="2" data-name="French Fries">French Fries</option>
                                <option value="3" data-name="Beef">Beef</option>
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
                                    <th>Purchase Price</th>
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
                        <div class="col-md-6">
                            <label class="form-label">Upload Invoice</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Subtotal:</strong> <span id="subTotal">0</span></p>
                            <p><strong>Total:</strong> <span id="grandTotal">0</span></p>
                            <button class="btn btn-primary mt-2">Save Stock</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>2025 © Restaurant POS - By <span
                                class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance
                                IT</span>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
    @endsection

    @push('scripts')
        <!-- Script for Dynamic Rows -->
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
                <td>${itemName} <input type="hidden" name="items[]" value="${itemId}"></td>
                <td><input type="number" class="form-control qty" value="1" min="1"></td>
                <td>
                    <select class="form-select unit">
                        <option value="pcs">Pcs</option>
                        <option value="kg">Kg</option>
                        <option value="ltr">Ltr</option>
                    </select>
                </td>
                <td><input type="number" class="form-control price" value="0" min="0"></td>
                <td><input type="text" class="form-control total" value="0" readonly></td>
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
