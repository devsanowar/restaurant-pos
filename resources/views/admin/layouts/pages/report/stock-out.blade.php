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
                        <i class="ti ti-package"></i> Stock Out Report
                    </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Out Report</li>
                    </ol>
                </div>
            </div>

            <!-- All Stock Out -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Stock Out Report</h4>
                        </div>

                        <form action="{{ route('admin.stockOut.report') }}" method="GET">
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

                                <div class="col-md-2">
                                    <label><strong>Receiver Name</strong></label>
                                    <select name="received_by" class="form-control show-tick">
                                        <option value="">-- Select Receiver --</option>
                                        @foreach($receivers as $receiver)
                                            <option value="{{ $receiver->received_by }}" {{ request('received_by') == $receiver->received_by ? 'selected' : '' }}>
                                                {{ $receiver->received_by }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 mb-0">
                                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                    <a href="{{ route('admin.stockOut.report') }}" class="btn btn-danger btn-sm">Reset</a>
                                </div>
                            </div>
                        </form>

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

@endpush
