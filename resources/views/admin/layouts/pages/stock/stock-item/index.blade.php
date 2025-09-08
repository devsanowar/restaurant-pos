@extends('admin.layouts.app')
@section('title', 'Restaurant POS | Stock Items')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">

            <!-- Page Title and Breadcrumb -->
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">
                        <i class="ti ti-user-check me-2"></i> Stock item management<span>| <a href="{{ route('admin.stock.item.deleted-data') }}">Recycle Bin (<span id="recycleCount">{{ $deletedItemCount }}</span>)</a></span></h4>

                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Item</li>
                    </ol>
                </div>
            </div>

            <!-- stock Management Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="ti ti-users me-2"></i> Stock item lists</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStockItemModal">
                        <i class="ti ti-plus me-1"></i> Add New
                    </button>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th><i class="ti ti-user"></i> Stock Item Name</th>
                                    <th class="text-end"><i class="ti ti-settings"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody id="waiterTableBody">
                                @forelse ($stockItems as $key => $stockItem)
                                    <tr id="row_{{ $stockItem->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $stockItem->stock_item_name ?? '' }}</td>

                                        <td class="text-end">
                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle editStockItemBtn"
                                                data-id="{{ $stockItem->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editStockItemModal" title="Edit">
                                                <i class="ti ti-edit fs-16"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                                                data-id="{{ $stockItem->id }}" title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No stock item found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            {!! $stockItems->links() !!}
                        </div>
                    </div>


                </div>
            </div>
            <!-- Add Waiter Modal -->
            @include('admin.layouts.pages.stock.stock-item.create')
            <!-- Edit Waiter Modal -->
            @include('admin.layouts.pages.stock.stock-item.edit')


        </div>



    </div>
@endsection



@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>

    <script>
        $(document).on('click', '.editStockItemBtn', function() {
            let stockItemId = $(this).data('id');

            $.ajax({
                url: '/admin/stock-item/' + stockItemId + '/edit',
                type: 'GET',
                success: function(stockItem) {
                    $('#edit_stock_item_id').val(stockItem.id);
                    $('#editStockItemName').val(stockItem.stock_item_name);

                    // dynamically form action set
                    $('#updateStockItemForm').attr('action', '/admin/stock-item/' +
                        stockItem.id);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Failed to load data!');
                }
            });
        });
    </script>

    <script>
        $(document).on('submit', '#updateStockItemForm', function(e) {
            e.preventDefault();

            let form = $(this);
            let actionUrl = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#editStockItemModal').modal('hide');

                    toastr.success(response.message, 'Success');

                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    let errorMsg = 'Update failed! Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg, 'Error');
                }
            });
        });
    </script>



    <script>
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            let url = "/admin/stock-item/" + id;

            Swal.fire({
                title: "Are you sure?",
                text: "This record will be deleted!",
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
                            Swal.fire("Deleted!", response.message, "message");
                            $("#row_" + id).remove();
                            // location.reload();
                            $("#recycleCount").text(response.deletedCount);
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.getElementById("searchWaiter").addEventListener("keyup", function() {
            let value = this.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach(function(row) {
                let name = row.querySelector("td:nth-child(2)").textContent
                    .toLowerCase(); // waiter_name column
                row.style.display = name.includes(value) ? "" : "none";
            });
        });

        // 🔽 Filter by Status
        document.getElementById("filterStatus").addEventListener("change", function() {
            let value = this.value;
            document.querySelectorAll("#waiterTableBody tr").forEach(function(row) {
                let status = row.querySelector("td:nth-child(5)").textContent.trim();
                if (value === "") {
                    row.style.display = "";
                } else if (value === "1" && status === "Active") {
                    row.style.display = "";
                } else if (value === "0" && status === "Inactive") {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>
@endpush
