@extends('admin.layouts.app')
@section('title', 'Edit Advance Payments')
@section('admin_content')
    <div class="page-content">

        <!-- Start Content-->
        <div class="page-container">


            <div class="row">
                <div class="col-12 mt-4">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header border-bottom border-light">
                            <h4 class="header-title mb-0 d-flex justify-content-between align-items-center">
                                <span>Advance Payment</span>
                                <a href="{{ route('admin.advance.payment.index') }}" class="btn btn-sm btn-primary">
                                    All Advance Payments
                                </a>
                            </h4>
                        </div>

                        <!-- Form -->
                        <div class="card-body">
                            <form class="row g-3" id="editAdvPaymentForm"
                                action="{{ route('admin.advance.payment.update', $advPayment->id) }}" method="POST">
                                @csrf
                                @method('PUT') {{-- Update method --}}


                                <!-- Advance Payment Date -->
                                <div class="col-md-6">
                                    <label class="form-label">Advance Payment Date</label>
                                    <input type="date" class="form-control form-control-sm" name="adv_payment_date"
                                        value="{{ $advPayment->adv_payment_date }}" readonly>
                                </div>

                                <!-- Employee (Read Only Text) -->
                                <div class="col-md-6">
                                    <label class="form-label">Employee</label>
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $advPayment->employe->employe_name ?? 'N/A' }}" readonly>
                                    <input type="hidden" name="employe_id" value="{{ $advPayment->employe_id }}">
                                </div>

                                <!-- Salary Month -->
                                <div class="col-md-6">
                                    <label class="form-label">Salary Month</label>
                                    <input type="month" class="form-control form-control-sm"
                                        value="{{ $advPayment->month_name }}" readonly>
                                    <input type="hidden" name="month_name" value="{{ $advPayment->month_name }}">
                                </div>

                                <!-- Salary (Read Only) -->
                                <div class="col-md-6">
                                    <label class="form-label">Salary</label>
                                    <input type="number" id="editSalaryInput" name="salary"
                                        class="form-control form-control-sm" value="{{ $advPayment->salary }}" readonly>
                                </div>

                                <!-- Paid -->
                                <div class="col-md-6">
                                    <label class="form-label">Paid</label>
                                    <input type="number" id="editPaidInput" name="adv_paid"
                                        class="form-control form-control-sm" value="{{ $advPayment->adv_paid }}">
                                </div>

                                <!-- Due Salary (Auto Calculated) -->
                                <div class="col-md-6">
                                    <label class="form-label">Due Salary</label>
                                    <input type="number" id="editDueInput" name="remaining_sallery"
                                        class="form-control form-control-sm" value="{{ $advPayment->remaining_sallery }}"
                                        readonly>
                                </div>

                                <!-- Submit -->
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            const salaryInput = document.getElementById("editSalaryInput");
            const paidInput = document.getElementById("editPaidInput");
            const dueInput = document.getElementById("editDueInput");

            function calculateDue() {
                const salary = parseFloat(salaryInput.value) || 0;
                let paid = parseFloat(paidInput.value) || 0;

                if (paid > salary) {
                    alert("Advance payment cannot be more than Salary!");
                    paid = salary;
                    paidInput.value = salary.toFixed(2);
                }

                const due = salary - paid;
                dueInput.value = due.toFixed(2);
            }

            paidInput.addEventListener("input", calculateDue);
        });
    </script>
@endpush
