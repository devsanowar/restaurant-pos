@extends('admin.layouts.app')
@section('title', 'SMM Report')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">SMS Delivery Report ({{ $totalSmsCount }})</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Supplier</li>
                    </ol>
                </div>
            </div>

            <!-- All Suppliers Data -->
            <!-- All Suppliers Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Supplier List</h4>
                            <div class="d-flex gap-2">
                                <!-- Add Supplier Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addSupplierModal">
                                    <i class="ti ti-plus me-1"></i> Add Supplier
                                </button>

                                <!-- Import Button with File Input -->
                                <div class="position-relative">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                            onclick="document.getElementById('importFileInput').click();">
                                        <i class="ti ti-file-import me-1"></i> Import
                                    </button>
                                    <input type="file" id="importFileInput" accept=".csv, .xlsx" style="display: none;"
                                           onchange="handleFileUpload(event)">
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif


                    <!-- Table -->
                        <div class="table-responsive">

                            <form method="GET" action="" class="row justify-content-center mb-4">
                                <div class="col-md-3">
                                    <label for="start_date"><b>Start Date</b></label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date"><b>End Date</b></label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success" style="margin-right: 5px">Filter</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Reset</a>
                                </div>
                            </form>

                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th>SL No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Used SMS</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @php
                                    $totalSmsCount = 0;
                                @endphp

                                <tbody>
                                @foreach ($sms_reports as $key=>$sms_report)

                                    @php
                                        $message = $sms_report->message_body;
                                        $charCount = mb_strlen($message, 'UTF-8');

                                        $isUnicode = preg_match('/[^\x00-\x7F]/', $message);
                                        $segmentSize = $isUnicode ? 70 : 160;

                                        $smsCount = ceil($charCount / $segmentSize);
                                        if ($sms_report->success == 1) {
                                            $totalSmsCount += $smsCount;
                                        }

                                    @endphp

                                    <tr>
                                        <td>{{$key+1 }}</td>
                                        <td>
                                            {{ $sms_report->order?->name ?? 'Custom Number' }}
                                        </td>
                                        <td>{{ $sms_report->mobile }}</td>
                                        <td>{{ $smsCount }} SMS</td>


                                        <td>{{ $sms_report->created_at->format('d-m-Y h:i A') }}</td>
                                        <td>
                                            @if($sms_report->success == 1)
                                                <a href="" class="btn btn-success">Success</a>
                                            @else
                                                <a href="" class="btn btn-danger">Failed</a>
                                            @endif
                                        </td>

                                        <td>

                                            @auth
                                                @if(auth()->user()->system_admin === 'Admin')
                                                    <form class="d-inline-block" action="{{ route('sms-report.destroy', $sms_report->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm show_confirm"><i class="material-icons">delete</i></button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total Used SMS =</strong></td>
                                    <td colspan="4"><strong>{{ $totalSmsCount }} SMS</strong></td>
                                </tr>
                                </tfoot>
                            </table>
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

{{--@push('scripts')--}}

{{--    <script>--}}
{{--        $(function () {--}}
{{--            $('.js-basic-example').DataTable({--}}
{{--                dom:--}}
{{--                    "<'row d-flex align-items-center mb-2'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +--}}
{{--                    "<'row'<'col-sm-12'tr>>" +--}}
{{--                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",--}}
{{--                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],--}}
{{--                pageLength: 100,--}}
{{--                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],--}}
{{--                stateSave: true,--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--    <!-- Jquery DataTable Plugin Js -->--}}
{{--<script src="{{ asset('backend') }}/assets/bundles/datatablescripts.bundle.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>--}}

{{--<!-- Custom Js -->--}}
{{--<script src="{{ asset('backend') }}/assets/js/pages/tables/jquery-datatable.js"></script>--}}
{{--    --}}
{{--@endpush--}}
