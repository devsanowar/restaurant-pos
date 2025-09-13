@extends('admin.layouts.app')
@section('title', 'Edit Payroll')

@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Payroll</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Payroll</li>
                    </ol>
                </div>
            </div>

            <!-- All Suppliers Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Edit Playroll</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.payroll.index') }}" class="btn btn-primary btn-sm">All Payroll</a>
                            </div>
                        </div>

                        <div class="card-body">
                             <form id="editEmployeeForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.payroll.update', $payroll->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">

                                    <!-- Joining Date -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="joining_date"
                                            value="{{ $payroll->joining_date }}" required>
                                    </div>

                                    <!-- ID Number -->
                                    <div class="col-lg-6">
                                        <label class="form-label">ID Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="id_number"
                                            value="{{ $payroll->id_number }}" required>
                                    </div>

                                    <!-- Restaurant -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Select Restaurant <span class="text-danger">*</span></label>
                                        <select class="form-select" name="restaurant_id" required>
                                            <option value="">Select Restaurant...</option>
                                            @foreach ($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}"
                                                    {{ $payroll->restaurant_id == $restaurant->id ? 'selected' : '' }}>
                                                    {{ $restaurant->restaurant_branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Employee Name -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Employee Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="employe_name"
                                            value="{{ $payroll->employe_name }}" required>
                                    </div>

                                    <!-- Mobile -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" name="employe_phone"
                                            value="{{ $payroll->employe_phone }}">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="employe_email"
                                            value="{{ $payroll->employe_email }}">
                                    </div>

                                    <!-- NID Number -->
                                    <div class="col-lg-6">
                                        <label class="form-label">NID Number</label>
                                        <input type="text" class="form-control" name="employe_nid_number"
                                            value="{{ $payroll->employe_nid_number }}">
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="employe_date_of_birth"
                                            value="{{ $payroll->employe_date_of_birth }}">
                                    </div>

                                    <!-- Blood Group -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Blood Group</label>
                                        <input type="text" class="form-control" name="employe_blood_group"
                                            value="{{ $payroll->employe_blood_group }}">
                                    </div>

                                    <!-- Father Name -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Father Name</label>
                                        <input type="text" class="form-control" name="employe_father_name"
                                            value="{{ $payroll->employe_father_name }}">
                                    </div>

                                    <!-- Mother Name -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Mother Name</label>
                                        <input type="text" class="form-control" name="employe_mother_name"
                                            value="{{ $payroll->employe_mother_name }}">
                                    </div>

                                    <!-- Present Address -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Present Address</label>
                                        <input type="text" class="form-control" name="employe_present_address"
                                            value="{{ $payroll->employe_present_address }}">
                                    </div>

                                    <!-- Permanent Address -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Permanent Address</label>
                                        <input type="text" class="form-control" name="employe_permanent_address"
                                            value="{{ $payroll->employe_permanent_address }}">
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-lg-6">
                                        <label class="form-label d-block">Gender</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="0"
                                                {{ $payroll->gender == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="1"
                                                {{ $payroll->gender == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="2"
                                                {{ $payroll->gender == 2 ? 'checked' : '' }}>
                                            <label class="form-check-label">Other</label>
                                        </div>
                                    </div>

                                    <!-- Designation -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Designation</label>
                                        <input type="text" class="form-control" name="employe_designation"
                                            value="{{ $payroll->employe_designation }}">
                                    </div>

                                    <!-- Basic Salary -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Basic Salary</label>
                                        <input type="number" class="form-control" name="employe_sallery"
                                            value="{{ $payroll->employe_sallery }}">
                                    </div>

                                    <!-- Festival Bonus -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Festival Bonus</label>
                                        <input type="number" class="form-control" name="employe_festival_bonas"
                                            value="{{ $payroll->employe_festival_bonas }}">
                                    </div>

                                    <!-- Festival Bonus Type -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Festival Bonus Type</label>
                                        <select class="form-select" name="employe_festival_bonas_type">
                                            <option value="">Select Type</option>
                                            <option value="cash"
                                                {{ $payroll->employe_festival_bonas_type == 'cash' ? 'selected' : '' }}>
                                                Cash
                                            </option>
                                            <option value="product"
                                                {{ $payroll->employe_festival_bonas_type == 'product' ? 'selected' : '' }}>
                                                Product
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Overtime Rate -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Overtime Rate (Per Hour)</label>
                                        <input type="number" class="form-control" name="employe_overtime_rate"
                                            value="{{ $payroll->employe_overtime_rate }}">
                                    </div>

                                    <!-- Yearly Leave -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Yearly Leave</label>
                                        <input type="number" class="form-control" name="employe_yearly_leave"
                                            value="{{ $payroll->employe_yearly_leave }}">
                                    </div>

                                    <!-- Employee Image -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Employee Image</label>
                                        <input type="file" class="form-control" name="employe_image" accept="image/*">
                                        @if ($payroll->employe_image)
                                            <img src="{{ asset($payroll->employe_image) }}" alt="Employee Image"
                                                width="80" class="mt-2">
                                        @endif
                                    </div>

                                    <!-- Resume -->
                                    <div class="col-lg-6">
                                        <label class="form-label">Resume / CV</label>
                                        <input type="file" class="form-control" name="employe_resume"
                                            accept=".pdf,.doc,.docx">
                                        @if ($payroll->employe_resume)
                                            <a href="{{ asset($payroll->employe_resume) }}" target="_blank"
                                                class="d-block mt-2 text-primary">View Resume</a>
                                        @endif
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-lg-12 text-end mt-3">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-refresh me-1"></i> Update
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>

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

@endpush
