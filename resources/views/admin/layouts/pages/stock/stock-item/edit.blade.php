<div class="modal fade" id="editStockItemModal" tabindex="-1" aria-labelledby="editStockItemModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editStockItemModalLabel">
                    <i class="ti ti-cash me-2"></i>Update Stock Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" id="updateStockItemForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_stock_item_id">

                    <div class="mb-3">
                        <label for="editStockItemName" class="form-label">Stock Item Name</label>
                        <input type="text" class="form-control" id="editStockItemName"
                            name="stock_item_name" placeholder="Enter stock item name" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
