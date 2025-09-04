<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addIncomeModalLabel">
                    <i class="ti ti-cash me-2"></i>Add New Income
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="incomeForm" action="{{ route('admin.income.store') }}" method="POST">
                    @csrf

                    <!-- Income Source -->
                    <div class="mb-3">
                        <label for="incomeSource" class="form-label">Income Source</label>
                        <input type="text" class="form-control" id="incomeSource" name="income_source"
                            placeholder="Enter income source" required>
                    </div>

                    <!-- Income Type -->
                    <div class="mb-3">
                        <label for="income_category_id" class="form-label">Income Type</label>
                        <select class="form-select" id="income_category_id" name="income_category_id">
                            @foreach ($incomeCategories as $incomeCat)
                            <option value="{{ $incomeCat->id }}">{{ $incomeCat->income_category_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Amount -->
                    <div class="mb-3">
                        <label for="incomeAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="incomeAmount" name="amount"
                            placeholder="Enter amount" required>
                    </div>

                    <!-- Income Date -->
                    <div class="mb-3">
                        <label for="incomeDate" class="form-label">Income Date</label>
                        <input type="date" class="form-control" id="incomeDate" name="income_date" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="incomeStatus" class="form-label">Status</label>
                        <select class="form-select" id="incomeStatus" name="status" required>
                            <option value="pending" selected>Pending</option>
                            <option value="received">Received</option>
                        </select>
                    </div>

                    <!-- Income By -->
                    <div class="mb-3">
                        <label for="incomeBy" class="form-label">Income By</label>
                        <input type="text" class="form-control" id="incomeBy" name="income_by"
                            placeholder="Enter person/organization name (optional)">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="incomeForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
