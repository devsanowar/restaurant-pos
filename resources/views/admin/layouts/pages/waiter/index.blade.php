@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Waiter Management')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">

            <!-- Page Title and Breadcrumb -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">
                        <i class="ti ti-user-check me-2"></i> Waiter Management
                    </h4>
                    <p class="text-muted mb-0">Manage and assign waiters for your restaurant service.</p>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Waiter</li>
                    </ol>
                </div>
            </div>

            <!-- Waiter Management Card -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="ti ti-users me-2"></i> All Waiters</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWaiterModal">
                        <i class="ti ti-plus me-1"></i> Add New Waiter
                    </button>
                </div>

                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="d-flex align-items-center mb-3 gap-3 flex-wrap">

                        <!-- Search Box -->
                        <div class="flex-grow-1" style="max-width: 400px;">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search waiter...">
                            </div>
                        </div>

                        <!-- Filter Dropdown -->
                        <div style="min-width: 180px;">
                            <select class="form-select">
                                <option value="">Filter by Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
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


                    <!-- Waiter Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th><i class="ti ti-user"></i> Name</th>
                                    <th><i class="ti ti-mail"></i> Email</th>
                                    <th><i class="ti ti-phone"></i> Phone</th>
                                    <th><i class="ti ti-check"></i> Status</th>
                                    <th class="text-end"><i class="ti ti-settings"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($waiters as $key => $waiter)
                                    <tr id="row_{{ $waiter->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $waiter->waiter_name ?? '' }}</td>
                                        <td>{{ $waiter->waiter_email }}</td>
                                        <td>{{ $waiter->waiter_phone }}</td>
                                        <td>
                                            @if ($waiter->is_active == 1)
                                                <span class="badge bg-success">Active</span>
                                            @elseif ($waiter->is_active == 0)
                                                <span class="badge bg-danger">DeActive</span>
                                            @endif

                                        </td>
                                        <td class="text-end">
                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle editWaiterBtn"
                                                data-id="{{ $waiter->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editWaiterModal" title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                data-id="{{ $waiter->id }}" title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No waiters found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            {!! $waiters->links() !!}
                        </div>
                    </div>

                </div>
            </div>
            <!-- Add Waiter Modal -->
            @include('admin.layouts.pages.waiter.create')
            <!-- Edit Waiter Modal -->
            @include('admin.layouts.pages.waiter.edit')

        </div>


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
        $(document).on('click', '.editWaiterBtn', function() {
            let waiterId = $(this).data('id');

            $.ajax({
                url: '/admin/waiter/' + waiterId + '/edit',
                type: 'GET',
                success: function(waiter) {
                    $('#edit_waiter_id').val(waiter.id);
                    $('#editWaiterName').val(waiter.waiter_name);
                    $('#editWaiterEmail').val(waiter.waiter_email);
                    $('#editWaiterPhone').val(waiter.waiter_phone);
                    $('#editWaiterStatus').val(waiter.is_active);
                    $('#editWaiterTable').val(waiter.res_table_id); // <-- set selected table
                    $('#editWaiterStatus').val(waiter.is_active); // <-- set selected table

                    $('#editWaiterForm').attr('action', '/admin/waiter/' + waiter.id);
                }
            });
        });
    </script>

        <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/waiter/" + id;

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

@endpush
