@extends('admin.layouts.app')
@section('title', 'Sallery')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <!-- Start Content-->
        <div class="page-container">


            <!-- Body Content -->
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">

                        <!-- Card Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">All Salary list</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.salary.create') }}" class="btn btn-primary btn-sm">Add Salary</a>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="card-body border-bottom py-2">
                            <form id="salaryFilterForm" class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label mb-0">Employee Name</label>
                                    <select id="employeeFilter" class="form-select">
                                        <option value="">All Employees</option>
                                        @foreach ($employes as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->employe_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label mb-0">Designation</label>

                                    <select id="designationFilter" class="form-select">
                                        <option value="">All Designations</option>
                                        @foreach ($designations as $des)
                                            <option value="{{ $des }}">{{ $des }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </form>
                        </div>


                        <div class="table-responsive" id="salaryTable">
                            @include('admin.layouts.pages.payroll.salary.partials.salary_table', [
                                'salaries' => $salaries,
                            ])
                        </div>


                    </div>
                </div>
            </div>



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
        $('#employeeFilter, #designationFilter').on('change', function() {
            let employee_id = $('#employeeFilter').val();
            let designation = $('#designationFilter').val();

            $.ajax({
                url: "{{ route('admin.salary.filter') }}",
                method: "GET",
                data: {
                    employee_id: employee_id,
                    designation: designation
                },
                success: function(response) {
                    $('#salaryTable').html(response.html); // replace table body
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/salary/" + id;

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
