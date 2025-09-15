<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Order Info -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Order ID:</strong> <span id="order-id"></span></p>
                        <p><strong>Table:</strong> <span id="table-number"></span></p>
                        <p><strong>Customer Phone:</strong> <span id="customer-phone"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong> <span id="order-date"></span></p>
                        <p><strong>Waiter:</strong> <span id="waiter-name"></span></p>
                        <p><strong>Status:</strong> <span class="btn btn-success btn-sm badge" id="order-status"></span></p>
                    </div>
                </div>

                <!-- Order Items -->
                <h6 class="fw-bold mb-2">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Total Price</th>
                        </tr>
                        </thead>
                        <tbody id="order-items-body">
                        <!-- Filled dynamically by JS -->
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Bill Amount</th>
                            <th class="text-end" id="order-total"></th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Paid Amount</th>
                            <th class="text-end" id="order-paid"></th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Due/Return Amount</th>
                            <th class="text-end" id="order-due"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
