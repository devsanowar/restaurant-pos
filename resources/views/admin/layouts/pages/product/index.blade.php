@extends('admin.layouts.app')
@section('title', 'All Product')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('admin_content')

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Products</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>

            <!-- All Suppliers Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Product List</h4>
                            <div class="d-flex gap-2">
                                <!-- Add Supplier Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addProductModal">
                                    <i class="ti ti-plus me-1"></i> Add Product
                                </button>

                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">
                                        <input type="checkbox" class="form-check-input" id="selectAllProducts">
                                    </th>
                                    <th>Image</th>
                                    <th>Product Category</th>
                                    <th>Product Name</th>
                                    <th>Costing Price</th>
                                    <th>Sales Price</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 150px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                    <td>
                                        <img src="{{ asset($product->image) }}" alt="Product"
                                             class="img-thumbnail"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td><span class="text-dark fw-medium">{{ $product->product_name }}</span></td>
                                    <td>{{ number_format($product->costing_price, 2) }}</td>
                                    <td>{{ number_format($product->sales_price, 2) }}</td>
                                    <td>
                                        @if($product->status == 'In Stock')
                                            <span class="badge bg-success">In Stock</span></td>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span></td>
                                        @endif
                                    <td class="pe-3">
                                        <div class="hstack gap-1 justify-content-end">

                                            <a href="{{ route('admin.product.show', $product->id) }}"
                                               class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                               title="View">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="javascript:void(0);"
                                               class="btn btn-soft-success btn-icon btn-sm rounded-circle editProductBtn"
                                               data-id="{{ $product->id }}"
                                               title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.product.destroy', $product->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"
                                                        title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Product Modal -->
                                @include('admin.layouts.pages.product.edit')

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $products->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Product Modal -->
            @include('admin.layouts.pages.product.create')

        </div> <!-- container -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <script>document.write(new Date().getFullYear())</script> © Restaurant POS - By <span
                            class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance
                                IT</span>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-md-block">
                            <a href="javascript: void(0);">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            $('.editProductBtn').on('click', function () {
                let id = $(this).data('id');

                // Build update URL dynamically
                let url = "{{ route('admin.product.update', ':id') }}";
                url = url.replace(':id', id);
                $('#productEditForm').attr('action', url);

                // (Optional) If you want to load product data via Ajax:
                $.get("{{ url('admin/product') }}/" + id + "/edit", function (data) {
                    $('#productCategory').val(data.product_category_id);
                    $('#productName').val(data.product_name);
                    $('#costingPrice').val(data.costing_price);
                    $('#salesPrice').val(data.sales_price);
                    $('#image').val('');
                    $('#editProductModal img').attr('src', '/' + data.image);
                    $('select[name="status"]').val(data.status);

                    // Show modal after filling form
                    $('#editProductModal').modal('show');
                });
            });
        });
    </script>

    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Delete confirmation for dynamically loaded content
            $(document).on('click', '.show_confirm', function(event) {
                event.preventDefault();
                let form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endpush
