@extends('admin.layouts.app')
@section('title', 'Stock Out')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">
        <div class="page-container">

            <!-- Title -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">
                        <i class="ti ti-package"></i> Stock Out
                    </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Out</li>
                    </ol>
                </div>
            </div>

            <!-- All Stock Out -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Stock Out List</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.stock-out.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus me-1"></i> Add Stock Out
                                </a>
                            </div>
                        </div>

                        <!-- Errors -->
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
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">
                                        <input type="checkbox" class="form-check-input" id="selectAllStockOuts">
                                    </th>
                                    <th>S/N</th>
                                    <th>Stock Item</th>
                                    <th>Quantity Out</th>
                                    <th>Unit</th>
                                    <th>Reason / Note</th>
                                    <th>Stock Out Date</th>
                                    <th>Received By</th>
{{--                                    <th class="text-center" style="width: 150px;">Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($stockOuts as $stockOut)
                                    <tr id="row_{{ $stockOut->id }}">
                                        <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stockOut->stockItem->stock_item_name ?? '-' }}</td>
                                        <td>{{ $stockOut->quantity }}</td>
                                        <td>{{ $stockOut->unit }}</td>
                                        <td>{{ $stockOut->reason ?? '-' }}</td>
                                        <td>{{ $stockOut->stock_out_date ? date('d F, Y', strtotime($stockOut->stock_out_date)) : '-' }}</td>
                                        <td>{{ $stockOut->received_by ?? '-' }}</td>
{{--                                        <td class="pe-3">--}}
{{--                                            <div class="hstack gap-1 justify-content-end">--}}
{{--                                                <a href="{{ route('admin.stock-out.show', $stockOut->id) }}"--}}
{{--                                                   class="btn btn-soft-info btn-icon btn-sm rounded-circle"--}}
{{--                                                   title="View">--}}
{{--                                                    <i class="ti ti-eye fs-16"></i>--}}
{{--                                                </a>--}}
{{--                                                <a href="{{ route('admin.stock-out.edit', $stockOut->id) }}"--}}
{{--                                                   class="btn btn-soft-success btn-icon btn-sm rounded-circle"--}}
{{--                                                   title="Edit">--}}
{{--                                                    <i class="ti ti-edit fs-16"></i>--}}
{{--                                                </a>--}}
{{--                                                <a href="javascript:void(0);"--}}
{{--                                                   class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"--}}
{{--                                                   data-id="{{ $stockOut->id }}" title="Delete">--}}
{{--                                                    <i class="ti ti-trash"></i>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No stock out records found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    @if ($stockOuts->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $stockOuts->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    @foreach ($stockOuts->getUrlRange(1, $stockOuts->lastPage()) as $page => $url)
                                        <li class="page-item {{ $stockOuts->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $stockOuts->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($stockOuts->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $stockOuts->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- container -->

        <!-- Footer -->
        <footer class="footer">
            <div class="page-container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <script>document.write(new Date().getFullYear())</script>
                        © Restaurant POS - By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance IT</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>
    <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/stock-out/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This record will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success");
                            $("#row_" + id).remove();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
