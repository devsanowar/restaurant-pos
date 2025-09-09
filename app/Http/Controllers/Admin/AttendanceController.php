<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\PayRoll;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    // public function index()
    // {
    //     $today = Carbon::today()->toDateString();

    //     $attendances = Attendance::with(['payroll:id,employe_image,id_number,employe_name,employe_designation'])
    //         ->whereDate('date', $today)
    //         ->latest()
    //         ->get();

    //     return view('admin.layouts.pages.payroll.attendance.index', compact('attendances'));
    // }

    public function index(Request $request)
{
    $employees = Payroll::select('id', 'employe_name')->get(); // Employee list for filter

    $query = Attendance::with(['payroll:id,employe_image,id_number,employe_name,employe_designation']);

    // Filter: Employee
    if ($request->filled('employee_id')) {
        $query->where('payroll_id', $request->employee_id);
    }

    // Filter: Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter: Date Range
    if ($request->filled('from_date')) {
        $query->whereDate('date', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('date', '<=', $request->to_date);
    }

    // Default: Today if no filter
    if (!$request->hasAny(['employee_id', 'status', 'from_date', 'to_date'])) {
        $query->whereDate('date', Carbon::today());
    }

    $attendances = $query->latest()->get();

    return view('admin.layouts.pages.payroll.attendance.index', compact('attendances', 'employees'));
}


    public function create(Request $request)
    {
        $selectedDate = $request->date ?? date('Y-m-d');

        $employees = PayRoll::where('joining_date', '<=', $selectedDate)
            ->select(['id', 'id_number', 'employe_name', 'joining_date', 'employe_image', 'employe_designation'])
            ->get();

        $attendances = Attendance::where('date', $selectedDate)->with('payroll')->get();

        return view('admin.layouts.pages.payroll.attendance.create', compact('employees', 'attendances', 'selectedDate'));
    }

    public function store(Request $request)
    {
        $date = $request->date;

        if (Carbon::parse($date)->isFuture()) {
            return redirect()->back()->with('error', 'You cannot take attendance for future dates.');
        }

        foreach ($request->attendance as $empId => $data) {
            $startTime = $data['start_time'] ?? null;
            $endTime = $data['end_time'] ?? null;

            $workingHours = null;
            if ($startTime && $endTime) {
                $start = Carbon::parse($startTime);
                $end = Carbon::parse($endTime);
                $workingHours = $end->diffInMinutes($start) / 60; // hours
            }

            Attendance::updateOrCreate(
                [
                    'payroll_id' => $empId,
                    'date' => $date,
                ],
                [
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => $data['status'] ?? 'Absent',
                    'reason' => $data['reason'] ?? null,
                    'working_hours' => $workingHours,
                ],
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!');
    }

    public function edit($id)
    {
        $attendance = Attendance::with('payroll')->findOrFail($id);
        return response()->json($attendance);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully!',
        ]);
    }


}
