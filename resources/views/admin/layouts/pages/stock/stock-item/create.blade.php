<div class="modal fade" id="addStockItemModal" tabindex="-1" aria-labelledby="addStockItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addStockItemModalLabel">
                    <i class="ti ti-cash me-2"></i>Add New stock item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="stockItemForm" action="{{ route('admin.stock.item.store') }}" method="POST">
                    @csrf

                    <!-- Income Source -->
                    <div class="mb-3">
                        <label for="stockItemName" class="form-label">Stock Item name</label>
                        <input type="text" class="form-control" id="stockItemName" name="stock_item_name"
                            placeholder="Enter stock item name" required>
                    </div>

                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="stockItemForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
