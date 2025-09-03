@extends('admin.layouts.app')
@section('title', __('Send Custom SMS'))
@section('admin_content')

    @php
        use App\Models\SmsLog;

        $totalSms = config('sms.total_sms_limit');
        $totalSendSms = SmsLog::sum('total_message');
        $totalSentSms = SmsLog::where('delivery_report', 'success')->sum('total_message');
        $remainingSms = max(0, $totalSms - $totalSentSms);
    @endphp

    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Send Custom SMS</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restuarant POS</a></li>

                        <li class="breadcrumb-item active">Custom SMS</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Custom SMS</h4>

                            <p class="text-center text-success"><b>{!! session('message') !!}</b></p>

                            <div class="border border-dashed bg-light bg-opacity-10 p-3 rounded">
                                <div id="smsSummary" class="alert alert-info">
                                    Total SMS: 2500 | Sent: <strong>{{ $totalSendSms }}</strong> | Remaining: <strong>{{ $remainingSms }}</strong>
                                </div>

                                <form action="{{ route('admin.send.sms') }}" method="POST" id="customSmsForm" style="margin-bottom: 50px ">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="mobile_numbers" class="form-label">Mobile Number(s)</label>
                                        <textarea name="mobile_numbers" id="mobile_numbers" class="form-control" rows="3" placeholder="017...,018..."></textarea>
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

@endpush
