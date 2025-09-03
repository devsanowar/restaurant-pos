@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Income Category lists')
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
                        <i class="ti ti-user-check me-2"></i> Income Category Management
                    </h4>

                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Income category</li>
                    </ol>
                </div>
            </div>

            <!-- Income Management Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="ti ti-users me-2"></i> Income category lists</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addIncomeCategoryModal">
                        <i class="ti ti-plus me-1"></i> Add New
                    </button>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th><i class="ti ti-user"></i> Income Category Name</th>
                                    <th class="text-end"><i class="ti ti-settings"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody id="waiterTableBody">
                                @forelse ($incomeCategories as $key => $incomeCategory)
                                    <tr id="row_{{ $incomeCategory->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $incomeCategory->income_category_name ?? '' }}</td>

                                        <td class="text-end">
                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle editIncomeCategoryBtn"
                                                data-id="{{ $incomeCategory->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editIncomeCategoryModal" title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                data-id="{{ $incomeCategory->id }}" title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No income category found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <!-- Add Waiter Modal -->
            @include('admin.layouts.pages.income.income-category.create')
            <!-- Edit Waiter Modal -->
            @include('admin.layouts.pages.income.income-category.edit')

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
    $(document).on('click', '.editIncomeCategoryBtn', function() {
    let incomeCatId = $(this).data('id');

    $.ajax({
        url: '/admin/income-category/' + incomeCatId + '/edit',
        type: 'GET',
        success: function(incomeCategory) {
            $('#edit_income_cat_id').val(incomeCategory.id);
            $('#editIncomeCategoryName').val(incomeCategory.income_category_name);

            // dynamically form action set
            $('#editIncomeCategoryForm').attr('action', '/admin/income-category/' + incomeCategory.id);
        },
        error: function(xhr){
            console.log(xhr.responseText);
            alert('Failed to load data!');
        }
    });
});

</script>

<script>
$(document).on('submit', '#editIncomeCategoryForm', function(e) {
    e.preventDefault();

    let form = $(this);
    let actionUrl = form.attr('action'); // dynamically set url
    let formData = form.serialize(); // serialize form data

    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: formData,
        success: function(response) {
            // modal hide
            $('#editIncomeCategoryModal').modal('hide');

            // toastr success
            toastr.success(response.message, 'Success');

            // page reload (অথবা DataTable reload)
            setTimeout(() => {
                location.reload();
            }, 1000);
        },
        error: function(xhr) {
            let errorMsg = 'Update failed! Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            toastr.error(errorMsg, 'Error');
        }
    });
});
</script>



    <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/income-category/" + id;

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
        document.getElementById("searchWaiter").addEventListener("keyup", function() {
            let value = this.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach(function(row) {
                let name = row.querySelector("td:nth-child(2)").textContent
                    .toLowerCase(); // waiter_name column
                row.style.display = name.includes(value) ? "" : "none";
            });
        });

        // 🔽 Filter by Status
        document.getElementById("filterStatus").addEventListener("change", function() {
            let value = this.value;
            document.querySelectorAll("#waiterTableBody tr").forEach(function(row) {
                let status = row.querySelector("td:nth-child(5)").textContent.trim();
                if (value === "") {
                    row.style.display = "";
                } else if (value === "1" && status === "Active") {
                    row.style.display = "";
                } else if (value === "0" && status === "Inactive") {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
@endpush
