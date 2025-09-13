<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('admin.product-category.store') }}" method="POST" id="categoryForm" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <!-- Category Name -->
                        <div>
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" name="category_name" class="form-control" id="categoryName"
                                   placeholder="Enter category name" required>
                        </div>
                        <!-- Description -->
                        <div>
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="4" class="form-control"
                                      placeholder="Enter category description" required></textarea>
                        </div>
                        <!-- Category Image -->
                        <div>
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="choices-single-no-search"
                                   class="form-label text-muted">Status</label>
                            <select class="form-control" id="choices-single-no-search"
                                    name="is_active" data-choices data-choices-search-false
                                    data-choices-removeItem>
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
                <button type="submit" form="categoryForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
