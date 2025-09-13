<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Restaurant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editRestaurantForm">
                    @csrf
                    
                    <input type="hidden" name="id" id="editRestaurantId">

                    <div class="mb-3">
                        <label for="editRestaurantName" class="form-label">Restaurant Name</label>
                        <input type="text" class="form-control" id="editRestaurantName"
                            name="restaurant_branch_name">
                    </div>

                    <div class="mb-3">
                        <label for="editRestaurantStatus" class="form-label">Select Status</label>
                        <select class="form-select" id="editRestaurantStatus" name="status">
                            <option value="">Select Restaurant....</option>
                            <option value="1">ON</option>
                            <option value="0">OFF</option>
                        </select>
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="editRestaurantForm">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
