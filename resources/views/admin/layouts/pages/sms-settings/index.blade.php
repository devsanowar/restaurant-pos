@extends('admin.layouts.app')
@section('title', __('Sms Settings'))
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">SMS Settings</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restaurant POS</a></li>

                        <li class="breadcrumb-item active">Sms Settings</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Update SMS Settings</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.sms-settings.update') }}" method="POST" class="row g-3">
                                @csrf
                                @method('PUT')

                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <script>
                                            toastr.error("{{ $error }}", "Error");
                                        </script>
                                    @endforeach
                                @endif

                                <div class="col-md-12">
                                    <label for="api_url" class="form-label">Api Url *</label>
                                    <input type="text" class="form-control" id="api_url" name="api_url"
                                        placeholder="Api Url" required value="{{ $setting->api_url ?? '' }}">
                                </div>

                                <div class="col-md-12">
                                    <label for="api_key" class="form-label">Api Key *</label>
                                    <input type="text" class="form-control" id="api_key" name="api_key"
                                        placeholder="Enter api key" required value="{{ $setting->api_key ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="api_secret" class="form-label">Api Secret *</label>
                                    <input type="text" class="form-control" id="api_secret" name="api_secret"
                                        placeholder="Enter api secret" required
                                        value="{{ $setting->api_secret ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="sender_id" class="form-label">Sender ID</label>
                                    <input type="text" class="form-control" id="sender_id" name="sender_id"
                                        placeholder="Enter sender id" value="{{ $setting->sender_id ?? '' }}">
                                </div>

                                <div class="col-md-12">
                                    <label for="request_type" class="form-label">Request Type</label>
                                    <select class="form-select" id="request_type" name="request_type">
                                        <option value="single_sms"{{ isset($setting) && $setting->request_type == 'single_sms' ? 'selected' : '' }}>Single SMS</option>
                                        <option value="multiple_sms"{{ isset($setting) && $setting->request_type == 'multiple_sms' ? 'selected' : '' }}>Multiple SMS</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="message_type" class="form-label">Message Type</label>
                                    <select class="form-select" id="message_type" name="message_type">
                                        <option value="TEXT"
                                            {{ isset($setting) && $setting->message_type == 'TEXT' ? 'selected' : '' }}>
                                            TEXT</option>
                                        <option value="UNICODE"
                                            {{ isset($setting) && $setting->message_type == 'UNICODE' ? 'selected' : '' }}>
                                            UNICODE</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="default_message" class="form-label">Default Message</label>
                                    <textarea class="form-control" id="default_message" rows="8" name="default_message"
                                        placeholder="Enter default message">{!! $setting->default_message ?? '' !!}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label for="sms_balance" class="form-label">SMS Balance</label>
                                    <input type="text" class="form-control" id="sms_balance" name="sms_balance"
                                           placeholder="Enter sms balance" value="{{ $setting->sms_balance ?? '' }}">
                                </div>

                                <div class="col-md-12">
                                    <label for="active_status" class="form-label">Status</label>
                                    <select class="form-select" id="active_status" name="is_active">
                                        <option value="1" {{ $setting->is_active == 1 ? 'selected' : '' }} >Active</option>
                                        <option value="0" {{ $setting->is_active == 0 ? 'selected' : '' }} >Inactive</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">UPDATE</button>
                                </div>

                            </form>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('#SmsApiSettingForm').on('submit', function(e) {--}}
{{--                e.preventDefault();--}}

{{--                let formData = $(this).serialize();--}}

{{--                $.ajax({--}}
{{--                    url: "{{ route('admin.sms-settings.update') }}",--}}
{{--                    type: "POST",--}}
{{--                    data: formData,--}}
{{--                    success: function(response) {--}}
{{--                        if (response.success) {--}}
{{--                            toastr.success(response.message);--}}
{{--                            $('#SmsApiSettingForm')[0].reset();--}}
{{--                        }--}}
{{--                    },--}}
{{--                    error: function(xhr) {--}}
{{--                        toastr.error('An error occurred while updating SMS API settings.');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endpush
