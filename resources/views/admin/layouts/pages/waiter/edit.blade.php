<!-- Edit Waiter Modal -->
<div class="modal fade" id="editWaiterModal" tabindex="-1" aria-labelledby="editWaiterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editWaiterModalLabel"><i class="ti ti-user-edit me-2"></i>Edit Waiter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="editWaiterForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="waiter_id" id="edit_waiter_id">

                    <!-- Select Table -->
                    <div class="mb-3">
                        <label for="editWaiterTable" class="form-label">Select Table</label>
                        <select class="form-select" id="editWaiterTable" name="res_table_id" required>
                            <option value="">Select table</option>
                            @foreach ($resTables as $resTable)
                                <option value="{{ $resTable->id }}">{{ $resTable->table_number }}</option>
                            @endforeach
                        </select>

                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="editWaiterName" class="form-label">Waiter Name</label>
                        <input type="text" class="form-control" id="editWaiterName" name="waiter_name"
                            placeholder="Enter waiter name" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="editWaiterEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editWaiterEmail" name="waiter_email"
                            placeholder="Enter email address" required>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="editWaiterPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="editWaiterPhone" name="waiter_phone"
                            placeholder="+8801XXXXXXXXX" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="editWaiterStatus" class="form-label">Status</label>
                        <select class="form-select" id="editWaiterStatus" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editWaiterForm" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
