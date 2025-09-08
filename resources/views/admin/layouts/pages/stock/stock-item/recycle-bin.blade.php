@extends('admin.layouts.app')
@section('title', 'Trashed stock item List')
@push('styles')
    <link href="{{ asset('backend') }}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Stock item deleted list</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Stock item</li>
                    </ol>
                </div>
            </div>

            <!-- All income Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Stock Item deleted List <span>| <a
                                        href="{{ route('admin.stock.item.deleted-data') }}">Recycle Bin (<span
                                            id="recycleCount">{{ $deletedCount }}</span>)</a></span>

                            </h4>
                            <div class="d-flex gap-2">
                                <!-- All Supplier Button -->
                                <a href="{{ route('admin.stock.item.index') }}" class="btn btn-primary btn-sm">All
                                    stock item</a>
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
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input" id="selectAllSuppliers">
                                        </th>
                                        <th>S/N</th>
                                        <th><i class="ti ti-user"></i> Stock item name</th>
                                        <th class="text-center" style="width:60px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stockItems as $stockItem)
                                        <tr id="row_{{ $stockItem->id }}">
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $stockItem->stock_item_name ?? '' }}</td>

                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-primary btn-sm restoreBtn"
                                                        data-id="{{ $stockItem->id }}" title="Restore">
                                                        Restore
                                                    </a>

                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-danger btn-sm forceDeleteBtn"
                                                        data-id="{{ $stockItem->id }}">
                                                        Parmanently Delete
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No stock items found.</td>
                                        </tr>
                                    @endforelse

                                    <!-- Repeat similar rows dynamically -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection


    @push('scripts')
        <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>


        <script>
            $(document).on('click', '.restoreBtn', function() {
                let id = $(this).data('id');
                let url = "{{ route('admin.stock.item.restore-data') }}";

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to restore this stock item?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, restore it!",
                    cancelButtonText: "Cancel",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Row remove from recycle bin list
                                    $("#row_" + id).fadeOut(500, function() {
                                        $(this).remove();
                                    });

                                    // Update recycle bin count
                                    $("#recycleCount").text(response.deletedCount);

                                    Swal.fire("Restored!", response.message, "success");
                                } else {
                                    Swal.fire("Error!", response.message, "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Error!", "Something went wrong.", "error");
                            }
                        });
                    }
                });
            });
        </script>


        <script>
            $(document).on('click', '.forceDeleteBtn', function() {
                let id = $(this).data('id');
                let url = "/admin/stock-item/permanantly-destroy-data/" + id;

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
                                if (response.status === 'success') {
                                    // Row remove with fade out
                                    $("#row_" + id).fadeOut(500, function() {
                                        $(this).remove();
                                    });

                                    // Update recycle bin count
                                    $("#recycleCount").text(response.deletedCount);

                                    Swal.fire("Deleted!", response.message, "success");
                                } else {
                                    Swal.fire("Error!", response.message, "error");
                                }
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
