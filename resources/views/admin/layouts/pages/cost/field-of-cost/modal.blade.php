<div class="modal fade modal-top" id="addFieldOfCostModal" tabindex="-1" aria-labelledby="addFieldOfCostModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addFieldOfCostModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="fieldOfCostForm" method="POST" action="{{ route('admin.field-of-cost.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="fieldName" class="form-label">Field Name</label>
                        <input type="text" class="form-control" id="fieldName" name="field_name"
                            placeholder="Enter cost of field name" required>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" id="is_active" name="is_active">
                            <option selected>Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="fieldOfCostForm" class="btn btn-success bg-gradient">Save</button>
            </div>

        </div>
    </div>
</div>
