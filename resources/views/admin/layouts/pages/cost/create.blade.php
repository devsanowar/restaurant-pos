<div class="modal fade modal-top" id="addCostModal" tabindex="-1" aria-labelledby="addCostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg for wider modal -->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addCostModalLabel">Add Cost</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="costForm" class="row g-3" method="POST" action="{{ route('admin.cost.store') }}">
                    @csrf
                    <!-- Date -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Cost Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Field of Cost -->
                    <div class="col-md-6">
                        <label for="field_id" class="form-label">Field of Cost</label>
                        <select class="form-select" id="field_id" name="field_id" required>
                            <option value="" disabled selected>Select Field</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->field_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Branch Name -->
                    <div class="col-md-6">
                        <label for="branch_name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control" id="branch_name" name="branch_name"
                            placeholder="Enter branch name">
                    </div>
                    <!-- Amount -->
                    <div class="col-md-6">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                            placeholder="Enter amount" required>
                    </div>
                    <!-- Spent By -->
                    <div class="col-md-6">
                        <label for="spend_by" class="form-label">Spent By</label>
                        <input type="text" class="form-control" id="spend_by" name="spend_by"
                            placeholder="Enter name" required>
                    </div>
                    <!-- Description (full width) -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description" placeholder="Enter description"></textarea>
                    </div>
                
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="costForm" class="btn btn-primary">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>
