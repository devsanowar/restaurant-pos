@extends('admin.layouts.app')
@section('title', 'User management')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
@endpush
@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">User Management</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">User Management</li>
                    </ol>
                </div>
            </div>

            <!-- User Management Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Add New User</h4>

                        </div>
                        <div class="card-body">
                            <form id="addUserForm">
                                @csrf
                                <div class="row">
                                    <!-- Full Name -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="userName" class="form-label">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="userName"
                                                placeholder="Enter full name">
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>
                                    <!-- Email -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" id="userEmail"
                                                placeholder="Enter email address">
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                    <!-- Phone -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="userPhone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" id="userPhone" name="phone"
                                                placeholder="+880 123 456 789">
                                            <span class="text-danger error-text phone_error"></span>
                                        </div>
                                    </div>
                                    <!-- Role -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="userRole" class="form-label">Role <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="userRole" name="system_admin" required>
                                                <option selected>Select Role</option>
                                                @foreach ($system_admins as $role)
                                                    @continue(strtolower($role) === 'supper_admin')
                                                    <option value="{{ $role }}">
                                                        {{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text system_admin_error"></span>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">Password <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" id="userPassword"
                                                placeholder="Enter password">
                                            <span class="text-danger error-text password_error"></span>
                                        </div>
                                    </div>

                                </div>

                                <!-- Permissions -->
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="permView" name="can_view"
                                                value="1" checked>
                                            <label class="form-check-label" for="permView">View</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="permAdd" name="can_add"
                                                value="1">
                                            <label class="form-check-label" for="permAdd">Add</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="permEdit" name="can_edit"
                                                value="1">
                                            <label class="form-check-label" for="permEdit">Edit</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="permDelete"
                                                name="can_delete" value="1">
                                            <label class="form-check-label" for="permDelete">Delete</label>
                                        </div>
                                    </div>
                                </div>



                                <!-- Add User Button -->
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="ti ti-user-plus me-1"></i> Add User
                                    </button>
                                </div>
                            </form>

                            <hr class="my-4">

                            <!-- User List -->
                            <h5 class="mb-3">User List</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>phone</th>
                                            <th>System admin</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($users as $user)
                                            <tr id="user-row-{{ $user->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $user->system_admin)) }}</td>

                                                <td>
                                                    <a href="{{ route('admin.user.management.edit', $user->id) }}" class="btn btn-sm btn-outline-primary me-1"><i
                                                            class="ti ti-edit"></i></a>
                                                    <form class="d-inline-block" method="POST"
                                                        action="{{ route('admin.user.management.destroy', $user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"
                                                            title="Delete" data-id="{{ $user->id }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>

    <script>
        $('#addUserForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            // Clear previous errors
            $('.error-text').text('');

            $.ajax({
                url: "{{ route('admin.user.management.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#addUserForm')[0].reset();
                        toastr.success('User added successfully!');
                        location.reload(); // page reload after success
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>

    <script>
        // Delete with ajax
        $(document).ready(function() {
            $('.show_confirm').on('click', function(e) {
                e.preventDefault();

                let button = $(this);
                let form = button.closest('form');
                let fieldOfCostId = button.data('id');
                let actionUrl = form.attr('action');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: {
                                _token: form.find('input[name="_token"]').val(),
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                toastr.success(response.message ||
                                    'Deleted successfully!');
                                form.closest('tr').remove();

                                $("#recycleCount").text(response.deletedCount);
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message ||
                                    'Something went wrong!');
                            }
                        });
                    }
                });
            });
        });
    </script>


@endpush
