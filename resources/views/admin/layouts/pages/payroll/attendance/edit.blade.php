<div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAttendanceForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="attendance_id" id="attendance_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeName">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Late">Late</option>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
