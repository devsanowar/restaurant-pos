<!-- Modal -->
<div class="modal fade" id="advancePaymentModal" tabindex="-1" aria-labelledby="advancePaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="advancePaymentModalLabel">Add Advance Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form class="row g-3" id="advPaymentSallery">
                    @csrf

                    <input type="hidden" name="salary_id" id="salaryIdInput">

                    <!-- Date -->
                    <div class="col-md-6">
                        <label class="form-label">Advance Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" name="adv_payment_date"
                            value="2025-08-30" required>
                    </div>

                    <!-- Employee -->
                    <!-- Employee -->
                    <div class="col-md-6">
                        <label class="form-label">Advance Payment Date <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" name="employe_id" id="employeeSelect">
                        <option selected disabled>Select Employee</option>
                        @foreach ($employes as $employe)
                            <option value="{{ $employe->id }}" data-salary="{{ $employe->employe_sallery }}">
                                {{ $employe->employe_name }}
                            </option>
                        @endforeach
                    </select>
                    </div>


                    <!-- Salary Month -->
                    <div class="col-md-6">
                        <label class="form-label">Salary Month <span class="text-danger">*</span></label>
                        <input type="month" class="form-control form-control-sm" name="month_name" placeholder="example: september-2025" required>
                    </div>


                    <!-- Salary -->
                    <div class="col-md-6">
                        <label class="form-label">Salary</label>
                        <input type="number" id="salaryInput" name="salary" class="form-control form-control-sm"
                            value="0" readonly>
                    </div>

                    <!-- Paid -->
                    <div class="col-md-6">
                        <label class="form-label">Paid</label>
                        <input type="number" id="paidInput" class="form-control form-control-sm" name="adv_paid"
                            value="0">
                    </div>

                    <!-- Due Salary -->
                    <div class="col-md-6">
                        <label class="form-label">Due Salary</label>
                        <input type="number" id="dueInput" class="form-control form-control-sm"
                            name="remaining_sallery" value="0" readonly>
                    </div>


            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>
