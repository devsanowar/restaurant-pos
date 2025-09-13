<!-- Employee Attendance View Modal -->
<div class="modal fade" id="viewAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background-color:#f8f9fa; border-bottom:1px solid #dee2e6;">
                <h5 class="modal-title" id="employeeName">Employee Attendance Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="font-size:0.95rem; color:#495057;">
                <div class="d-flex align-items-center mb-3">
                    <img id="employeeImage" src="" alt="Employee" style="width:80px; height:80px; object-fit:cover; border-radius:8px; margin-right:15px; border:1px solid #dee2e6;">
                    <div>
                        <h6 id="employeeNameModal" style="margin:0; font-weight:600;"></h6>
                        <p style="margin:0; color:#6c757d;">
                            ID: <span id="employeeId"></span> | Phone: <span id="employeePhone"></span>
                        </p>
                        <p style="margin:0; color:#6c757d;">
                            Designation: <span id="employeeDesignation"></span>
                        </p>
                    </div>
                </div>

                <hr style="margin:10px 0; border-color:#dee2e6;">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong> <span id="attendanceStatus" style="font-weight:600;"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Start Time:</strong> <span id="startTime"></span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>End Time:</strong> <span id="endTime"></span>
                    </div>
                    <div class="col-md-12 mb-2" id="reasonContainer" style="display:none;">
                        <strong>Reason:</strong>
                        <p id="attendanceReason" style="background-color:#f1f3f5; padding:8px; border-radius:5px; color:#212529; margin-top:5px;"></p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
