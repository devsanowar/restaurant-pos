@extends('admin.layouts.app')
@section('title', 'Supplier')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
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
                            <h4 class="header-title mb-0">Supplier List <span>| <a href="{{ route('admin.supplier.deleted-data') }}">Recycle Bin (<span id="recycleCount">{{ $deletedSupplierCount }}</span>)</a></span></h4>
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
                                    <input type="file" id="importFileInput" accept=".csv, .xlsx" style="display: none;"
                                        onchange="handleFileUpload(event)">
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input" id="selectAllSuppliers">
                                        </th>
                                        <th>S/N</th>
                                        <th>Supplier Name</th>
                                        <th>Person</th>
                                        <th>Phone</th>
                                        <th>Opening balance</th>
                                        <th>Current balance</th>
                                        <th>balance Type</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($suppliers as $supplier)
                                        <tr id="row_{{ $supplier->id }}">
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $supplier->supplier_name ?? '' }}</td>
                                            <td><span
                                                    class="text-dark fw-medium">{{ $supplier->contact_person ?? '' }}</span>
                                            </td>
                                            <td>{{ $supplier->phone ?? '' }}</td>
                                            <td>{{ $supplier->opening_balance ?? '0.00' }}</td>
                                            <td>{{ $supplier->current_balance ?? '0.00' }}</td>
                                            <td>
                                                @if ($supplier->balance_type == 'receivable')
                                                    <span class="badge bg-success">Receivable</span>
                                                @elseif ($supplier->balance_type == 'payable')
                                                    <span class="badge bg-danger">Payable</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($supplier->is_active == 0)
                                                    <span class="badge bg-danger">DeActive</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                                        title="View">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle editSupplierBtn"
                                                        data-id="{{ $supplier->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editSupplierModal" title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>

                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                        data-id="{{ $supplier->id }}" title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No suppliers found.</td>
                                        </tr>
                                    @endforelse

                                    <!-- Repeat similar rows dynamically -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {!! $suppliers->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Supplier Modal -->
            @include('admin.layouts.pages.supplier.create')
            @include('admin.layouts.pages.supplier.edit')

        </div> <!-- container -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Restaurant POS - By <span
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
@endsection

@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>


        <script>
        $(document).on('click', '.editSupplierBtn', function() {
            let supplierId = $(this).data('id');

            // প্রথমে form clear করে দিচ্ছি
            $('#editSupplierForm')[0].reset();
            $('#edit_id').val('');
            $('#editSupplierForm').attr('action', '#');

            // Optionally একটি loading text দেখাতে পারেন
            $('#edit_supplierName').val('Loading...');

            $.ajax({
                url: "/admin/supplier/" + supplierId + "/edit",
                type: "GET",
                success: function(response) {
                    // Fill form fields with fresh data
                    $('#edit_id').val(response.id);
                    $('#edit_supplierName').val(response.supplier_name);
                    $('#edit_contactPerson').val(response.contact_person);
                    $('#edit_phone').val(response.phone);
                    $('#edit_email').val(response.email);
                    $('#edit_address').val(response.address);
                    $('#edit_opening_balance').val(response.opening_balance);
                    $('#edit_balance_type').val(response.balance_type).trigger('change');
                    $('#edit_is_active').val(response.is_active).trigger('change');

                    // Update form action URL
                    $('#editSupplierForm').attr('action', '/admin/supplier/' + response.id);
                }
            });
        });
    </script>


    <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/supplier/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This record will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "message");
                            $("#row_" + id).remove();
                            // location.reload();
                            $("#recycleCount").text(response.deletedCount);
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        });
    </script>


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
