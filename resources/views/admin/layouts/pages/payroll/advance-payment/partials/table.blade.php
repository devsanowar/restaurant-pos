<table class="table table-bordered mb-0 align-middle text-center">
    <thead class="bg-light">
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Salary Month</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Salary</th>
            <th>Advance Amount</th>
            <th>Remaining Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($advPayments as $key => $advPayment)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($advPayment->adv_payment_date)->format('d-m-Y') }}</td>
                <td>{{ $advPayment->month_name }}</td>
                <td>{{ $advPayment->employe->employe_name }}</td>
                <td>{{ $advPayment->employe->employe_designation }}</td>
                <td>{{ $advPayment->employe->employe_sallery }}</td>
                <td>{{ $advPayment->adv_paid }}</td>
                <td>{{ $advPayment->remaining_sallery }}</td>
                <td>
                    <div class="hstack gap-1 justify-content-center">
                        <a href="{{ route('admin.advance.payment.edit', $advPayment->id) }}" class="btn btn-soft-success btn-icon btn-sm rounded-circle" title="Edit">
                            <i class="ti ti-edit"></i>
                        </a>
                        <a href="#" class="btn btn-soft-danger btn-icon btn-sm rounded-circle" title="Delete">
                            <i class="ti ti-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Data not found!</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination Links -->
<div class="mt-2">
    {!! $advPayments->withQueryString()->links() !!}
</div>
