@extends('admin.layouts.app')
@section('title', 'Restaurant management')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
@endpush
@section('admin_content')
    <div class="page-content">

        <div class="page-container">


            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Restaurant Management</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                        <li class="breadcrumb-item active">Restaurant Management</li>
                    </ol>
                </div>
            </div>

            <!-- User Management Body -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed">
                            <h4 class="card-title">Add Restaurant</h4>
                        </div>
                        <div class="card-body">
                            <form id="addRestuarantForm">
                                @csrf
                                <div class="row">
                                    <!-- Restaurant Name -->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="restaurantBranchName" class="form-label">Restaurant Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="restaurantBranchName"
                                                name="restaurant_branch_name" placeholder="Enter  name" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <label for="restaurant" class="form-label">Select status</label>
                                        <select class="form-select" id="restaurant" name="status">
                                            <option selected="">Select Restaurant....</option>
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>
                                    </div>

                                    <!-- Add User Button -->
                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti ti-user-plus me-1"></i> Add Restaurant
                                        </button>
                                    </div>
                            </form>

                            <hr class="my-4">

                            <!-- Restaurant List -->
                            <h5 class="mb-3">Restaurant List</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Restuarant Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($restaurants as $key => $restaurant)
                                            <tr id="row-{{ $restaurant->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $restaurant->restaurant_branch_name }}</td>
                                                <td>
                                                    @if ($restaurant->status == 1)
                                                        <span class="badge bg-success">ON</span>
                                                    @else
                                                        <span class="badge bg-danger">OFF</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary me-1 editBtn"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="{{ $restaurant->id }}">
                                                        <i class="ti ti-edit"></i>
                                                    </button>

                                                    <form class="d-inline-block" method="POST"
                                                        action="{{ route('admin.restaurant.branch.destroy', $restaurant->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn  btn-icon btn-sm btn-outline-danger show_confirm"
                                                            title="Delete" data-id="{{ $restaurant->id }}">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        @include('admin.layouts.pages.restaurants.edit')
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>
    <script>
        $('#addRestuarantForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            // Clear previous errors
            $('.error-text').text('');

            $.ajax({
                url: "{{ route('admin.restaurant.branch.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.message) {
                        $('#addRestuarantForm')[0].reset();
                        toastr.success(response.message);
                        location.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.' + key + '_error').text(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.editBtn').click(function() {
                let id = $(this).data('id');

                // AJAX call to get restaurant data
                $.get('/admin/restaurant-branch/' + id + '/edit', function(data) {
                    $('#editRestaurantId').val(data.id);
                    $('#editRestaurantName').val(data.name);
                    // onno fields
                });
            });
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
                                form.closest('tr').remove();
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
