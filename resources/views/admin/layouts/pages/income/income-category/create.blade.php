<div class="modal fade" id="addIncomeCategoryModal" tabindex="-1" aria-labelledby="addIncomeCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addIncomeCategoryModalLabel">
                    <i class="ti ti-cash me-2"></i>Add New Income Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="incomeCategoryForm" action="{{ route('admin.income.category.store') }}" method="POST">
                    @csrf

                    <!-- Income Source -->
                    <div class="mb-3">
                        <label for="incomeCategoryName" class="form-label">Income category name</label>
                        <input type="text" class="form-control" id="incomeCategoryName" name="income_category_name"
                            placeholder="Enter income category name" required>
                    </div>

                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="incomeCategoryForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
