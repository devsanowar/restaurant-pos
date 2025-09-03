@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Income Lists')
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
                        <i class="ti ti-user-check me-2"></i> Income Management
                    </h4>

                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Income</li>
                    </ol>
                </div>
            </div>

            <!-- Income Management Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="ti ti-users me-2"></i> Income lists</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
                        <i class="ti ti-plus me-1"></i> Add New Income
                    </button>
                </div>

                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="d-flex align-items-center mb-3 gap-3 flex-wrap">

                        <!-- Search Box -->
                        <!-- Search Box -->
                        <div class="flex-grow-1" style="max-width: 400px;">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input type="text" id="searchIncome" class="form-control" placeholder="Search income...">
                            </div>
                        </div>


                        <!-- Filter Dropdown -->

                        <!-- Filter Dropdown -->
                        <div style="min-width: 180px;">
                            <select id="filterStatus" class="form-select">
                                <option value="">Filter by Status</option>
                                <option value="received">Received</option>
                                <option value="pending">Pending</option>
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
                                    <th><i class="ti ti-user"></i> Date</th>
                                    <th><i class="ti ti-user"></i> Income Source</th>
                                    <th><i class="ti ti-mail"></i> Category</th>
                                    <th><i class="ti ti-phone"></i> Amount</th>
                                    <th><i class="ti ti-phone"></i> Income By</th>
                                    <th><i class="ti ti-check"></i> Status</th>
                                    <th class="text-end"><i class="ti ti-settings"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody id="waiterTableBody">
                                @forelse ($incomes as $key => $income)
                                    <tr id="row_{{ $income->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $income->income_date ?? '' }}</td>
                                        <td>{{ $income->income_source }}</td>
                                        <td>{{ $income->incomeCategory->income_category_name }}</td>
                                        <td>{{ $income->amount }}</td>
                                        <td>{{ $income->income_by }}</td>
                                        <td>
                                            @if ($income->status == 'received')
                                                <span class="badge bg-success">Received</span>
                                            @elseif ($income->status == 'pending')
                                                <span class="badge bg-danger">Pending</span>
                                            @endif

                                        </td>
                                        <td class="text-end">
                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle editIncomeBtn"
                                                data-id="{{ $income->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editIncomeModal" title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                data-id="{{ $income->id }}" title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No income found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            {!! $incomes->links() !!}
                        </div>
                    </div>

                </div>
            </div>
            <!-- Add Waiter Modal -->
            @include('admin.layouts.pages.income.create')
            <!-- Edit Waiter Modal -->
            @include('admin.layouts.pages.income.edit')

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
        $(document).on('click', '.editIncomeBtn', function() {
            let incomeId = $(this).data('id');

            $.ajax({
                url: '/admin/income/' + incomeId + '/edit',
                type: 'GET',
                success: function(income) {
                    $('#incomeId').val(income.id);
                    $('#incomeSourceInput').val(income.income_source);
                    $('#incomeCategorySelect').val(income.income_category_id);
                    $('#incomeAmountInput').val(income.amount);
                    $('#incomeDateInput').val(income.income_date);
                    $('#incomeStatusSelect').val(income.status);
                    $('#incomeByInput').val(income.income_by);

                    // Set form action for update
                    $('#incomeForm').attr('action', '/admin/income/' + income.id);
                    $('#incomeForm').attr('method', 'POST'); // Required for Laravel
                    $('#incomeForm').append('<input type="hidden" name="_method" value="PUT">');

                    // Show modal
                    $('#incomeModal').modal('show');
                }
            });
        });



        // update data

        $('#saveIncomeBtn').click(function(e) {
            e.preventDefault();

            let form = $('#incomeForm');
            let id = $('#incomeId').val(); // if empty, it's a new record
            let url = id ? '/admin/income/' + id : '/admin/income';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: 'POST', // always POST for Laravel
                data: form.serialize() + (id ? '&_method=PUT' : ''),
                success: function(response) {
                    alert(response.message); // or use toastr
                    $('#incomeModal').modal('hide');
                    // Optionally, update table row dynamically
                    location.reload(); // simple reload method
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON);
                    alert('Something went wrong!');
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
