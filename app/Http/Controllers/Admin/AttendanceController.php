<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\PayRoll;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('admin.layouts.pages.payroll.attendance.index');
    }

    public function create(Request $request)
    {
        // Selected date (default today)
        $selectedDate = $request->date ?? date('Y-m-d');

        // Employees who joined on or before selected date
        $employees = PayRoll::where('joining_date', '<=', $selectedDate)
            ->select(['id', 'id_number', 'employe_name', 'joining_date', 'employe_image', 'employe_designation'])
            ->get();

        // Existing attendance for that date
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

    public function update() {}

    public function delete() {}
}
