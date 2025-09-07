@extends('admin.layouts.app')
@section('title', 'Edit User')
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
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>

        <!-- User Edit Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                        <h4 class="header-title mb-0">Edit User </h4>
                    </div>
                    <div class="card-body">
                        <form id="editUserForm" method="POST" action="{{ route('admin.user.management.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="userName"
                                            value="{{ old('name', $user->name) }}" placeholder="Enter full name">
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="userEmail"
                                            value="{{ old('email', $user->email) }}" placeholder="Enter email address">
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="userPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="userPhone" name="phone"
                                            value="{{ old('phone', $user->phone) }}" placeholder="+880 123 456 789">
                                        <span class="text-danger error-text phone_error"></span>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="userRole" class="form-label">Role <span class="text-danger">*</span></label>
                                        <select class="form-select" id="userRole" name="system_admin" required>
                                            <option selected>Select Role</option>
                                            @foreach ($system_admins as $role)
                                                @continue(strtolower($role) === 'supper_admin')
                                                <option value="{{ $role }}" {{ $user->system_admin == $role ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-text system_admin_error"></span>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="userPassword" class="form-label">Password (Leave blank to keep current)</label>
                                        <input type="password" name="password" class="form-control" id="userPassword"
                                            placeholder="Enter new password">
                                        <span class="text-danger error-text password_error"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="permView" name="can_view" value="1"
                                            {{ $user->can_view ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permView">View</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="permAdd" name="can_add" value="1"
                                            {{ $user->can_add ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permAdd">Add</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="permEdit" name="can_edit" value="1"
                                            {{ $user->can_edit ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permEdit">Edit</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="permDelete" name="can_delete" value="1"
                                            {{ $user->can_delete ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permDelete">Delete</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Button -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="ti ti-edit me-1"></i> Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="page-container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <script>document.write(new Date().getFullYear())</script> © Restaurant POS - By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance IT</span>
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

</div>
@endsection
