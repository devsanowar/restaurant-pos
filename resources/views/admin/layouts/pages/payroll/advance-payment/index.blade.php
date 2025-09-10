@extends('admin.layouts.app')
@section('title', 'All Advance payment')
@section('admin_content')
    <div class="page-content">

        <!-- Start Content-->
        <div class="page-container">

            <!-- Body Content -->
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">

                        <!-- Header -->
                        <div
                            class="card-header border-bottom border-light d-flex justify-content-between align-items-center">
                            <h4 class="header-title mb-0">Advance Payment</h4>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#advancePaymentModal">
                                + Add Payment
                            </button>
                        </div>


                        <!-- Filter Bar with Labels -->
                        <div class="card-body border-bottom py-2">

                            <form class="row g-2 align-items-end" id="filterForm">
                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Employee</label>
                                    <select class="form-select form-select-sm" name="employee_id">
                                        <option value="">Select Employee</option>
                                        @foreach ($employes as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->employe_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small mb-1">Salary Month</label>
                                    <input type="text" class="form-control form-control-sm" name="salaryMonth"
                                        placeholder="YYYY-MM">
                                </div>


                                <div class="col-md-2">
                                    <label class="form-label small mb-1">From Date</label>
                                    <input type="date" class="form-control form-control-sm" name="fromDate">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small mb-1">To Date</label>
                                    <input type="date" class="form-control form-control-sm" name="toDate">
                                </div>

                                <div class="col-md-1 d-grid">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Search</button>
                                </div>
                            </form>

                            <hr>




                            <div id="advanceTable">
                                @include('admin.layouts.pages.payroll.advance-payment.partials.table', [
                                    'advPayments' => $advPayments,
                                ])
                            </div>

                        </div>

                        @include('admin.layouts.pages.payroll.advance-payment.create')

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
        document.addEventListener("DOMContentLoaded", function() {
            let employeeSelect = document.getElementById("employeeSelect");
            let salaryInput = document.getElementById("salaryInput");

            employeeSelect.addEventListener("change", function() {
                let selectedOption = this.options[this.selectedIndex];
                let salary = selectedOption.getAttribute("data-salary") || 0;
                salaryInput.value = salary;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let salaryInput = document.getElementById("salaryInput");
            let paidInput = document.getElementById("paidInput");
            let dueInput = document.getElementById("dueInput");

            function calculateDue() {
                let salary = parseFloat(salaryInput.value) || 0;
                let paid = parseFloat(paidInput.value) || 0;

                // Check condition: Paid cannot be more than Salary
                if (paid > salary) {
                    alert("Advance payment cannot be more than Salary!");
                    paid = salary;
                    paidInput.value = salary.toFixed(2);
                }

                let due = salary - paid;
                dueInput.value = due.toFixed(2);
            }

            paidInput.addEventListener("input", calculateDue);
            salaryInput.addEventListener("input", calculateDue);
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#advPaymentSallery").submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: "{{ route('admin.advance.payment.store') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },

                    success: function(response) {
                        form[0].reset();
                        toastr.success(response.message ||
                            "Advance payment saved successfully!");
                        location.reload();
                        $("#advanceFormWrapper").hide();
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error("Something went wrong, please try again.");
                        }
                    },
                    complete: function() {
                        form.find("button[type=submit]").prop("disabled", false);
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {

            function loadFilteredData(formData) {
                $.ajax({
                    url: "{{ route('admin.advance.payment.filter') }}",
                    type: "GET",
                    data: formData,
                    success: function(res) {
                        $('#advanceTable').html(res.html);
                    }
                });
            }

            // Manual submit (for fromDate, toDate)
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                loadFilteredData($(this).serialize());
            });

            // Auto search for employee
            $('select[name="employee_id"]').on('change', function() {
                loadFilteredData($('#filterForm').serialize());
            });

            // Salary month live search
            $('input[name="salaryMonth"]').on('keyup', function() {
                let val = $(this).val();

                // যদি কিছু লেখা থাকে
                if (val.length > 0) {
                    loadFilteredData($('#filterForm').serialize());
                } else {
                    // যদি ফাঁকা হয়, সব data দেখাও
                    loadFilteredData({});
                }
            });

            // Pagination AJAX
            $(document).on('click', '#advanceTable .pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(res) {
                        $('#advanceTable').html(res.html);
                    }
                });
            });

        });
    </script>
@endpush
