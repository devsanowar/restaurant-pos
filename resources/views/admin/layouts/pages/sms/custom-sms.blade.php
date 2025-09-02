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
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="border border-dashed bg-light bg-opacity-10 p-3 rounded">
                                <div id="smsSummary" class="alert alert-info">
                                    Total SMS: 2500 | Sent: <strong>{{ $totalSendSms }}</strong> | Remaining: <strong>{{ $remainingSms }}</strong>
                                </div>

                                <form action="{{ route('admin.send.message') }}" method="POST" id="customSmsForm" style="margin-bottom: 50px ">
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

    <script>
        $(document).ready(function() {
            function updateCharacterCount() {
                let message = $("#message").val();
                let totalCharacters = message.length;
                let totalMessages;

                // Check if the message contains non-ASCII characters (indicating UCS2 encoding)
                let isUCS2 = /[^\x00-\x7F]/.test(message);  // Checks for non-ASCII characters

                if (isUCS2) {
                    // UCS2 Encoding (63 characters per SMS)
                    totalMessages = Math.ceil(totalCharacters / 63);
                } else {
                    // GSM-7 Encoding (160 characters per SMS)
                    totalMessages = Math.ceil(totalCharacters / 160);
                }

                // Limit the message length to 1080 characters
                if (totalCharacters > 1080) {
                    alert("Maximum character limit exceeded!");
                    $("#message").val(message.substring(0, 1080)); // Trim characters to 1080
                    totalCharacters = 1080;

                    // Recalculate the message parts based on UCS2 encoding (63 characters per part)
                    if (isUCS2) {
                        totalMessages = Math.ceil(totalCharacters / 63);
                    } else {
                        totalMessages = Math.ceil(totalCharacters / 160);
                    }
                }

                // Update character and message count in the UI
                $("#total_characters").val(totalCharacters);
                $("#total_messages").val(totalMessages);
            }

            function updateTotalNumbers() {
                let numbers = $("#mobile_numbers").val();
                let cleanNumbers = numbers.replace(/\s+/g, ''); // Remove spaces
                let numberList = cleanNumbers.split(',').filter(num => num.trim() !== ""); // Convert to array, remove empty
                $("#total_numbers").val(numberList.length);
            }

            // Run on input for message
            $("#message").on("input", updateCharacterCount);

            // Run on input for mobile numbers
            $("#mobile_numbers").on("input", updateTotalNumbers);

            // Run when page loads (if fields have pre-filled values)
            updateCharacterCount();
            updateTotalNumbers();
        });
    </script>

@endpush
