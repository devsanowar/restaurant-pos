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
                                @forelse ($orders as $order)
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
                                            <div class="hstack gap-1 justify-content-end">

                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                   class="btn btn-soft-success btn-icon btn-sm rounded-circle show-order"
                                                   data-id="{{ $order->id }}"
                                                   title="Show">
                                                    <i class="ti ti-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                                   class="btn btn-soft-success btn-icon btn-sm rounded-circle edit-order"
                                                   data-id="{{ $order->id }}"
                                                   data-paid="{{ $order->paid }}"
                                                   title="Edit">
                                                    <i class="ti ti-edit fs-16"></i>
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                                      method="POST"
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"
                                                            title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
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
                                    @if ($orders->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                        <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $orders->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($orders->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
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
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>

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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modalEl = document.getElementById("orderEditModal");
            const modal = new bootstrap.Modal(modalEl);
            const form = document.querySelector("#orderEditModal form");

            const totalField = document.getElementById("order-edit-total");
            const paidInput = document.getElementById("order-edit-paid");
            const dueField = document.getElementById("order-edit-due");

            // Open modal and fetch order data
            document.querySelectorAll(".edit-order").forEach(button => {
                button.addEventListener("click", function (e) {
                    e.preventDefault();
                    const orderId = this.getAttribute("data-id");

                    fetch(`/admin/orders/${orderId}`, { headers: { "X-Requested-With": "XMLHttpRequest" } })
                        .then(res => res.json())
                        .then(order => {
                            // Set form action
                            form.action = `/admin/orders/${order.id}`;

                            // Fill modal fields
                            document.getElementById("order-edit-id").textContent = order.id;
                            document.getElementById("order-edit-date").textContent = order.date;
                            document.getElementById("table-edit-number").textContent = order.table_number;
                            document.getElementById("waiter-edit-name").textContent = order.waiter_name;
                            document.getElementById("customer-edit-phone").textContent = order.customer_phone;
                            totalField.textContent = order.total;
                            paidInput.value = order.paid;
                            dueField.textContent = order.due;
                            document.getElementById("order-edit-status").textContent = order.status;

                            // Fill items table
                            const tbody = document.getElementById("order-edit-items-body");
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

                            // Calculate due initially
                            calculateDue();

                            // Show modal
                            modal.show();
                        })
                        .catch(err => console.error("Fetch error:", err));
                });
            });

            // Calculate due / return dynamically
            function calculateDue() {
                const total = parseFloat(totalField.textContent) || 0;
                const paid = parseFloat(paidInput.value) || 0;
                const due = total - paid;

                if (due < 0) {
                    dueField.textContent = `${Math.abs(due)} (Return)`;
                    dueField.classList.add("text-success");
                    dueField.classList.remove("text-danger");
                } else if (due > 0) {
                    dueField.textContent = `${due} (Due)`;
                    dueField.classList.add("text-danger");
                    dueField.classList.remove("text-success");
                } else {
                    dueField.textContent = "0";
                    dueField.classList.remove("text-success", "text-danger");
                }
            }

            paidInput.addEventListener("input", calculateDue);

            // AJAX form submission
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(form);

                fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            modal.hide();

                            // Cleanup any leftover modal backdrop
                            document.body.classList.remove("modal-open");
                            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
                            document.body.style.overflow = "auto";
                            document.body.style.paddingRight = "0px";

                            // Open PDF receipt
                            const pdfWindow = window.open("");
                            pdfWindow.document.write(
                                `<iframe width='100%' height='100%' src='data:application/pdf;base64,${data.pdf}'></iframe>`
                            );

                            // Optionally reload to reflect updated order
                            setTimeout(() => location.reload(), 1000);
                        }
                    })
                    .catch(err => console.error("Update error:", err));
            });

            // Modal cleanup on close
            modalEl.addEventListener("hidden.bs.modal", function () {
                document.body.classList.remove("modal-open");
                document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
                document.body.style.overflow = "auto";
                document.body.style.paddingRight = "0px";
            });
        });
    </script>

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
