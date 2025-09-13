<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productEditForm">
                    @csrf
                    @method('PUT')

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
                        <!-- Product Category -->
                        <div class="col-md-6">
                            <label for="productCategory" class="form-label">Product Category</label>
                            <select name="product_category_id" class="form-control" id="productCategory">
                                <option value=""> -- Select Category -- </option>
                                @foreach($productCategories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id === $product->product_category_id)> {{ $category->category_name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Product Name -->
                        <div class="col-md-6">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" id="productName"
                                   placeholder="Enter product name" required>
                        </div>
                        <!-- Costing Price -->
                        <div class="col-md-6">
                            <label for="costingPrice" class="form-label">Costing Price</label>
                            <input type="text" name="costing_price" value="{{ $product->costing_price }}" class="form-control" id="costingPrice"
                                   placeholder="Enter costing price" required>
                        </div>
                        <!-- Sales Price -->
                        <div class="col-md-6">
                            <label for="salesPrice" class="form-label">Sales Price</label>
                            <input type="text" name="sales_price" value="{{ $product->sales_price }}"  class="form-control" id="salesPrice"
                                   placeholder="Enter sales price" required>
                        </div>
                        <!-- Upload Image -->
                        <div class="col-md-6">
                            <label for="logo" class="form-label">Image</label>
                            <input type="file" name="image" value="{{ $product->image }}" class="form-control" id="image" accept="image/*">
                            <div class="mt-1">
                                <img src="{{ asset($product->image) }}" alt="" style="width:80px;height:80px;object-fit:cover;">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="choices-single-no-search" class="form-label text-muted">Status</label>
                            <select class="form-control" id="" name="status">
                                <option {{ $product->status == 'In Stock' ? 'selected' : '' }} value="In Stock">In Stock</option>
                                <option {{ $product->status == 'Out of Stock' ? 'selected' : '' }} value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="productEditForm" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
