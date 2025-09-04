@extends('admin.layouts.app')

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
                    <h4 class="fs-18 fw-semibold mb-0">Supplier</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Supplier</li>
                    </ol>
                </div>
            </div>

            <!-- All Suppliers Data -->
            <!-- All Suppliers Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Supplier List</h4>
                            <div class="d-flex gap-2">
                                <!-- Add Supplier Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addSupplierModal">
                                    <i class="ti ti-plus me-1"></i> Add Supplier
                                </button>

                                <!-- Import Button with File Input -->
                                <div class="position-relative">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                            onclick="document.getElementById('importFileInput').click();">
                                        <i class="ti ti-file-import me-1"></i> Import
                                    </button>
                                    <input type="file" id="importFileInput" accept=".csv, .xlsx"
                                           style="display: none;" onchange="handleFileUpload(event)">
                                </div>
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
                                    <th>Logo</th>
                                    <th>Supplier ID</th>
                                    <th>Supplier Name</th>
                                    <th>Contact Person</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 150px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Example Supplier Row -->
                                <tr>
                                    <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                    <td>
                                        <img src="{{ asset('backend') }}/assets/images/suppliers/freshfoods.png" alt="Fresh Foods"
                                             class="img-thumbnail"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>SUP001</td>
                                    <td><span class="text-dark fw-medium">Fresh Foods Ltd.</span></td>
                                    <td>John Doe</td>
                                    <td>+880 1711-000000</td>
                                    <td>freshfoods@gmail.com</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="pe-3">
                                        <div class="hstack gap-1 justify-content-end">
                                            <a href="javascript:void(0);"
                                               class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                               title="View">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                               class="btn btn-soft-success btn-icon btn-sm rounded-circle"
                                               title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                               class="btn btn-soft-danger btn-icon btn-sm rounded-circle"
                                               title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Repeat similar rows dynamically -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link bg-primary text-white">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Supplier Modal -->
            <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form id="supplierForm">
                                <div class="row g-3">
                                    <!-- Supplier Name -->
                                    <div class="col-md-6">
                                        <label for="supplierName" class="form-label">Supplier Name</label>
                                        <input type="text" class="form-control" id="supplierName"
                                               placeholder="Enter supplier name" required>
                                    </div>
                                    <!-- Contact Person -->
                                    <div class="col-md-6">
                                        <label for="contactPerson" class="form-label">Contact Person</label>
                                        <input type="text" class="form-control" id="contactPerson"
                                               placeholder="Enter contact person name" required>
                                    </div>
                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone"
                                               placeholder="+880 1XXX-XXXXXX" required>
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                               placeholder="example@mail.com" required>
                                    </div>
                                    <!-- Address -->
                                    <div class="col-md-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" rows="2"
                                                  placeholder="Enter supplier address"></textarea>
                                    </div>
                                    <!-- Upload Logo -->
                                    <div class="col-md-6">
                                        <label for="logo" class="form-label">Upload Logo</label>
                                        <input type="file" class="form-control" id="logo" accept="image/*">
                                    </div>
                                    <!-- Status -->
                                    <div class="col-md-6 mb-3">
                                        <label for="choices-single-no-search"
                                               class="form-label text-muted">Status</label>
                                        <select class="form-control" id="choices-single-no-search"
                                                name="choices-single-no-search" data-choices data-choices-search-false
                                                data-choices-removeItem>
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="supplierForm" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>

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
