<div class="modal fade" id="addResTableModal" tabindex="-1" aria-labelledby="addResTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addResTableModalLabel">Add Restaurant Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="resTableForm" action="{{ route('admin.res-table.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- table Number -->
                        <div class="col-md-12">
                            <label for="table_number" class="form-label">Table Number</label>
                            <input type="text" class="form-control" id="table_number" name="table_number"
                                placeholder="Enter table number" required>
                        </div>
                        <!-- table capacity -->
                        <div class="col-md-12">
                            <label for="table_capacity" class="form-label">Table Capacity</label>
                            <input type="text" class="form-control" id="table_capacity" name="table_capacity"
                                placeholder="Enter table capacity" required>
                        </div>
                        
                       
                        <!-- Status -->
                        <div class="col-md-12 mb-3">
                            <label for="is_active" class="form-label text-muted">Status</label>
                            <select class="form-control" id="is_active" name="is_active" data-choices
                                data-choices-search-false data-choices-removeItem>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                    </div>
                
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="resTableForm" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
