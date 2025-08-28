@extends('admin.layouts.app')
@section('title', 'All Cost - Recycle Bin')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
@endpush
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0"> Cost - Recycle bin </h4>
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
                            <h4 class="header-title mb-0">Deleted Cost List <span>
                                    <a href="#" class="btn btn-danger bg-gradient">
                                        <i class="ti ti-delete me-1"></i> Recycle Bin
                                    </a>
                                </span>
                            </h4>

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

                                            <!-- Date -->
                                            <td>{{ \Carbon\Carbon::parse($cost->date)->format('d M, Y') }}
                                            </td>

                                            <!-- Category Name (relation) -->
                                            <td>{{ $cost->category->category_name ?? 'N/A' }}</td>

                                            <!-- Field Name (relation) -->
                                            <td>{{ $cost->field->field_name ?? 'N/A' }}</td>

                                            <!-- Branch -->
                                            <td>{{ $cost->branch_name ?? '-' }}</td>

                                            <!-- Amount -->
                                            <td>{{ number_format($cost->amount, 2) }}</td>

                                            <!-- Spent By -->
                                            <td>{{ $cost->spend_by }}</td>

                                            <!-- Description -->
                                            <td>{{ $cost->description ?? '-' }}</td>

                                            <!-- Action -->
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">
                                                    <!-- Edit -->

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
                        {{-- <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                {!! $costs->links() !!}
                            </div>
                        </div> --}}
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
