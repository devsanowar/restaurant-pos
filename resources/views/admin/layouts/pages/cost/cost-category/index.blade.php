@extends('admin.layouts.app')
@section('title', 'Add Category')
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Categories</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Osen</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hospital</a></li>

                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div
                            class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Category List</h4>
                            <div>
                                <a href="javascript:void(0)" class="btn btn-success bg-gradient" data-bs-toggle="modal"
                                    data-bs-target="#addCategoryModal">
                                    <i class="ti ti-plus me-1"></i> Add Category
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
                                        <th>Category Name</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Category Row -->
                                    @forelse ($categories as $key => $category)
                                        <tr>
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                <span class="text-dark fw-medium">{{ $category->category_name ?? '' }}</span>
                                            </td>
                                            <td>
                                                @if ($category->is_active == 0) 
                                                    <span class="badge bg-danger">Deactive</span>
                                                @else 
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="pe-3">
                                                <div class="hstack gap-1 justify-content-end">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-primary btn-icon btn-sm rounded-circle"
                                                        title="View">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle"
                                                        title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle"
                                                        title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td colspan="4" class="text-center text-danger">No Category Found</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.layouts.pages.cost.cost-category.create')

        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
