@extends('admin.layouts.app')
@section('title', 'Stock')
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
                        <i class="ti ti-package"></i> Stock
                    </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                    </ol>
                </div>
            </div>

            <!-- All Stock -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Stock List</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.purchase.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus me-1"></i> Add Stock
                                </a>
                                <a href="{{ route('admin.stock-out.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ti ti-minus me-1"></i> Stock Out
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
                                        <input type="checkbox" class="form-check-input" id="selectAllStocks">
                                    </th>
                                    <th>S/N</th>
                                    <th>Supplier</th>
                                    <th>Stock Item</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Purchase Price</th>
                                    <th>Stock Entry Date</th>
{{--                                    <th class="text-center">Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($stocks as $stock)
                                    <tr id="row_{{ $stock->id }}">
                                        <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stock->supplier->supplier_name ?? '-' }}</td>
                                        <td>{{ $stock->stockItem->stock_item_name ?? '-' }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ $stock->unit }}</td>
                                        <td>{{ number_format($stock->purchase_price, 2) }}</td>
                                        <td>{{ $stock->stock_entry_date ? date('d F, Y', strtotime($stock->stock_entry_date)) : '-' }}</td>
                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-center">
{{--                                                <a href="{{ route('admin.stock.edit', $stock->id) }}"--}}
{{--                                                   class="btn btn-soft-success btn-icon btn-sm rounded-circle"--}}
{{--                                                   title="Edit">--}}
{{--                                                    <i class="ti ti-edit fs-16"></i>--}}
{{--                                                </a>--}}
                                                <!-- Delete -->
{{--                                                <form action="{{ route('admin.stock.destroy', $stock->id) }}"--}}
{{--                                                      method="POST"--}}
{{--                                                      style="display:inline;">--}}
{{--                                                    @csrf--}}
{{--                                                    @method('DELETE')--}}
{{--                                                    <button type="submit"--}}
{{--                                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"--}}
{{--                                                            title="Delete">--}}
{{--                                                        <i class="ti ti-trash"></i>--}}
{{--                                                    </button>--}}
{{--                                                </form>--}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No stock found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($stocks->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $stocks->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($stocks->getUrlRange(1, $stocks->lastPage()) as $page => $url)
                                        <li class="page-item {{ $stocks->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $stocks->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($stocks->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $stocks->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
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

        <!-- Footer Start -->
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
