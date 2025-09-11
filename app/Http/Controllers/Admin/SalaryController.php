<?php

namespace App\Http\Controllers\Admin;

use App\Models\Salary;
use App\Models\PayRoll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with(['employee:id,employe_name,employe_designation,employe_image'])->get();

        // Employees for filter
        $employes = PayRoll::select('id', 'employe_name')->get();

        // Distinct designations for filter
        $designations = PayRoll::select('employe_designation')->distinct()->pluck('employe_designation');

        return view('admin.layouts.pages.payroll.salary.index', compact('salaries', 'employes', 'designations'));
    }

    public function create()
    {
        $employes = PayRoll::select('id', 'employe_name', 'employe_sallery')->get();
        return view('admin.layouts.pages.payroll.salary.create', compact('employes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:pay_rolls,id',
            'starting_salary' => 'required|numeric|min:0',
            'bonus_amount' => 'nullable|numeric|min:0',
            'bonus_type' => 'nullable|in:percent,flat',
            'increment_amount' => 'nullable|numeric|min:0',
            'incentive' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'present_salary' => 'required|numeric|min:0',
        ]);

        Salary::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Salary added successfully!',
        ]);
    }

    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        $employes = PayRoll::select('id', 'employe_name', 'employe_sallery')->get();
        return view('admin.layouts.pages.payroll.salary.edit', compact('salary', 'employes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:pay_rolls,id',
            'starting_salary' => 'required|numeric|min:0',
            'increment_amount' => 'nullable|numeric|min:0',
            'increment_effective_from' => 'nullable|date',
            'present_salary' => 'required|numeric|min:0',
            'salary_effective_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
        ]);

        try {
            $salary = Salary::findOrFail($id);

            // Update fields
            $salary->employee_id = $request->employee_id;
            $salary->starting_salary = $request->starting_salary;
            $salary->increment_amount = $request->increment_amount ?? 0.0;
            $salary->increment_effective_from = $request->increment_effective_from;
            $salary->present_salary = $request->present_salary;
            $salary->salary_effective_date = $request->salary_effective_date;
            $salary->remarks = $request->remarks;

            $salary->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Salary updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($id){
        $salary = Salary::findOrFail($id);

        $salary->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Salary deleted successfully.',
        ]);
    }

    public function filter(Request $request)
    {
        $query = Salary::with(['employee:id,employe_name,employe_designation,employe_image']);

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->designation) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('employe_designation', $request->designation);
            });
        }

        $salaries = $query->get();

        $html = view('admin.layouts.pages.payroll.salary.partials.salary_table', compact('salaries'))->render();

        return response()->json(['html' => $html]);
    }
}
