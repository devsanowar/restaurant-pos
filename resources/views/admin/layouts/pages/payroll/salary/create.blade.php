@extends('admin.layouts.app')
@section('title', 'Create Sallery')
@section('admin_content')
    <div class="page-content">

        <!-- Start Content-->
        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Add Salary</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restaurant</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Payroll</a></li>

                        <li class="breadcrumb-item active">Add Salary</li>
                    </ol>
                </div>
            </div>

            <!-- Body Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Card Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Add Salary</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.salary.index') }}" class="btn btn-primary btn-sm">All Salary</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form id="addSalaryForm">
                                @csrf
                                <div class="row g-3">

                                    <!-- Employee -->
                                    <div class="col-lg-12">
                                        <label for="employee" class="form-label">Select Employee <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="employee" name="employee_id" required>
                                            <option value="">-- Select Employee --</option>
                                            @foreach ($employes as $emp)
                                                <option value="{{ $emp->id }}"
                                                    data-salary="{{ $emp->employe_sallery }}">
                                                    {{ $emp->employe_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Starting Salary -->
                                    <div class="col-lg-12">
                                        <label for="startingSalary" class="form-label">Starting Salary <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="startingSalary"
                                            name="starting_salary" value="0.00" min="0" step="0.01" required
                                            readonly>
                                    </div>

                                    <!-- Increment Amount -->
                                    <div class="col-lg-12">
                                        <label for="incrementAmount" class="form-label">Increment Amount</label>
                                        <input type="number" class="form-control" id="incrementAmount"
                                            name="increment_amount" value="0.00" min="0" step="0.01">
                                    </div>

                                    <!-- Increment Effective From -->
                                    <div class="col-lg-12">
                                        <label for="incrementEffectiveFrom" class="form-label">Increment Effective
                                            From</label>
                                        <input type="date" class="form-control" id="incrementEffectiveFrom"
                                            name="increment_effective_from">
                                    </div>

                                    <!-- Present Salary -->
                                    <div class="col-lg-12">
                                        <label for="presentSalary" class="form-label">Present Salary</label>
                                        <input type="number" class="form-control" id="presentSalary" name="present_salary"
                                            value="0.00" step="0.01" readonly>
                                    </div>

                                    <!-- Salary Effective Date -->
                                    <div class="col-lg-12">
                                        <label for="salaryEffectiveDate" class="form-label">Salary Effective Date</label>
                                        <input type="date" class="form-control" id="salaryEffectiveDate"
                                            name="salary_effective_date">
                                    </div>

                                    <!-- Remarks -->
                                    <div class="col-lg-12">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                            placeholder="Optional notes">
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-lg-12 text-end mt-3">
                                        <div class="spinner-border text-primary d-none" id="spinner" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-user-plus me-1"></i> Save
                                        </button>
                                    </div>

                                </div>
                            </form>

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
    <script>
        // Employee select করলে starting salary বসবে
        document.getElementById('employee').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let salary = parseFloat(selectedOption.getAttribute('data-salary')) || 0;
            document.getElementById('startingSalary').value = salary.toFixed(2);
            calculatePresentSalary();
        });

        // Increment input listener
        document.getElementById('incrementAmount').addEventListener('input', calculatePresentSalary);

        // Calculate Present Salary
        function calculatePresentSalary() {
            let startingSalary = parseFloat(document.getElementById('startingSalary').value) || 0;
            let increment = parseFloat(document.getElementById('incrementAmount').value) || 0;

            let presentSalary = startingSalary + increment;

            document.getElementById('presentSalary').value = presentSalary.toFixed(2);
        }
    </script>

    <script>
        $(document).ready(function() {

            $('#addSalaryForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('#spinner').removeClass('d-none'); // show spinner

                $.ajax({
                    url: "{{ route('admin.salary.store') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#spinner').addClass('d-none'); // hide spinner
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#addSalaryForm')[0].reset(); // form reset
                            $('#presentSalary').val('0.00'); // present salary reset
                        } else {
                            toastr.error(response.message || 'Something went wrong!');
                        }
                    },
                    error: function(xhr) {
                        $('#spinner').addClass('d-none'); // hide spinner
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    }
                });
            });

        });
    </script>
@endpush
