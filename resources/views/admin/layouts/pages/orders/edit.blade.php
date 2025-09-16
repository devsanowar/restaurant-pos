<div class="modal fade" id="orderEditModal" tabindex="-1" aria-labelledby="orderEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="order-edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="orderEditModalLabel">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Order Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Order ID:</strong> <span id="order-edit-id"></span></p>
                            <p><strong>Table:</strong> <span id="table-edit-number"></span></p>
                            <p><strong>Customer Phone:</strong> <span id="customer-edit-phone"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date:</strong> <span id="order-edit-date"></span></p>
                            <p><strong>Waiter:</strong> <span id="waiter-edit-name"></span></p>
                            <p><strong>Status:</strong>
                                <span id="order-edit-status"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h6 class="fw-bold mb-2">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Total Price</th>
                            </tr>
                            </thead>
                            <tbody id="order-edit-items-body">
                            <!-- Filled dynamically by JS -->
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Bill Amount</th>
                                <th class="text-end" id="order-edit-total"></th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Paid Amount</th>
                                <th class="text-end">
                                    <input type="text" id="order-edit-paid" name="paid" class="form-control text-end">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Due/Return Amount</th>
                                <th class="text-end" id="order-edit-due"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
