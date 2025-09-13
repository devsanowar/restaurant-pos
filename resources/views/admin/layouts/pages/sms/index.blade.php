@extends('admin.layouts.app')
@section('title', 'Send SMS')

@push('styles')

@endpush

@section('admin_content')

    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Send SMS</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Send SMS</li>
                    </ol>
                </div>
            </div>

            <!-- All Suppliers Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <p class="text-center text-success"><b>{!! session('message') !!}</b></p>

                        <form action="{{ route('admin.send.sms') }}" method="POST">
                            @csrf

                            <div>
                                <!-- Header -->
                                <div
                                    class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                                    <h4 class="header-title mb-0">Customer List & Send SMS</h4>
                                </div>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0 dataTable">
                                        <thead class="bg-light-subtle">
                                        <tr>
                                            <th class="ps-3" style="width: 50px;">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th>SL No</th>
                                            <th>Mobile</th>
                                            <th>Customer Name</th>
                                            <th>Address</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @forelse ($customers as $customer)

                                            <tr>
                                                <td class="ps-3">
                                                    <input type="checkbox" class="row-checkbox" name="selected[]" value="{{ $customer->id }}" data-phone="{{ $customer->customer_phone }}">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $customer->customer_phone }}</td>
                                                <td style="text-align: left">{{ $customer->name ?? 'N/A' }}</td>
                                                <td style="text-align: left">{{ $customer->address ?? 'N/A' }}</td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No Customer found.</td>
                                            </tr>
                                        @endforelse

                                        </tbody>

                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        {{--                                {!! $sms_reports->links() !!}--}}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="border border-dashed bg-light bg-opacity-10 p-3 rounded">

                                    <div class="mb-2">
                                        <label for="mobile-box" class="form-label">Mobile Number(s)</label>
                                        <textarea name="mobile_numbers" id="mobile-box" class="form-control" rows="3" placeholder="017...,018...">{{ old('mobile_numbers') }}</textarea>
                                    </div>

                                    <div class="mb-2">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" id="message-box" class="form-control" rows="8" oninput="countSms()">{{ $sms_setting->default_message ?? '' }}</textarea>
                                        <small id="smsCounter">Characters: 0 | SMS Count: 0</small>
                                    </div>

                                    <button type="submit" class="btn btn-primary float-end">Send SMS</button>

                                </div>
                            </div>

                        </form>

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
        function countSms() {
            const text = document.getElementById('message-box').value;
            const counter = document.getElementById('smsCounter');

            const isUnicode = /[^\x00-\x7F]/.test(text);

            const charCount = isUnicode ? [...text].length : text.length;

            let singleLimit = isUnicode ? 70 : 160;
            let multiLimit = isUnicode ? 67 : 153;

            let smsCount = 0;
            if (charCount <= singleLimit) {
                smsCount = charCount > 0 ? 1 : 0;
            } else {
                smsCount = Math.ceil((charCount - singleLimit) / multiLimit) + 1;
            }

            counter.innerText =
                `Characters: ${charCount} | SMS Count: ${smsCount} (${isUnicode ? 'Bangla/Unicode' : 'English'})`;
        }

        // Run once on page load for default message
        document.addEventListener('DOMContentLoaded', countSms);

        // Optional: also run on input
        document.getElementById('message-box').addEventListener('input', countSms);
    </script>

    <script>
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const mobileBox = document.getElementById('mobile-box');

        // Bangladeshi phone number validation
        function isValidBangladeshiNumber(number) {
            const regex = /^01[3-9]\d{8}$/;
            return regex.test(number);
        }

        // Update mobile numbers textarea
        function updateMobileBox() {
            let numbers = [];
            rowCheckboxes.forEach(cb => {
                let phone = cb.dataset.phone.trim();
                if (cb.checked && phone !== '' && isValidBangladeshiNumber(phone)) {
                    numbers.push(phone);
                }
            });

            // Remove duplicates
            numbers = [...new Set(numbers)];

            mobileBox.value = numbers.join(', ');
        }

        // Select all checkbox
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => cb.checked = this.checked);
            updateMobileBox();
        });

        // Individual row checkbox
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    selectAllCheckbox.checked = Array.from(rowCheckboxes).every(c => c.checked);
                }
                updateMobileBox();
            });
        });
    </script>

@endpush

