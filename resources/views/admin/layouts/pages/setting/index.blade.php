@extends('admin.layouts.app')
@section('title', 'Settings')
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-container">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold mb-0">Settings</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                </div>

                <!-- Settings Body Content -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom border-dashed">
                                <h4 class="card-title">System Settings</h4>
                                <p class="text-muted mb-0">
                                    Manage your restaurant POS system settings including general, POS, appearance,
                                    and notification preferences.
                                </p>
                            </div>
                            <div class="card-body">
                                <form id="settingsForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- General Settings -->
                                    <h5 class="mb-3">General Settings</h5>
                                    <div class="row">
                                        <!-- Restaurant Name -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="restaurantName" class="form-label">Restaurant Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="restaurantName"
                                                    name="restaurant_name" value="{{ $general->restaurant_name ?? '' }}"
                                                    placeholder="e.g. Spice Garden" required>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="restaurantEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="restaurantEmail"
                                                    name="restaurant_email" value="{{ $general->restaurant_email ?? '' }}"
                                                    placeholder="info@example.com">
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="restaurantPhone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="restaurantPhone"
                                                    name="restaurant_phone" value="{{ $general->restaurant_phone ?? '' }}"
                                                    placeholder="+880 123 456 789">
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="restaurantAddress" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="restaurantAddress"
                                                    name="restaurant_address"
                                                    value="{{ $general->restaurant_address ?? '' }}"
                                                    placeholder="123 Main Street">
                                            </div>
                                        </div>

                                        <!-- Logo Upload -->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="restaurantLogo" class="form-label">Restaurant Logo</label>
                                                <input class="form-control" type="file" id="restaurantLogo"
                                                    name="restaurant_logo" accept="image/*">
                                                <small class="text-muted">Recommended size: 200x200px</small>
                                                @if (!empty($general->restaurant_logo))
                                                    <div class="mt-2">
                                                        <img src="{{ asset('uploads/logo/' . $general->restaurant_logo) }}"
                                                            alt="Logo" width="100">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <!-- POS Settings -->
                                    <h5 class="mb-3">POS Settings</h5>
                                    <div class="row">
                                        <!-- Currency -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="currency" class="form-label">Currency</label>
                                                <select class="form-select" id="currency" name="currency">
                                                    <option value="USD"
                                                        {{ ($pos->currency ?? '') === 'USD' ? 'selected' : '' }}>USD ($)
                                                    </option>
                                                    <option value="BDT"
                                                        {{ ($pos->currency ?? '') === 'BDT' ? 'selected' : '' }}>BDT (৳)
                                                    </option>
                                                    <option value="INR"
                                                        {{ ($pos->currency ?? '') === 'INR' ? 'selected' : '' }}>INR (₹)
                                                    </option>
                                                    <option value="EUR"
                                                        {{ ($pos->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR (€)
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Tax Rate -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="taxRate" class="form-label">Tax Rate (%)</label>
                                                <input type="number" class="form-control" id="taxRate" name="tax_rate"
                                                    value="{{ $pos->tax_rate ?? '' }}" placeholder="e.g. 10"
                                                    min="0">
                                            </div>
                                        </div>

                                        <!-- Service Charge -->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="serviceCharge" class="form-label">Service Charge (%)</label>
                                                <input type="number" class="form-control" id="serviceCharge"
                                                    name="service_charge" value="{{ $pos->service_charge ?? '' }}"
                                                    placeholder="e.g. 5" min="0">
                                            </div>
                                        </div>

                                        <!-- Default Printer -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="defaultPrinter" class="form-label">Default Printer</label>
                                                <select class="form-select" id="defaultPrinter" name="default_printer">
                                                    <option value="pos_printer"
                                                        {{ ($pos->default_printer ?? '') === 'pos_printer' ? 'selected' : '' }}>
                                                        POS Printer</option>
                                                    <option value="kitchen_printer"
                                                        {{ ($pos->default_printer ?? '') === 'kitchen_printer' ? 'selected' : '' }}>
                                                        Kitchen Printer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Notification Settings -->
                                    <h5 class="mb-3">Notification Settings</h5>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="emailNotification"
                                                    name="email_notification" value="1"
                                                    {{ $notification->email_notification ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label" for="emailNotification">Email
                                                    Notifications</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="smsNotification"
                                                    name="sms_notification" value="1"
                                                    {{ $notification->sms_notification ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label" for="smsNotification">SMS
                                                    Notifications</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="pushNotification"
                                                    name="push_notification" value="1"
                                                    {{ $notification->push_notification ?? false ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pushNotification">Push
                                                    Notifications</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-device-floppy me-1"></i> Update Settings
                                        </button>
                                    </div>
                                </form>
                                <option value="kitchen_printer">Kitchen Printer</option>
                                </select>
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
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.setting.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('Something went wrong!');
                }
            });
        });
    </script>
@endpush
