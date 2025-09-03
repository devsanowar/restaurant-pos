<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsReport;
use Illuminate\Http\Request;

class SmsReportController extends Controller
{
    public function index(Request $request)
    {
        $query = SmsReport::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $sms_reports = $query->latest()->paginate(15);

        $totalSmsCount = 0;

        foreach ($sms_reports as $report) {
            $message = $report->message_body;
            $charCount = mb_strlen($message, 'UTF-8');
            $isUnicode = preg_match('/[^\x00-\x7F]/', $message);
            $segmentSize = $isUnicode ? 60 : 160; // match your Blade logic
            $smsCount = ceil($charCount / $segmentSize);

            $totalSmsCount += $smsCount;
        }

        return view('admin.layouts.pages.sms.sms-report', compact('sms_reports', 'totalSmsCount'));
    }

    public function destroy($id)
    {
        $sms_report = SmsReport::findOrFail($id);

        $sms_report->delete();
        return redirect()->route('sms-report.index')->with('message', 'Report deleted successfully.');
    }
}
