<table class="table table-nowrap mb-0">
    <thead class="bg-light-subtle">
        <tr>
            <th class="ps-3" style="width: 50px;">SL</th>
            <th>Employee Image</th>
            <th>Starting Salary</th>
            <th>Inc. Amount</th>
            <th>Inc. Date</th>
            <th>Salary From Date</th>
            <th>Present Salary</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($salaries as $key => $salary)
            <tr id="row_{{ $salary->id }}">
                <td class="ps-3">{{ $key + 1 }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset($salary->employee->employe_image) }}"
                            alt="{{ $salary->employee->employe_name }}" class="img-thumbnail me-2"
                            style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <span class="fw-medium">{{ $salary->employee->employe_name }}</span><br>
                            <small class="text-muted">{{ $salary->employee->employe_designation }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $salary->starting_salary }}</td>
                <td>{{ $salary->increment_amount }}</td>
                <td>{{ \Carbon\Carbon::parse($salary->increment_effective_from)->format('d F Y') }}</td>
                <td>
                    @if ($salary->present_salary > 0)
                        {{ \Carbon\Carbon::parse($salary->salary_effective_date)->format('d F Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $salary->present_salary }}</td>
                <td class="text-center">
                    <div class="hstack gap-1 justify-content-center">
                        <a href="{{ route('admin.salary.edit', $salary->id) }}"
                            class="btn btn-soft-success btn-icon btn-sm rounded-circle" title="Edit">
                            <i class="ti ti-edit"></i>
                        </a>

                        <a href="javascript:void(0);"
                            class="btn btn-soft-danger btn-icon btn-sm rounded-circle deleteBtn"
                            data-id="{{ $salary->id }}" title="Delete">
                            <i class="ti ti-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No salaries found</td>
            </tr>
        @endforelse
    </tbody>
</table>
