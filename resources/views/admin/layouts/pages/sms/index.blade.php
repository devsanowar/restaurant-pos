@extends('admin.layouts.app')
@section('title', 'SMS Report')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')

    @php
        use App\Models\SmsLog;

        $totalSms = config('sms.total_sms_limit');
        $totalSendSms = SmsLog::sum('total_message');
        $totalSentSms = SmsLog::where('delivery_report', 'success')->sum('total_message');
        $remainingSms = max(0, $totalSms - $totalSentSms);

        use Carbon\Carbon;

        function banglaDate($date) {
            $english = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December'];
            $bangla  = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
            return str_replace($english, $bangla, Carbon::parse($date)->format('d F, Y'));
        }
    @endphp

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
                                    <table class="table table-nowrap mb-0" id="customerTable">
                                        <thead class="bg-light-subtle">
                                        <tr>
                                            <th class="ps-3" style="width: 50px;">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th>SL No</th>
                                            <th>Customer Name</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th class="text-center" style="width: 150px;">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @forelse ($customers as $customer)

                                            <tr>
                                                <td class="ps-3"><input type="checkbox" class="row-checkbox" name="selected[]" value="{{ $customer->id }}" data-phone="{{ $customer->phone }}"></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align: left">{{ $customer->name }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td style="text-align: left">{{ $customer->address }}</td>
                                                <td class="pe-3">
                                                    <div class="hstack gap-1 justify-content-center">

                                                        {{--                                                <form class="d-inline-block" action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST">--}}
                                                        {{--                                                    @csrf--}}
                                                        {{--                                                    @method('DELETE')--}}
                                                        {{--                                                    <button type="submit" class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"><i class="ti ti-trash"></i></button>--}}
                                                        {{--                                                </form>--}}

                                                        <button type="button" class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"><i class="ti ti-trash"></i></button>
                                                    </div>
                                                </td>
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
    </script>

    <script>
        $(document).ready(function () {
            window.customerTable = $('#customerTable').DataTable();
        });
    </script>

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const mobileBox = document.getElementById('mobile-box');--}}
{{--            const selectAll = document.getElementById('selectAll');--}}

{{--            $('#customerTable').on('change', '.row-checkbox', function () {--}}
{{--                const phone = this.dataset.phone.trim();--}}
{{--                let numbers = mobileBox.value.split(',').map(num => num.trim()).filter(num => num);--}}

{{--                if (this.checked) {--}}
{{--                    if (!numbers.includes(phone)) {--}}
{{--                        numbers.push(phone);--}}
{{--                    }--}}
{{--                } else {--}}
{{--                    numbers = numbers.filter(num => num !== phone);--}}
{{--                }--}}

{{--                const uniqueNumbers = Array.from(new Set(numbers));--}}
{{--                mobileBox.value = uniqueNumbers.join(', ');--}}
{{--            });--}}

{{--            if (selectAll) {--}}
{{--                selectAll.addEventListener('change', function () {--}}
{{--                    const allRows = window.customerTable.rows({ search: 'applied' }).nodes();--}}
{{--                    const checkboxes = $('input.row-checkbox', allRows);--}}
{{--                    let numbers = mobileBox.value.split(',').map(num => num.trim()).filter(num => num);--}}

{{--                    checkboxes.each(function () {--}}
{{--                        const phone = this.dataset.phone.trim();--}}
{{--                        this.checked = selectAll.checked;--}}

{{--                        if (selectAll.checked) {--}}
{{--                            if (!numbers.includes(phone)) {--}}
{{--                                numbers.push(phone);--}}
{{--                            }--}}
{{--                        } else {--}}
{{--                            numbers = numbers.filter(num => num !== phone);--}}
{{--                        }--}}
{{--                    });--}}

{{--                    const uniqueNumbers = Array.from(new Set(numbers));--}}
{{--                    mobileBox.value = uniqueNumbers.join(', ');--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        document.getElementById('selectAll').addEventListener('change', function () {--}}
{{--            const checked = this.checked;--}}
{{--            document.querySelectorAll('.row-checkbox').forEach(checkbox => {--}}
{{--                checkbox.checked = checked;--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileBox = document.getElementById('mobile-box');
            const selectAll = document.getElementById('selectAll');

            // Single row selection
            $('#customerTable').on('change', '.row-checkbox', function () {
                const phone = this.dataset.phone.trim();
                let numbers = mobileBox.value.split(',').map(num => num.trim()).filter(num => num);

                if (this.checked) {
                    if (!numbers.includes(phone)) {
                        numbers.push(phone);
                    }
                } else {
                    numbers = numbers.filter(num => num !== phone);
                }

                const uniqueNumbers = Array.from(new Set(numbers));
                mobileBox.value = uniqueNumbers.join(', ');
            });

            // Select all rows
            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    const allRows = window.customerTable.rows({ search: 'applied' }).nodes();
                    const checkboxes = $('input.row-checkbox', allRows);
                    let numbers = [];

                    checkboxes.each(function () {
                        const phone = this.dataset.phone.trim();
                        this.checked = selectAll.checked;

                        if (selectAll.checked) {
                            numbers.push(phone);
                        }
                    });

                    const uniqueNumbers = Array.from(new Set(numbers));
                    mobileBox.value = selectAll.checked ? uniqueNumbers.join(', ') : '';
                });
            }
        });
    </script>

    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Delete confirmation for dynamically loaded content
            $(document).on('click', '.show_confirm', function(event) {
                event.preventDefault();
                let form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endpush
