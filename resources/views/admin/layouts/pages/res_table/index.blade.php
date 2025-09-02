@extends('admin.layouts.app')
@section('title', 'Resturant POS | Table List')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Table List</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Restaurant Table</li>
                    </ol>
                </div>
            </div>

            <!-- All res table Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Restaurant Table List </h4>
                            <div class="d-flex gap-2">
                                <!-- Add Restaurant Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addResTableModal">
                                    <i class="ti ti-plus me-1"></i> Add new
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
                                            <input type="checkbox" class="form-check-input" id="selectAllrestables">
                                        </th>
                                        <th>S/N</th>
                                        <th>Table Number</th>
                                        <th>Table capacity</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($resTables as $restable)
                                        <tr id="row_{{ $restable->id }}">
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $restable->table_number ?? '' }}</td>
                                            <td><span
                                                    class="text-dark fw-medium">{{ $restable->table_capacity ?? '' }}</span>
                                            </td>

                                            <td>
                                                @if ($restable->is_active == 0)
                                                    <span class="badge bg-danger">DeActive</span>
                                                @elseif ($restable->is_active == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">

                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle editrestableBtn"
                                                        data-id="{{ $restable->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editrestableModal" title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>

                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                        data-id="{{ $restable->id }}" title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No restables found.</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {!! $resTables->links() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Add restable Modal -->
            @include('admin.layouts.pages.res_table.create')
            @include('admin.layouts.pages.res_table.edit')

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
    $(document).on('click', '.editrestableBtn', function() {
        let tableId = $(this).data('id');

        // প্রথমে form clear করে দিচ্ছি
        $('#editrestableForm')[0].reset();
        $('#edit_table_id').val('');
        $('#editrestableForm').attr('action', '#'); // default খালি রাখা হলো

        // Optionally একটি loading text দেখাতে পারেন
        $('#edit_table_number').val('Loading...');

        $.ajax({
            url: '/admin/res-table/' + tableId + '/edit',
            type: "GET",
            success: function(response) {

                // Fill input fields
                $('#edit_table_id').val(response.id);
                $('#edit_table_number').val(response.table_number);
                $('#edit_table_capacity').val(response.table_capacity);
                $('#edit_is_active').val(response.is_active).trigger('change');

                // Update form action (with ID)
                if (response.id) {
                    $('#editrestableForm').attr('action', '/admin/res-table/' + response.id);
                }
            },
            error: function(xhr) {
                alert("Something went wrong while fetching data!");
            }
        });
    });
</script>



    <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/res-table/" + id;

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
