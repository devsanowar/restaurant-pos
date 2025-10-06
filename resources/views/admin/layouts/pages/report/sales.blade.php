@extends('admin.layouts.app')
@section('title', 'All Order')
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
                        <i class="ti ti-menu-order"></i> Orders
                    </h4>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>

            <!-- All Stock -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">All Order</h4>
                        </div>

                        <form action="{{ route('admin.sales.report') }}" method="GET">
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
                                    <label><strong>Table Number</strong></label>
                                    <select name="table_number" id="table_number" class="form-control show-tick">
                                        <option value="">-- Select Table --</option>
                                        @foreach($resTables as $table)
                                            <option value="{{ $table->id }}" {{ request('table_number') == $table->id ? 'selected' : '' }}>
                                                {{ $table->table_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label><strong>Waiter Name</strong></label>
                                    <select name="waiter_name" id="waiter_name" class="form-control show-tick">
                                        {{-- Options will be loaded dynamically --}}
                                    </select>
                                </div>

                                <div class="col-md-2 mb-0">
                                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                    <a href="{{ route('admin.sales.report') }}" class="btn btn-danger btn-sm">Reset</a>
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
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Table No</th>
                                    <th>Waiter</th>
                                    <th>Customer Phone</th>
                                    <th>Bill Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 150px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($sales as $order)
                                    <tr id="row_{{ $order->id }}">
                                        <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                        <td>#00{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d F, Y') ?? '-' }}</td>
                                        <td>{{ $order->table->table_number ?? '-' }}</td>
                                        <td>{{ $order->waiter->waiter_name ?? '-' }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>{{ $order->total }}</td>
                                        <td>{{ $order->paid }}</td>
                                        <td>{{ $order->due }}</td>
                                        <td>
                                            @if($order->due <= 0)
                                                <span class="btn btn-success btn-sm badge">Completed</span>
                                            @else
                                                <span class="btn btn-warning btn-sm badge">Pending</span>
                                            @endif
                                        </td>
                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-center">

                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                   class="btn btn-soft-success btn-icon btn-sm rounded-circle show-order"
                                                   data-id="{{ $order->id }}"
                                                   title="Show">
                                                    <i class="ti ti-eye"></i>
                                                </a>

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
                                    @if ($sales->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $sales->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($sales->getUrlRange(1, $sales->lastPage()) as $page => $url)
                                        <li class="page-item {{ $sales->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $sales->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($sales->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $sales->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
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

    <!-- Show Modal -->
    @include('admin.layouts.pages.orders.show')

    <!-- Edit Modal -->
    @include('admin.layouts.pages.orders.edit')

@endsection

@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let tableSelect  = document.getElementById('table_number');
            let waiterSelect = document.getElementById('waiter_name');

            // Store selected waiter from request (Laravel blade)
            let selectedWaiterId = "{{ request('waiter_name') }}";

            function loadWaiters(tableId, preselectId = null) {
                waiterSelect.innerHTML = ''; // clear

                if (tableId) {
                    fetch(`/admin/get-waiters/${tableId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(waiter => {
                                let option = document.createElement('option');
                                option.value = waiter.id;
                                option.textContent = waiter.waiter_name;

                                // If matches request('waiter_name'), mark selected
                                if (preselectId && preselectId == waiter.id) {
                                    option.selected = true;
                                }

                                waiterSelect.appendChild(option);
                            });
                        });
                }
            }

            // Load waiters when table changes
            tableSelect.addEventListener('change', function () {
                loadWaiters(this.value);
            });

            // If page already has selected table → load waiters immediately
            if (tableSelect.value) {
                loadWaiters(tableSelect.value, selectedWaiterId);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".show-order").forEach(button => {
                button.addEventListener("click", function (e) {
                    e.preventDefault(); // prevent link navigation

                    const orderId = this.getAttribute("data-id");

                    fetch(`/admin/orders/${orderId}`, {
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    })
                        .then(res => res.json())
                        .then(order => {
                            // fill modal
                            document.getElementById("order-id").textContent = order.id;
                            document.getElementById("order-date").textContent = order.date;
                            document.getElementById("table-number").textContent = order.table_number;
                            document.getElementById("waiter-name").textContent = order.waiter_name;
                            document.getElementById("customer-phone").textContent = order.customer_phone;
                            document.getElementById("order-total").textContent = order.total;
                            document.getElementById("order-paid").textContent = order.paid;
                            document.getElementById("order-due").textContent = order.due;
                            document.getElementById("order-status").textContent = order.status;

                            const tbody = document.getElementById("order-items-body");
                            tbody.innerHTML = "";
                            order.items.forEach(item => {
                                tbody.innerHTML += `
                        <tr>
                            <td>${item.product_name}</td>
                            <td class="text-center">${item.price}</td>
                            <td class="text-center">${item.quantity}</td>
                            <td class="text-center">${item.subtotal}</td>
                        </tr>`;
                            });

                            // open modal
                            const modal = new bootstrap.Modal(document.getElementById("orderModal"));
                            modal.show();
                        })
                        .catch(err => console.error("Fetch error:", err));
                });
            });
        });
    </script>

@endpush
