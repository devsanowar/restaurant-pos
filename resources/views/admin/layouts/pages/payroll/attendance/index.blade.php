@extends('admin.layouts.app')
@section('title', 'All Attendance')
@section('admin_content')
    <div class="page-content">

        <!-- Start Content-->
        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Employe Attendance</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restaurant</a></li>

                        <li class="breadcrumb-item active">Employe Attendance</li>
                    </ol>
                </div>
            </div>

            <!-- Body Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">All Attendance</h4>
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="ti ti-printer me-1"></i> Print
                            </a>
                        </div>

                        <!-- Filter Bar with Labels -->
                        <div class="card-body border-bottom py-2">
                            <form class="row g-2 align-items-end" method="GET"
                                action="{{ route('admin.attendance.index') }}">
                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Employee</label>
                                    <select class="form-select form-select-sm" name="employee_id">
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->employe_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small mb-1">Status</label>
                                    <select class="form-select form-select-sm" name="status">
                                        <option value="">Select Status</option>
                                        <option value="Present" {{ request('status') == 'Present' ? 'selected' : '' }}>
                                            Present</option>
                                        <option value="Absent" {{ request('status') == 'Absent' ? 'selected' : '' }}>Absent
                                        </option>
                                        <option value="Late" {{ request('status') == 'Late' ? 'selected' : '' }}>Late
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small mb-1">From Date</label>
                                    <input type="date" class="form-control form-control-sm" name="from_date"
                                        value="{{ request('from_date') }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small mb-1">To Date</label>
                                    <input type="date" class="form-control form-control-sm" name="to_date"
                                        value="{{ request('to_date') }}">
                                </div>

                                <div class="col-md-1 d-grid">
                                    <label class="form-label invisible">Search</label>
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Search</button>
                                </div>
                            </form>

                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Image</th>
                                        <th>Date</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Attendance Row 2 -->
                                    @foreach ($attendances as $key => $attendance)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset($attendance->payroll->employe_image) }}" alt="Shachsaw"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}</td>
                                            <td>{{ $attendance->payroll->id_number }}</td>
                                            <td>{{ $attendance->payroll->employe_name }}</td>
                                            <td>{{ $attendance->payroll->employe_designation }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->start_time)->format('g:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->end_time)->format('g:i A') }}</td>
                                            <td>
                                                @if ($attendance->status == 'Present')
                                                    <span class="badge bg-primary">Present</span>
                                                @elseif($attendance->status == 'Absent')
                                                    <span class="badge bg-danger">Absent</span>
                                                @else
                                                    <span class="badge bg-warning">Late</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <div class="hstack gap-1 justify-content-center">
                                                    <button
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-attendance-btn"
                                                        data-id="{{ $attendance->id }}" title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </button>

                                                    <button
                                                        class="btn btn-soft-info btn-icon btn-sm rounded-circle view-attendance-btn"
                                                        data-id="{{ $attendance->id }}" title="View">
                                                        <i class="ti ti-eye fs-16"></i>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                        @include('admin.layouts.pages.payroll.attendance.edit')
                        @include('admin.layouts.pages.payroll.attendance.show')


                        <!-- Footer / Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary">Copy</button>
                                    <button class="btn btn-sm btn-outline-success">Excel</button>
                                    <button class="btn btn-sm btn-outline-info">Column Visibility</button>
                                </div>
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                                    </li>
                                </ul>
                            </div>
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
        $(document).ready(function() {

            $('.view-attendance-btn').click(function() {
                var attendanceId = $(this).data('id');

                $.ajax({
                    url: '/admin/employe/attendance/' + attendanceId +
                        '/show', // edit method used to fetch data
                    type: 'GET',
                    success: function(res) {
                        // Employee info
                        $('#employeeNameModal').text(res.payroll.employe_name ?? 'N/A');
                        $('#employeeId').text(res.payroll.id_number ?? 'N/A');
                        $('#employeePhone').text(res.payroll.employe_phone ?? 'N/A');
                        $('#employeeDesignation').text(res.payroll.employe_designation ??
                            'N/A');

                        // Image fix
                        let imagePath = res.payroll.employe_image ? "{{ url('') }}/" +
                            res.payroll.employe_image : '/assets/images/default-avatar.png';
                        $('#employeeImage').attr('src', imagePath);

                        // Attendance info (Bangladesh time format)
                        function formatTimeToBangladesh(timeString) {
                            if (!timeString) return '--';
                            return new Date('1970-01-01T' + timeString).toLocaleTimeString(
                                'en-US', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: true,
                                    timeZone: 'Asia/Dhaka'
                                });
                        }

                        $('#startTime').text(formatTimeToBangladesh(res.start_time));
                        $('#endTime').text(formatTimeToBangladesh(res.end_time));
                        $('#attendanceStatus').text(res.status ?? 'N/A');

                        // Reason
                        if (res.status === 'Late' && res.reason) {
                            $('#attendanceReason').text(res.reason);
                            $('#reasonContainer').show();
                        } else {
                            $('#reasonContainer').hide();
                        }

                        // Show modal
                        $('#viewAttendanceModal').modal('show');
                    },


                    error: function(err) {
                        console.log(err);
                        alert('Could not fetch attendance data!');
                    }
                });
            });

        });
    </script>


    <script>
        $(document).ready(function() {

            $('.edit-attendance-btn').click(function() {
                var attendanceId = $(this).data('id');

                $.ajax({
                    url: '/admin/employe/attendance/' + attendanceId + '/edit',
                    type: 'GET',
                    success: function(res) {
                        console.log(res);
                        $('#attendance_id').val(res.id);
                        $('#employeeName').text(res.payroll.employe_name ?? 'Employee');

                        $('#start_time').val(res.start_time ? res.start_time.substring(0, 5) :
                            '09:00');
                        $('#end_time').val(res.end_time ? res.end_time.substring(0, 5) :
                            '18:00');

                        $('#statusshow').val(res.status); // This will set the selected status value
                        $('#editAttendanceModal').modal('show');
                    },
                    error: function(err) {
                        console.log(err);
                        alert('Unable to fetch data!');
                    }
                });
            });

            // Submit form via AJAX
            $('#editAttendanceForm').submit(function(e) {
                e.preventDefault();
                var attendanceId = $('#attendance_id').val();
                var data = $(this).serialize();

                $.ajax({
                    url: '/admin/employe/attendance/update/' + attendanceId,
                    type: 'PUT',
                    data: data,
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.message);
                            location.reload();
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        alert('Something went wrong!');
                    }
                });
            });


        });
    </script>
@endpush
