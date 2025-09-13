@extends('admin.layouts.app')
@section('title', 'All Product Category')
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
                    <h4 class="fs-18 fw-semibold mb-0">Product Categories</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Product Categories</li>
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
                            <h4 class="header-title mb-0">Product Category List</h4>
                            <div class="d-flex gap-2">
                                <!-- Add Supplier Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addCategoryModal">
                                    <i class="ti ti-plus me-1"></i> Add Category
                                </button>

                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">
                                        <input type="checkbox" class="form-check-input" id="selectAllSuppliers">
                                    </th>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 150px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($productCategories as $productCategory)
                                <tr>
                                    <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                    <td>
                                        <img src="{{ asset($productCategory->image) }}" alt="Product Category"
                                             class="img-thumbnail"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td><span class="text-dark fw-medium">{{ $productCategory->category_name }}</span></td>
                                    <td>{{ $productCategory->category_slug }}</td>
                                    <td>{{ $productCategory->description }}</td>
                                    <td>
                                        @if($productCategory->is_active == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Deactive</span>
                                        @endif
                                    </td>
                                    <td class="pe-3">
                                        <div class="hstack gap-1 justify-content-end">

                                            <!-- View -->
                                            <a href="{{ route('admin.product-category.show', $productCategory->id) }}"
                                               class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                               title="View">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="javascript:void(0);"
                                               class="btn btn-soft-success btn-icon btn-sm rounded-circle editCategoryBtn"
                                               data-id="{{ $productCategory->id }}"
                                               data-name="{{ $productCategory->category_name }}"
                                               data-description="{{ $productCategory->description }}"
                                               data-image="{{ asset($productCategory->image) }}"
                                               data-status="{{ $productCategory->is_active }}"
                                               title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.product-category.destroy', $productCategory->id) }}"
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
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-2">
                            {{ $productCategories->links('pagination::bootstrap-5') }}
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($productCategories->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $productCategories->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($productCategories->getUrlRange(1, $productCategories->lastPage()) as $page => $url)
                                        <li class="page-item {{ $productCategories->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $productCategories->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($productCategories->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $productCategories->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
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

            <!-- Add Category Modal -->
            @include('admin.layouts.pages.product-category.create')

            <!-- Edit Modal -->
            @include('admin.layouts.pages.product-category.edit')

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
        $(document).ready(function() {
            $('.editCategoryBtn').on('click', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let description = $(this).data('description');
                let image = $(this).data('image');
                let status = $(this).data('status');

                // Fill modal fields
                $('#edit_category_name').val(name);
                $('#edit_description').val(description ?? '');
                $('#edit_is_active').val(String(status)).trigger('change');

                // Image preview
                if(image){
                    $('#preview_image').html(`<img src="${image}" class="img-thumbnail" style="width:80px;height:80px;object-fit:cover;">`);
                } else {
                    $('#preview_image').html('');
                }

                // Update form action dynamically
                let url = "{{ route('admin.product-category.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editCategoryForm').attr('action', url);

                // Show modal
                $('#editCategoryModal').modal('show');
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
