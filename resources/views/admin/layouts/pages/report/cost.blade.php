@extends('admin.layouts.app')
@section('title', 'Cost Report')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
@endpush
@section('admin_content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold mb-0">Cost Report</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cost Report</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Header -->
                        <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                            <h4 class="header-title mb-0">Cost Report</h4>
                        </div>

                        <form action="{{ route('admin.cost.report') }}" method="GET">
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
                                    <label><strong>Cost Category</strong></label>
                                    <select name="cost_category_name" class="form-control show-tick">
                                        <option value="">-- Select Category --</option>
                                        @foreach($costCategories as $category)
                                            <option value="{{ $category->id }}" {{ request('cost_category_name') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label><strong>Field of Cost</strong></label>
                                    <select name="cost_field_name" class="form-control show-tick">
                                        <option value="">-- Select Cost Field --</option>
                                        @foreach($fieldOfCosts as $field)
                                            <option value="{{ $field->id }}" {{ request('cost_field_name') == $field->id ? 'selected' : '' }}>
                                                {{ $field->field_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label><strong>Spend By</strong></label>
                                    <select name="spend_by" class="form-control show-tick">
                                        <option value="">-- Select Spender --</option>
                                        @foreach($spendBy as $spend)
                                            <option value="{{ $spend->spend_by }}" {{ request('spend_by') == $spend->spend_by ? 'selected' : '' }}>
                                                {{ $spend->spend_by }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-1 mb-0">
                                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                    <a href="{{ route('admin.cost.report') }}" class="btn btn-danger btn-sm">Reset</a>
                                </div>
                            </div>
                        </form>

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
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($costs->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="ti ti-chevrons-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $costs->previousPageUrl() }}"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($costs->getUrlRange(1, $costs->lastPage()) as $page => $url)
                                        <li class="page-item {{ $costs->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link {{ $costs->currentPage() == $page ? 'bg-primary text-white' : '' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($costs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $costs->nextPageUrl() }}"><i class="ti ti-chevrons-right"></i></a>
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

        </div>
    </div>
@endsection

@push('scripts')

@endpush
