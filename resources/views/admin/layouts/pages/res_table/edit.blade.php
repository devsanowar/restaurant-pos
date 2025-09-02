<div class="modal fade" id="editrestableModal" tabindex="-1" aria-labelledby="editrestableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editrestableModalLabel">Edit Restaurant Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="editrestableForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="table_id" id="edit_table_id">

                    <div class="row g-3">
                        <!-- Table Number -->
                        <div class="col-md-12">
                            <label for="edit_table_number" class="form-label">Table Number</label>
                            <input type="text" class="form-control" id="edit_table_number" name="table_number"
                                placeholder="Enter table number" required>
                        </div>

                        <!-- Table Capacity -->
                        <div class="col-md-12">
                            <label for="edit_table_capacity" class="form-label">Table Capacity</label>
                            <input type="text" class="form-control" id="edit_table_capacity" name="table_capacity"
                                placeholder="Enter table capacity" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12 mb-3">
                            <label for="edit_is_active" class="form-label text-muted">Status</label>
                            <select class="form-control" id="edit_is_active" name="is_active" data-choices
                                data-choices-search-false data-choices-removeItem>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>

                        </div>
                    </div>

                    </form>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editrestableForm" class="btn btn-primary">Update</button>
            </div>
            
        </div>
    </div>
</div>
