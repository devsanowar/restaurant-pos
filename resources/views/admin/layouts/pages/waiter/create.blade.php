 <div class="modal fade" id="addWaiterModal" tabindex="-1" aria-labelledby="addWaiterModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <!-- Modal Header -->
             <div class="modal-header bg-light">
                 <h5 class="modal-title" id="addWaiterModalLabel"><i class="ti ti-user-plus me-2"></i>Add
                     New Waiter</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <!-- Modal Body -->
             <div class="modal-body">
                 <form id="waiterForm" action="{{ route('admin.waiter.store') }}" method="POST">
                     @csrf
                     <!-- Select Table-->
                     <div class="mb-3">
                         <label for="waiterTable" class="form-label">Select Table</label>
                         <select class="form-select" id="waiterTable" name="res_table_id" required>
                             <option value="">Select table</option>
                             @foreach ($resTables as $resTable)
                                 <option value="{{ $resTable->id }}">{{ $resTable->table_number }}</option>
                             @endforeach
                         </select>
                     </div>

                     <!-- Name -->
                     <div class="mb-3">
                         <label for="waiterName" class="form-label">Waiter Name</label>
                         <input type="text" class="form-control" id="waiterName" name="waiter_name"
                             placeholder="Enter waiter name" required>
                     </div>

                     <!-- Email -->
                     <div class="mb-3">
                         <label for="waiterEmail" class="form-label">Email</label>
                         <input type="email" class="form-control" name="waiter_email" id="waiterEmail"
                             placeholder="Enter email address" required>
                     </div>

                     <!-- Phone -->
                     <div class="mb-3">
                         <label for="waiterPhone" class="form-label">Phone</label>
                         <input type="tel" class="form-control" id="waiterPhone" name="waiter_phone"
                             placeholder="+8801XXXXXXXXX" required>
                     </div>

                     <!-- Status -->
                     <div class="mb-3">
                         <label for="waiterStatus" class="form-label">Status</label>
                         <select class="form-select" id="waiterStatus" name="is_active" required>
                             <option value="">Select status</option>
                             <option value="Active">Active</option>
                             <option value="Inactive">Inactive</option>
                         </select>
                     </div>

             </div>

             <!-- Modal Footer -->
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                 <button type="submit" form="waiterForm" class="btn btn-primary">Save</button>
             </div>
             </form>
         </div>
     </div>
 </div>
