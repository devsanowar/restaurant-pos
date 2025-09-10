<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvancePayment;
use App\Models\PayRoll;
use Illuminate\Http\Request;

class AdvancePaymentController extends Controller
{
    public function index()
    {
        $employes = PayRoll::select(['id', 'employe_name', 'employe_sallery'])->get();
        $advPayments = AdvancePayment::with(['employe:id,employe_name,employe_designation,employe_sallery'])
            ->latest()
            ->paginate(20);
        return view('admin.layouts.pages.payroll.advance-payment.index', compact('employes', 'advPayments'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'employe_id' => 'required|exists:pay_rolls,id',
            'adv_payment_date' => 'required|date',
            'month_name' => 'required',
            'adv_paid' => 'required|numeric|min:0',
        ]);

        // Find employee
        $employe = PayRoll::findOrFail($request->employe_id);

        $salary = $employe->employe_sallery;
        $paid = $request->adv_paid;

        // Condition: Paid cannot be more than Salary
        if ($paid > $salary) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Advance payment cannot be more than employee salary!',
                ],
                422,
            );
        }

        // Calculate remaining salary
        $remaining = $salary - $paid;

        // Save advance payment
        $advance = AdvancePayment::create([
            'employe_id' => $employe->id,
            'adv_payment_date' => $request->adv_payment_date,
            'month_name' => $request->month_name,
            'salary' => $salary,
            'adv_paid' => $paid,
            'remaining_sallery' => $remaining,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Advance payment saved successfully!',
            'data' => $advance,
        ]);
    }

    public function edit($id)
    {
        $advPayment = AdvancePayment::findOrFail($id);
        return view('admin.layouts.pages.payroll.advance-payment.edit', compact('advPayment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'adv_paid' => 'required|numeric|min:0',
        ]);

        $advance = AdvancePayment::findOrFail($id);

        // Prevent over-payment
        if ($request->adv_paid > $advance->salary) {
            return back()->withErrors(['adv_paid' => 'Advance cannot be more than salary.']);
        }

        $advance->adv_paid = $request->adv_paid;
        $advance->remaining_sallery = $advance->salary - $request->adv_paid;
        $advance->save();

        return redirect()->route('admin.advance.payment.index')->with('success', 'Advance updated successfully');
    }

    public function destroy() {}

    public function filter(Request $request)
    {
        $query = AdvancePayment::with(['employe:id,employe_name,employe_designation,employe_sallery']);

        if ($request->filled('employee_id')) {
            $query->where('employe_id', $request->employee_id);
        }

        if ($request->filled('fromDate')) {
            $query->whereDate('adv_payment_date', '>=', $request->fromDate);
        }

        if ($request->filled('toDate')) {
            $query->whereDate('adv_payment_date', '<=', $request->toDate);
        }

        if ($request->filled('salaryMonth')) {
            $query->where('month_name', 'like', '%' . $request->salaryMonth . '%');
        }

        $advPayments = $query->latest()->paginate(20);

        // AJAX response
        if ($request->ajax()) {
            $html = view('admin.layouts.pages.payroll.advance-payment.partials.table', compact('advPayments'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.layouts.pages.payroll.advance-payment.index', compact('advPayments'));
    }
}
