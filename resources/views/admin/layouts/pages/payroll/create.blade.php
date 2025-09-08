@extends('admin.layouts.app')
@section('title', 'Create Payroll')

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
                            <h4 class="header-title mb-0">Create Playroll</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.payroll.index') }}" class="btn btn-primary btn-sm">All Payroll</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form id="addEmployeeForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">

                                    <!-- Joining Date -->
                                    <div class="col-lg-6">
                                        <label for="joiningDate" class="form-label">Joining Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="joiningDate" name="joining_date"
                                            required>
                                    </div>

                                    <!-- ID Number -->
                                    <div class="col-lg-6">
                                        <label for="id_number" class="form-label">ID Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="idNumber" name="id_number"
                                            placeholder="Enter ID Number" required>
                                    </div>

                                    <!-- Restaurant/Branch -->
                                    <div class="col-lg-6">
                                        <label for="restaurant" class="form-label">Select Restaurant <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="restaurant" name="restaurant_id" required>
                                            <option value="">Select Restaurant...</option>
                                            @foreach ($restaurants as $restaurant)
                                                <option value="{{ $restaurant->id }}">
                                                    {{ $restaurant->restaurant_branch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Employee Name -->
                                    <div class="col-lg-6">
                                        <label for="employeeName" class="form-label">Employee Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="employeeName" name="employe_name"
                                            placeholder="Enter full name" required>
                                    </div>

                                    <!-- Mobile -->
                                    <div class="col-lg-6">
                                        <label for="mobile" class="form-label">Mobile</label>
                                        <input type="text" class="form-control" id="mobile" name="employe_phone"
                                            placeholder="Enter mobile number">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-lg-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="employe_email"
                                            placeholder="Enter email address">
                                    </div>

                                    <!-- NID Number -->
                                    <div class="col-lg-6">
                                        <label for="employeeName" class="form-label">NID Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nidNumber" name="employe_nid_number"
                                            placeholder="Enter NID Number">
                                    </div>

                                    <!-- NID Front Image -->
                                    <div class="col-lg-6">
                                        <label for="employeeName" class="form-label">NID Front Page <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="nidFront"
                                            name="employe_nid_front_image" accept="image/*">
                                    </div>

                                    <!-- NID Back Image -->
                                    <div class="col-lg-6">
                                        <label for="employeeName" class="form-label">NID Back Page <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="nidBack"
                                            name="employe_nid_back_image" accept="image/*">
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-lg-6">
                                        <label for="employeeName" class="form-label">Date of birth<span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dob"
                                            name="employe_date_of_birth">
                                    </div>

                                    <!-- Education Qualification -->
                                    <div class="col-lg-6">
                                        <label for="employe_blood_group" class="form-label">Blood group</label>
                                        <input type="text" class="form-control" id="employe_blood_group"
                                            name="employe_blood_group"
                                            placeholder="Enter your blood group">
                                    </div>



                                    {{-- <div class="col-lg-6">
                                        <label class="form-label">Education Qualifications</label>
                                        <div id="qualificationWrapper">
                                            <!-- Qualification groups will appear here -->
                                        </div>
                                        <button type="button" class="btn btn-secondary mt-2"
                                            id="addQualificationBtn">Add Qualification</button>
                                    </div> --}}


                                    <!-- Father Name -->
                                    <div class="col-lg-6">
                                        <label for="fatherName" class="form-label">Father Name</label>
                                        <input type="text" class="form-control" id="fatherName"
                                            name="employe_father_name" placeholder="Enter father's name">
                                    </div>

                                    <!-- Mother Name -->
                                    <div class="col-lg-6">
                                        <label for="motherName" class="form-label">Mother Name</label>
                                        <input type="text" class="form-control" id="motherName"
                                            name="employe_mother_name" placeholder="Enter mother's name">
                                    </div>

                                    <!-- Present Address -->
                                    <div class="col-lg-6">
                                        <label for="presentAddress" class="form-label">Present Address</label>
                                        <input type="text" class="form-control" id="presentAddress"
                                            name="employe_present_address" placeholder="Enter current address">
                                    </div>

                                    <!-- Permanent Address -->
                                    <div class="col-lg-6">
                                        <label for="permanentAddress" class="form-label">Permanent Address</label>
                                        <input type="text" class="form-control" id="permanentAddress"
                                            name="employe_permanent_address" placeholder="Enter permanent address">
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-lg-6">
                                        <label class="form-label d-block">Gender <span
                                                class="text-danger">*</span></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="genderMale" value="0" required>
                                            <label class="form-check-label" for="genderMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="genderFemale" value="1">
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="genderOther" value="2">
                                            <label class="form-check-label" for="genderOther">Other</label>
                                        </div>
                                    </div>

                                    <!-- Designation -->
                                    <div class="col-lg-6">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designation"
                                            name="employe_designation" placeholder="Enter designation">
                                    </div>

                                    <!-- Basic Salary -->
                                    <div class="col-lg-6">
                                        <label for="basicSalary" class="form-label">Basic Salary <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="basicSalary"
                                            name="employe_sallery" value="0" min="0" required>
                                    </div>

                                    <!-- Festival Bonus -->
                                    <div class="col-lg-6">
                                        <label for="festivalBonus" class="form-label">Festival Bonus</label>
                                        <input type="number" class="form-control" id="festivalBonus"
                                            name="employe_festival_bonas" value="0" min="0">
                                    </div>

                                    <!-- Festival Bonus Type -->
                                    <div class="col-lg-6">
                                        <label for="festivalBonusType" class="form-label">Festival Bonus Type</label>
                                        <select class="form-select" id="festivalBonusType"
                                            name="employe_festival_bonas_type">
                                            <option value="">Select Type</option>
                                            <option value="cash">Cash</option>
                                            <option value="product">Product</option>
                                        </select>
                                    </div>

                                    <!-- Overtime Rate -->
                                    <div class="col-lg-6">
                                        <label for="overtimeRate" class="form-label">Overtime Rate (Per Hour) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="overtimeRate"
                                            name="employe_overtime_rate" value="0" min="0" required>
                                    </div>

                                    <!-- Yearly Leave -->
                                    <div class="col-lg-6">
                                        <label for="yearlyLeave" class="form-label">Yearly Leave</label>
                                        <input type="number" class="form-control" id="yearlyLeave"
                                            name="employe_yearly_leave" value="0" min="0">
                                    </div>

                                    <!-- Employee Image -->
                                    <div class="col-lg-6 mt-3">
                                        <label for="employeeImage" class="form-label">Employee Image</label>
                                        <input class="form-control" type="file" id="employeeImage"
                                            name="employe_image" accept="image/*">
                                        <small class="text-muted">Recommended size: 300x300px</small>
                                    </div>

                                    <div class="col-lg-6 mt-3">
                                        <label for="resume" class="form-label">Resume / CV</label>
                                        <input class="form-control" type="file" id="resume" name="employe_resume"
                                            accept=".pdf,.doc,.docx">
                                    </div>


                                    <!-- Submit Button -->
                                    <div class="col-lg-12 text-end mt-3">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-user-plus me-1"></i> Save
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
    <script>
        $(document).ready(function() {
            $("#addEmployeeForm").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.payroll.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $("#addEmployeeForm")[0].reset();

                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message ?? "Something went wrong.");
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            let errorList = Object.values(errors).flat().join("<br>");
                            toastr.error(errorList, "Validation Error");
                        } else {
                            toastr.error("Please try again later.", "Server Error");
                        }
                    }
                });
            });

        });
    </script>

    {{-- <script>
    let qualificationCount = 0;

    const qualificationLevels = ["SSC", "HSC", "Honors", "Masters"];

    document.getElementById('addQualificationBtn').addEventListener('click', function() {
        if (qualificationCount >= qualificationLevels.length) {
            alert("All qualifications added!");
            return;
        }

        const level = qualificationLevels[qualificationCount];
        const wrapper = document.getElementById('qualificationWrapper');

        const div = document.createElement('div');
        div.classList.add('qualification-group', 'mb-3');
        div.innerHTML = `
            <h6>${level} Information</h6>
            <div class="row g-2">
                <div class="col-lg-4">
                    <input type="text" name="employe_edu_qualification[${level}][institution]" class="form-control" placeholder="Institution Name" required>
                </div>
                <div class="col-lg-4">
                    <input type="text" name="employe_edu_qualification[${level}][group]" class="form-control" placeholder="Group/Department">
                </div>
                <div class="col-lg-4">
                    <input type="text" name="employe_edu_qualification[${level}][gpa]" class="form-control" placeholder="GPA/Grade" required>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
        qualificationCount++;
    });
</script> --}}
@endpush
