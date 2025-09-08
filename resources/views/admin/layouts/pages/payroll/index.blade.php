@extends('admin.layouts.app')
@section('title', 'All Payroll')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Payroll</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Payroll</li>
                    </ol>
                </div>
            </div>

            <!-- All Suppliers Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">All Playroll</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.payroll.create') }}" class="btn btn-primary btn-sm">Add Payroll</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <thead class="bg-light-subtle">
                                        <tr>

                                            <th>S/N</th>
                                            <th>Image</th>
                                            <th>Job-Id</th>
                                            <th>Name</th>
                                            <th>Restaurant</th>
                                            <th>Joining Date</th>
                                            <th>Mobile</th>
                                            <th>Designation</th>
                                            <th>Salary</th>
                                            <th>Over time rate</th>
                                            <th class="text-center" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($payrolls as $key => $payroll)
                                            <tr>
                                                <td>{{ $payrolls->firstItem() + $key }}</td>
                                                <td><img src="{{ asset($payroll->employe_image) }}" alt=""
                                                        width="40px"></td>
                                                <td>{{ $payroll->id_number}}</td>
                                                <td>{{ $payroll->employe_name }}</td>
                                                <td>{{ $payroll->restaurant->restaurant_branch_name ?? '-' }}</td>
                                                <td>{{ $payroll->joining_date }}</td>
                                                <td>{{ $payroll->employe_phone }}</td>
                                                <td>{{ $payroll->employe_designation }}</td>
                                                <td>{{ $payroll->employe_sallery }}</td>
                                                <td>{{ $payroll->employe_overtime_rate }}</td>
                                                <td class="pe-3">
                                                    <div class="hstack gap-1 justify-content-end">
                                                        <a href="#"
                                                            class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                                            title="View">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.payroll.edit',$payroll->id) }}"
                                                            class="btn btn-soft-success btn-icon btn-sm rounded-circle"
                                                            title="Edit">
                                                            <i class="ti ti-edit"></i>
                                                        </a>

                                                        <form class="d-inline-block" method="POST"
                                                        action="{{ route('admin.payroll.destroy', $payroll->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"
                                                            title="Delete" data-id="{{ $payroll->id }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No employees found.</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- Footer: Pagination or Total Salary -->
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total Salary: <span class="text-primary">32,000</span></span>
                                <!-- Custom Pagination -->
                                @if ($payrolls->hasPages())
                                    <ul class="pagination mb-0">
                                        <!-- Previous -->
                                        <li class="page-item {{ $payrolls->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $payrolls->previousPageUrl() }}">
                                                <i class="ti ti-chevrons-left"></i>
                                            </a>
                                        </li>

                                        <!-- Page Numbers -->
                                        @foreach ($payrolls->getUrlRange(1, $payrolls->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $payrolls->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Next -->
                                        <li class="page-item {{ $payrolls->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $payrolls->nextPageUrl() }}">
                                                <i class="ti ti-chevrons-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- container -->

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
