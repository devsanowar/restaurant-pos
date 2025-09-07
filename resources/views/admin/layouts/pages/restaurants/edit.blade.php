<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Restaurant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editRestaurantForm">
          <input type="hidden" name="id" id="editRestaurantId">
          <div class="mb-3">
            <label for="editRestaurantName" class="form-label">Restaurant Name</label>
            <input type="text" class="form-control" id="editRestaurantName" name="name">
          </div>
          <!-- onno input fields -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="editRestaurantForm">Update</button>
      </div>
    </div>
  </div>
</div>
