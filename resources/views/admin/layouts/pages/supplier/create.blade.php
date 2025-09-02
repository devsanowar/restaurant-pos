<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="supplierForm" action="{{ route('admin.supplier.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Supplier Name -->
                        <div class="col-md-6">
                            <label for="supplierName" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="supplierName" name="supplier_name"
                                placeholder="Enter supplier name" required>
                        </div>
                        <!-- Contact Person -->
                        <div class="col-md-6">
                            <label for="contactPerson" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="contactPerson" name="contact_person"
                                placeholder="Enter contact person name" required>
                        </div>
                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="+880 1XXX-XXXXXX" required>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="example@mail.com" required>
                        </div>
                        <!-- Address -->
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="2" name="address" placeholder="Enter supplier address"></textarea>
                        </div>

                        <!-- Opening Balance -->
                        <div class="col-md-12">
                            <label for="opening_balance" class="form-label">Opening Balance</label>
                            <input type="number" class="form-control" name="opening_balance" id="opening_balance"
                                placeholder="0.00" required>
                        </div>


                        <!-- Balance Type -->
                        <div class="col-md-6 mb-3">
                            <label for="balance_type" class="form-label text-muted">Balance Type</label>
                            <select class="form-control" name="balance_type" id="balance_type" data-choices
                                data-choices-search-false data-choices-removeItem>
                                <option value="payable">Payable</option>
                                <option value="receivable">Receivable</option>
                            </select>
                        </div>
                       
                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label text-muted">Status</label>
                            <select class="form-control" id="is_active" name="is_active" data-choices
                                data-choices-search-false data-choices-removeItem>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                    </div>
                
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="supplierForm" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
