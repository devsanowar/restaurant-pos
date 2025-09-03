@extends('admin.layouts.app')
@section('title', 'SMS Report')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">SMS Report</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">SMS Report</li>
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
                            <h4 class="header-title mb-0">SMS Delivery Report ({{ $totalSmsCount }})</h4>
                        </div>

                    <!-- Table -->
                        <div class="table-responsive">

                            <form method="GET" action="" class="row justify-content-center mb-4 mt-3">
                                <div class="col-md-3">
                                    <label for="start_date"><b>Start Date</b></label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date"><b>End Date</b></label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success" style="margin-right: 5px">Filter</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Reset</a>
                                </div>
                            </form>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input" id="selectAllSuppliers">
                                        </th>
                                        <th>SL No</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Used SMS</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 150px;">Action</th>
                                    </tr>
                                    </thead>

                                    @php
                                        $totalSmsCount = 0;
                                    @endphp

                                    <tbody>
                                    @forelse ($sms_reports as $sms_report)

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

                                        <tr id="row_{{ $sms_report->id }}">
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sms_report->order?->name ?? 'Custom Number' }}</td>
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
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                                       title="View">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-soft-success btn-icon btn-sm rounded-circle editSupplierBtn"
                                                       data-id="{{ $sms_report->id }}" data-bs-toggle="modal"
                                                       data-bs-target="#editSupplierModal" title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>

                                                    <a href="javascript:void(0);"
                                                       class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                       data-id="{{ $sms_report->id }}" title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No suppliers found.</td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total Used SMS =</strong></td>
                                        <td colspan="4"><strong>{{ $totalSmsCount }} SMS</strong></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    {!! $sms_reports->links() !!}
                                </div>
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
