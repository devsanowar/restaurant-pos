<div class="modal fade" id="editCostModal" tabindex="-1" aria-labelledby="editCostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editCostModalLabel">Edit Cost</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editCostForm" method="POST" action="" class="row g-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_cost_id" name="id">

                    <!-- Date -->
                    <div class="col-md-6">
                        <label for="edit_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="edit_date" name="date" required>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="edit_category_id" class="form-label">Cost Category</label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <option value="" disabled>Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Field -->
                    <div class="col-md-6">
                        <label for="edit_field_id" class="form-label">Field of Cost</label>
                        <select class="form-select" id="edit_field_id" name="field_id" required>
                            <option value="" disabled>Select Field</option>
                            @foreach($fields as $fld)
                                <option value="{{ $fld->id }}">{{ $fld->field_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Branch -->
                    <div class="col-md-6">
                        <label for="edit_branch_name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control" id="edit_branch_name" name="branch_name">
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label for="edit_amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="edit_amount" name="amount" required>
                    </div>

                    <!-- Spent By -->
                    <div class="col-md-6">
                        <label for="edit_spend_by" class="form-label">Spent By</label>
                        <input type="text" class="form-control" id="edit_spend_by" name="spend_by" required>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                            </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editCostForm" class="btn btn-primary">Update</button>
            </div>

        </div>
    </div>
</div>
