@extends('admin.layouts.app')
@section('title', 'Edit Message')
@push('styles')

    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
@endpush

@section('admin_content')
    <div class="container-fluid">
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-uppercase"> Edit Setting <span><a href="{{ route('message.index') }}" class="btn btn-primary right">All Settings</a></span></h4>

                    </div>
                    <div class="body">

                        <!-- Check if any validation errors exist and show them -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" action="{{ route('message.update', $message->id) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="api_url"><b>API URL*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <input type="text" name="api_url" value="{{ $message->api_url }}" class="form-control @error('api_url')invalid @enderror">
                                    </div>
                                    @error('api_url')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="api_key"><b>API Key*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <input type="text" name="api_key" value="{{ $message->api_key }}" class="form-control @error('api_key')invalid @enderror">
                                    </div>
                                    @error('api_key')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="api_secret"><b>API Secret*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <input type="text" name="api_secret" value="{{ $message->api_secret }}" class="form-control @error('api_secret')invalid @enderror"
                                               placeholder="Enter your api secret here">
                                    </div>
                                    @error('api_secret')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="sender"><b>Sender ID*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <input type="text" name="sender" value="{{ $message->sender }}" class="form-control @error('sender')invalid @enderror">
                                    </div>
                                    @error('sender')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="message_body"><b>Message*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                    <textarea type="text" rows="6" id="message-box" name="message_body" class="form-control @error('message_body')invalid @enderror" >
                                        {{ $message->message_body }}
                                    </textarea>
                                    </div>
                                    <div class="text-end mt-1">
                                        <small><span id="char-count">0</span> অক্ষর</small>
                                    </div>
                                    @error('message_body')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="sms_balance"><b>SMS Balance*</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <input type="number" name="sms_balance" class="form-control @error('sms_balance')invalid @enderror"
                                               value="{{ $message->sms_balance }}" placeholder="Enter sms balance here">
                                    </div>
                                    @error('sms_balance')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7 mb-3">
                                <label for="brand_id"><b>Status</b></label>
                                <div class="form-group">
                                    <div class="" style="border: 1px solid #ccc">
                                        <select name="is_active" class="form-control show-tick">
                                            <option value="1" {{ $message->is_active == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $message->is_active == 0 ? 'selected' : '' }}>DeActive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-8 col-xs-7">
                                <button type="submit"
                                        class="btn btn-raised btn-primary m-t-15 waves-effect">SAVE</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Horizontal Layout -->
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('message-box');
            const counter = document.getElementById('char-count');

            const updateCount = () => {
                counter.textContent = textarea.value.length;
            };

            // Update on input (handles typing, deleting, pasting, etc.)
            textarea.addEventListener('input', updateCount);

            // Initialize count if textarea has pre-filled value
            updateCount();
        });
    </script>
    <script src="{{ asset('backend') }}/assets/plugins/ckeditor/ckeditor.js"></script> <!-- Ckeditor -->
    <script src="{{ asset('backend') }}/assets/js/pages/forms/editors.js"></script>
@endpush

