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
                        <i class="ti ti-package"></i> Stock Report
                    </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Report</li>
                    </ol>
                </div>
            </div>

            <!-- All Stock -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Stock Report</h4>
                        </div>

                        <form action="{{ route('admin.stock.report') }}" method="GET">
                            <div class="d-flex justify-content-center align-items-end gap-2 mb-4" style="padding: 20px">

                                <div class="col-md-2">
                                    <label><strong>Start Date</strong></label>
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>

                                <div class="col-md-2">
                                    <label><strong>End Date</strong></label>
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>

                                <div class="col-md-2">
                                    <label><strong>Supplier Name</strong></label>
                                    <select name="supplier_name" class="form-control show-tick">
                                        <option value="">-- Select Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ request('supplier_name') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->supplier_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label><strong>Stock Items</strong></label>
                                    <select name="stock_item_name" class="form-control show-tick">
                                        <option value="">-- Select Item --</option>
                                        @foreach($stockItems as $stockItem)
                                            <option value="{{ $stockItem->id }}" {{ request('stock_item_name') == $stockItem->id ? 'selected' : '' }}>
                                                {{ $stockItem->stock_item_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 mb-0">
                                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                    <a href="{{ route('admin.stock.report') }}" class="btn btn-danger btn-sm">Reset</a>
                                </div>
                            </div>
                        </form>

                    <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">
                                        <input type="checkbox" class="form-check-input" id="selectAllStocks">
                                    </th>
                                    <th>S/N</th>
                                    <th>Entry Date</th>
                                    <th>Supplier</th>
                                    <th>Stock Item</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Purchase Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($stocks as $stock)
                                    <tr id="row_{{ $stock->id }}">
                                        <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stock->stock_entry_date }}</td>
                                        <td>{{ $stock->supplier->supplier_name ?? '-' }}</td>
                                        <td>{{ $stock->stockItem->stock_item_name ?? '-' }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ $stock->unit }}</td>
                                        <td>{{ number_format($stock->purchase_price, 2) }}</td>
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

@endpush
