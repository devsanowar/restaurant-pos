@extends('admin.layouts.app')
@section('title', 'Field Of Cost')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
@endpush
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Field Of Costs</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Web Application</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Restaurant POS</a></li>

                        <li class="breadcrumb-item active">Fiel of costs</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Field Of Cost List</h4>
                            <div>
                                <a href="javascript:void(0)" class="btn btn-success bg-gradient" data-bs-toggle="modal"
                                    data-bs-target="#addFieldOfCostModal">
                                    <i class="ti ti-plus me-1"></i>Add Field Of Cost
                                </a>

                                <a href="#" class="btn btn-secondary bg-gradient">
                                    <i class="ti ti-file-import me-1"></i> Import
                                </a>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>S/N</th>
                                        <th>Field Name</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Field Of Cost Row -->
                                    @forelse ($fieldOfCosts as $key => $fieldOfCost)
                                        <tr id="fieldOfCost-row-{{ $fieldOfCost->id }}">
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span
                                                    class="text-dark fw-medium">{{ $fieldOfCost->field_name ?? '' }}</span>
                                            </td>
                                            <td>
                                                @if ($fieldOfCost->is_active == 0)
                                                    <span class="badge bg-danger">Deactive</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">


                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle editFieldOfCostBtn"
                                                        data-id="{{ $fieldOfCost->id }}" title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>


                                                    <form class="deleteFounder d-inline-block" method="POST"
                                                        action="{{ route('admin.field-of-cost.destroy', $fieldOfCost->id) }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle show_confirm"
                                                            title="Delete"
                                                            data-id="{{ $fieldOfCost->id }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>


                                                </div>
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td colspan="4" class="text-center text-danger">No Field Of Cost Found</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {!! $fieldOfCosts->links() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @include('admin.layouts.pages.cost.field-of-cost.modal')

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle click on edit button
            $('.editFieldOfCostBtn').on('click', function() {
                var fieldOfCostId = $(this).data('id');

                // Send AJAX request to get field of cost data
                $.ajax({
                    url: '/admin/field-of-cost/' + fieldOfCostId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        // Update modal title
                        $('#addFieldOfCostModalLabel').text('Edit Field Of Cost');

                        // Fill form inputs
                        $('#fieldName').val(response.field_name);
                        $('#is_active').val(response.is_active);

                        // Change form action to update route
                        $('#fieldOfCostForm').attr('action', '/admin/field-of-cost/' + fieldOfCostId);

                        // Add hidden input for method spoofing (PUT)
                        if ($('#fieldOfCostForm input[name="_method"]').length === 0) {
                            $('#fieldOfCostForm').append(
                                '<input type="hidden" name="_method" value="PUT">');
                        }

                        // Show the modal
                        $('#addFieldOfCostModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Something went wrong while fetching the Field of cost data.');
                    }
                });
            });

            // Optional: Reset form on modal close
            $('#addFieldOfCostModal').on('hidden.bs.modal', function() {
                $('#addFieldOfCostModalLabel').text('Add New Field Of Cost');
                $('#fieldOfCostForm').trigger('reset');
                $('#fieldOfCostForm').attr('action', '{{ route('admin.field-of-cost.store') }}');
                $('#fieldOfCostForm input[name="_method"]').remove();
            });
        });


        // Delete with ajax
    $(document).ready(function () {
        $('.show_confirm').on('click', function (e) {
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
                        success: function (response) {
                            toastr.success(response.message || 'Deleted successfully!');
                            // Row remove (assuming the button is inside a <tr>)
                            form.closest('tr').remove();
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        }
                    });
                }
            });
        });
    });


    </script>
@endpush
