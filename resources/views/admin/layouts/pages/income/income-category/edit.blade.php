<div class="modal fade" id="editIncomeCategoryModal" tabindex="-1" aria-labelledby="editIncomeCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editIncomeCategoryModalLabel">
                    <i class="ti ti-cash me-2"></i>Add New Income Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" id="editIncomeCategoryForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_income_cat_id">

                    <div class="mb-3">
                        <label for="editIncomeCategoryName" class="form-label">Income Category Name</label>
                        <input type="text" class="form-control" id="editIncomeCategoryName"
                            name="income_category_name" placeholder="Enter income category name" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
