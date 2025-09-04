@extends('admin.layouts.app')
@section('title', 'All Cost')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
@endpush
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">All Costs</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restaurant POS</a></li>

                        <li class="breadcrumb-item active">costs</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Cost List <span> | <a href="{{ route('admin.cost.deleted-data') }}">Recycle Bin (<span id="recycleCount">{{ $deletedCostCount }}</span>)</a></span></h4>
                            <div>
                                <!-- Add Cost Button -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addCostModal">
                                    <i class="ti ti-plus me-1"></i> Add Cost
                                </button>

                            </div>

                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0" id="costTable">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input" id="selectAllCosts">
                                        </th>

                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Field</th>
                                        <th>Branch</th>
                                        <th>Amount</th>
                                        <th>Spent By</th>
                                        <th>Description</th>
                                        <th class="text-center" style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($costs as $key => $cost)
                                        <tr id="cost-row-{{ $cost->id }}">
                                            <td class="ps-3">
                                                <input type="checkbox" class="form-check-input">
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cost->date)->format('d M, Y') }}
                                            </td>
                                            <td>{{ $cost->category->category_name ?? 'N/A' }}</td>
                                            <td>{{ $cost->field->field_name ?? 'N/A' }}</td>
                                            <td>{{ $cost->branch_name ?? '-' }}</td>
                                            <td>{{ number_format($cost->amount, 2) }}</td>
                                            <td>{{ $cost->spend_by }}</td>
                                            <td>{{ $cost->description ?? '-' }}</td>
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">
                                                    <!-- Edit -->
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle editCostBtn"
                                                        data-id="{{ $cost->id }}"
                                                        data-date="{{ \Carbon\Carbon::parse($cost->date)->format('Y-m-d') }}"
                                                        data-category="{{ $cost->category_id }}"
                                                        data-field="{{ $cost->field_id }}"
                                                        data-branch="{{ $cost->branch_name }}"
                                                        data-amount="{{ $cost->amount }}"
                                                        data-spend="{{ $cost->spend_by }}"
                                                        data-description="{{ $cost->description }}" title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>



                                                    <!-- Delete -->
                                                    <form class="deleteCost d-inline-block" method="POST"
                                                        action="{{ route('admin.cost.destroy', $cost->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"
                                                            title="Delete" data-id="{{ $cost->id }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-danger">No Cost Found</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {!! $costs->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @include('admin.layouts.pages.cost.create')
            @include('admin.layouts.pages.cost.edit')

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>


    <script>
        $(document).on('click', '.editCostBtn', function() {
            let id = $(this).data('id');
            $('#edit_cost_id').val(id);

            // set form action dynamically
            $('#editCostForm').attr('action', '/admin/cost/' + id);

            // fill other fields
            $('#edit_date').val($(this).data('date')); // YYYY-MM-DD
            $('#edit_category_id').val($(this).data('category'));
            $('#edit_field_id').val($(this).data('field'));
            $('#edit_branch_name').val($(this).data('branch'));
            $('#edit_amount').val($(this).data('amount'));
            $('#edit_spend_by').val($(this).data('spend'));
            $('#edit_description').val($(this).data('description'));

            $('#editCostModal').modal('show');
        });
    </script>



    <script>
        // Delete with ajax
        $(document).ready(function() {
            $('.show_confirm').on('click', function(e) {
                e.preventDefault();

                let button = $(this);
                let form = button.closest('form');
                let fieldOfCostId = button.data('id');
                let actionUrl = form.attr('action');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: {
                                _token: form.find('input[name="_token"]').val(),
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                toastr.success(response.message ||
                                    'Deleted successfully!');
                                // Row remove (assuming the button is inside a <tr>)
                                form.closest('tr').remove();

                                $("#recycleCount").text(response.deletedCount);
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON?.message ||
                                    'Something went wrong!');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
