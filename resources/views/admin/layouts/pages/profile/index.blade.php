@extends('admin.layouts.app')
@section('title', __('Profile'))
@section('admin_content')
    <div class="page-content">

        <div class="container-fluid">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Admin Profile</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restuarant POS</a></li>

                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div>
            </div>




            <div class="row">
                <div class="col-xl-4 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dr-profile-bg rounded-top position-relative mx-n3 mt-n3 position-relative">
                                <img id="header-profile-image"
                                    src="{{ Auth::user()->image ? asset('uploads/profile/' . Auth::user()->image) : asset('backend/assets/images/users/avatar-3.jpg') }}"
                                    alt="Profile Image"
                                    class="border border-light border-3 rounded-circle position-absolute top-100 start-50 translate-middle"
                                    height="100" width="100">
                            </div>

                            <div class="mt-4 mb-2 pt-3  text-center">
                                <p class="mb-1 fs-18 fw-semibold text-dark">{{ Auth::user()->name }}</p>
                                <p class="mb-0 fw-medium text-muted">(MD , {{ Auth::user()->system_admin }})</p>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Change Password :</h4>
                            <div class="border border-dashed bg-light bg-opacity-10 p-3 rounded">
                                <form id="changePasswordForm">

                                    @csrf <!-- AJAX এর জন্য CSRF টোকেন -->
                                    <div class="mb-2">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control" placeholder="Enter Current Password" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" id="new_password" name="new_password" class="form-control"
                                            placeholder="Enter New Password" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="new_password_confirmation" class="form-label">Confirm New
                                            Password</label>
                                        <input type="password" id="new_password_confirmation"
                                            name="new_password_confirmation" class="form-control"
                                            placeholder="Confirm New Password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Change Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div> <!-- end col-->

                <div class="col-xl-8 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div>
                                        <h4 class="card-title">Personal Information :</h4>
                                        <div class="table-responsive mt-3 border border-dashed rounded px-2 py-1">
                                            <table class="table table-borderless m-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0"> Name : </p>
                                                        </td>
                                                        <td class="px-2 text-dark fw-medium fs-14">{{ Auth::user()->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0"> Phone : </p>
                                                        </td>
                                                        <td class="px-2 text-dark fw-medium fs-14">{{ Auth::user()->phone }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <p class="mb-0">Email Address : </p>
                                                        </td>
                                                        <td class="px-2 text-dark fw-medium fs-14">{{ Auth::user()->email }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Change Profile Image (max-size:500 kb) :</h4>
                            <div class="border border-dashed bg-light bg-opacity-10 p-3 rounded">

                                <!-- Current Image Preview -->
                                <div class="mb-3 text-center">
                                    <img id="preview-image"
                                        src="{{ Auth::user()->image ? asset('uploads/profile/' . Auth::user()->image) : asset('default.png') }}"
                                        alt="Profile Image" class="rounded-circle" width="120">
                                </div>

                                <form id="changeImageForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="image" class="form-label">Profile Image</label>
                                        <input type="file" id="image" name="image" class="form-control"
                                            accept="image/*">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Change Image</button>
                                </form>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Restaurant POS - By <span
                            class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance It Lab</span>
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
        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.profile.password.change') }}", // route
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#changePasswordForm')[0].reset();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + "\n";
                        });
                        alert(errorMsg);
                    }
                }
            });
        });
    </script>

    <script>
        // === Preview selected image ===
        $('#image').on('change', function(e) {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        // === AJAX Image Upload ===
        $('#changeImageForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.profile.image.update') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    $('#header-profile-image').attr('src', response.image_url);
                    $('#changeImageForm')[0].reset();
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + "\n";
                        });
                        alert(errorMsg);
                    }
                }
            });
        });
    </script>
@endpush
