<!-- Add/Edit Income Modal -->
<div class="modal fade" id="editIncomeModal" tabindex="-1" aria-labelledby="editIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editIncomeModalLabel">
                    <i class="ti ti-cash me-2"></i><span id="modalTitle">Add New Income</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="incomeUpdateForm">
                    @csrf

                    <input type="hidden" id="incomeId" name="id">

                    <div class="mb-3">
                        <label for="incomeSource" class="form-label">Income Source</label>
                        <input type="text" class="form-control" id="incomeSourceInput" name="income_source"
                            placeholder="Enter income source" required>
                    </div>

                    <div class="mb-3">
                        <label for="income_category_id" class="form-label">Income Type</label>
                        <select class="form-select" id="incomeCategorySelect" name="income_category_id">
                            @foreach ($incomeCategories as $incomeCat)
                                <option value="{{ $incomeCat->id }}">{{ $incomeCat->income_category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="incomeAmount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="incomeAmountInput" name="amount"
                            placeholder="Enter amount" required>
                    </div>

                    <div class="mb-3">
                        <label for="incomeDate" class="form-label">Income Date</label>
                        <input type="date" class="form-control" id="incomeDateInput" name="income_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="incomeStatus" class="form-label">Status</label>
                        <select class="form-select" id="incomeStatusSelect" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="received">Received</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="incomeBy" class="form-label">Income By</label>
                        <input type="text" class="form-control" id="incomeByInput" name="income_by"
                            placeholder="Enter person/organization name (optional)">
                    </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveIncomeBtn" class="btn btn-primary">Save</button>
            </div>

            </form>

        </div>
    </div>
</div>
