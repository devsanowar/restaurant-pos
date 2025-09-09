@extends('admin.layouts.app')
@section('title', 'Create Atendance')
@section('admin_content')
    <div class="page-content">

        <!-- Start Content-->
        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Add Attendance</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Osen</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hospital</a></li>

                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
            </div>




            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Add Attendance</h4>

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif



                            <div class="d-flex gap-2">
                                <form method="GET" action="" class="d-flex gap-2 mb-3">
                                    <input type="date" name="date" value="{{ $selectedDate }}"
                                        class="form-control form-control-sm" />
                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                </form>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">

                            <form method="POST" action="{{ route('admin.attendance.store') }}">
                                @csrf

                                <input type="hidden" name="date" value="{{ $selectedDate }}">


                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th style="width:150px">Photo</th>
                                            <th style="width:150px">Employe ID</th>
                                            <th style="width:150px">Name</th>
                                            <th style="width:150px">Joining Date</th>
                                            <th style="width:150px">Position</th>
                                            <th style="width:150px">Start Time</th>
                                            <th style="width:150px">End Time</th>
                                            <th style="width:150px">Status</th>
                                            <th style="width:250px">Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $emp)
                                            @php
                                                $attendance = $attendances->firstWhere('payroll_id', $emp->id);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="attendance[{{ $emp->id }}][checked]"
                                                        value="1" class="form-check-input" />
                                                </td>
                                                <td><img src="{{ asset($emp->employe_image) }}" width="50"></td>
                                                <td>{{ $emp->id_number }}</td>
                                                <td>{{ $emp->employe_name }}</td>
                                                <td>{{ $emp->joining_date }}</td>
                                                <td>{{ $emp->employe_designation }}</td>

                                                <td>
                                                    <input type="time" class="form-control form-control-sm"
                                                        name="attendance[{{ $emp->id }}][start_time]"
                                                        value="{{ $attendance->start_time ?? '10:00' }}">
                                                </td>
                                                <td>
                                                    <input type="time" class="form-control form-control-sm"
                                                        name="attendance[{{ $emp->id }}][end_time]"
                                                        value="{{ $attendance->end_time ?? '19:00' }}">
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm status-select"
                                                        name="attendance[{{ $emp->id }}][status]">
                                                        <option value="Present"
                                                            {{ $attendance && $attendance->status == 'Present' ? 'selected' : '' }}>
                                                            Present
                                                        </option>
                                                        <option value="Absent"
                                                            {{ $attendance && $attendance->status == 'Absent' ? 'selected' : '' }}>
                                                            Absent
                                                        </option>
                                                        <option value="Late"
                                                            {{ $attendance && $attendance->status == 'Late' ? 'selected' : '' }}>
                                                            Late
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <h4 class="reason-hint"
                                                        style="color: #6c757d; font-weight: normal; font-size: 0.9rem;">
                                                        Please provide a valid reason if you are late.
                                                    </h4>

                                                    <textarea class="form-control form-control-sm reason-field" name="attendance[{{ $emp->id }}][reason]"
                                                        style="width: 150px; display: none;">{{ $attendance->reason ?? '' }}</textarea>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>

                        <!-- Save Button -->
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="ti ti-check me-1"></i> Save
                                Attendance</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>


        </div> <!-- container -->

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
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tr');

            rows.forEach(row => {
                const statusSelect = row.querySelector('.status-select');
                const reasonField = row.querySelector('.reason-field');
                const reasonHint = row.querySelector('.reason-hint');

                // Default state: show reason hint, hide textarea
                if (reasonHint) reasonHint.style.display = 'block';
                if (reasonField) reasonField.style.display = 'none';

                if (statusSelect) {
                    statusSelect.addEventListener('change', function() {
                        if (this.value === 'Late') {
                            // Show the textarea and hide the reason hint
                            if (reasonField) reasonField.style.display = 'block';
                            if (reasonHint) reasonHint.style.display = 'none';
                        } else {
                            // Hide the textarea and show the reason hint
                            if (reasonField) reasonField.style.display = 'none';
                            if (reasonField) reasonField.value = ''; // Clear the textarea
                            if (reasonHint) reasonHint.style.display = 'block';
                        }
                    });
                }
            });
        });
    </script>
@endpush
