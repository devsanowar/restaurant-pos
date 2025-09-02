@extends('admin.layouts.app')
@section('title', __('Send Custom SMS'))
@section('admin_content')


    @php
        $sms = \App\Models\SmsSetting::first();
        $total = $sms->total_sms;
        $used = $sms->used_sms;
        $remaining = $total - $used;
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Custom SMS Send</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restuarant POS</a></li>

                        <li class="breadcrumb-item active">Custom Sms</li>
                    </ol>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Send Custom Sms</h4>
                            <div class="border border-dashed bg-light bg-opacity-10 p-3 rounded">
                                <div id="smsSummary" class="alert alert-info">
                                    Total SMS: 0 | Sent: 0 | Remaining: 0
                                </div>

                                {{-- <div id="smsSummary" class="mt-3 alert alert-info"></div> --}}

                                <form id="customSmsForm" style="margin-bottom: 50px ">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="phone_numbers" class="form-label">Phone Number(s)</label>
                                        <textarea name="phone_numbers" class="form-control" rows="3" placeholder="017...,018..."></textarea>
                                    </div>

                                    <div class="mb-2">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="6" oninput="countSms()"></textarea>
                                        <small id="smsCounter">Characters: 0 | SMS Count: 0</small>
                                    </div>

                                    <button type="submit" class="btn btn-primary float-end">Send SMS</button>
                                </form>

                                <div id="smsResult" class="mt-3"></div>

                            </div>
                        </div>
                    </div>

                </div> <!-- end col-->

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
                            class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance It
                            Lab</span>
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
        function countSms() {
            const text = document.getElementById('message').value;
            const counter = document.getElementById('smsCounter');

            // Unicode detect (Bangla, Emoji ইত্যাদি ধরবে)
            const isUnicode = /[^\x00-\x7F]/.test(text);

            // Character count
            const charCount = isUnicode ? [...text].length : text.length;

            // SMS limits
            let singleLimit = isUnicode ? 70 : 160;
            let multiLimit = isUnicode ? 67 : 153;

            // SMS count calculation
            let smsCount = 0;
            if (charCount <= singleLimit) {
                smsCount = charCount > 0 ? 1 : 0;
            } else {
                smsCount = Math.ceil((charCount - singleLimit) / multiLimit) + 1;
            }

            counter.innerText =
                `Characters: ${charCount} | SMS Count: ${smsCount} (${isUnicode ? 'Bangla/Unicode' : 'English'})`;
        }
    </script>

   <script>
    function loadSmsSummary() {
        $.ajax({
            url: "{{ route('admin.sms.summary') }}",
            type: "GET",
            success: function(response) {
                $('#smsSummary').html(
                    `Total SMS: ${response.total} | Sent: ${response.sent} | Remaining: ${response.remaining}`
                );
            }
        });
    }

    $(document).ready(function() {
        loadSmsSummary();

        // SMS পাঠানোর form
        $('#customSmsForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.send.custom.sms.send') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    let resultDiv = $('#smsResult');
                    resultDiv.html(`<div class="alert alert-success">${response.message}</div>`);
                    $('#customSmsForm')[0].reset();

                    setTimeout(() => {
                        resultDiv.fadeOut('slow', function() {
                            $(this).html('').show();
                        });
                    }, 3000);

                    // Send করার পর summary refresh
                    loadSmsSummary();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        $.each(errors, function(key, value) {
                            errorMsg += `<div>${value[0]}</div>`;
                        });
                        $('#smsResult').html(`<div class="alert alert-danger">${errorMsg}</div>`);
                        setTimeout(() => {
                            $('#smsResult').fadeOut('slow', function() {
                                $(this).html('').show();
                            });
                        }, 3000);
                    }
                }
            });
        });
    });
</script>

@endpush
