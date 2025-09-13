<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SmsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SmsReport;
use Carbon\Carbon;
use App\Jobs\SendSmsJob;

class SmsController extends Controller
{
    private function calculateSmsUsage($message)
    {
        $charCount   = mb_strlen($message, 'UTF-8');
        $isUnicode   = preg_match('/[^\x00-\x7F]/', $message);
        $segmentSize = $isUnicode ? 70 : 160;
        $smsCount    = ceil($charCount / $segmentSize);

        return [$charCount, $smsCount];
    }

    public function index()
    {
        $customers = Order::latest()->get();
        $sms_setting = SmsSetting::where('is_active', true)->first();
        return view('admin.layouts.pages.sms.index', compact('customers', 'sms_setting'));
    }

    public function send(Request $request)
    {
        $sms_setting = SmsSetting::where('is_active', true)->first();

        if (!$sms_setting) {
            return back()->with('message', 'No active message configuration found.');
        }

        $request->validate([
            'message'        => 'required|string',
            'selected'       => 'nullable|array',
            'selected.*'     => 'integer|exists:orders,id',
            'mobile_numbers' => 'nullable|string',
        ]);

        $successCount = 0;
        $failCount    = 0;
        $sentToNumbers = [];

        [$charCount, $smsCount] = $this->calculateSmsUsage($request->message);

        // 🔹 Send to selected customers
        $customers = collect();
        if (!empty($request->selected)) {
            $customers = Order::whereIn('id', $request->selected)->get();
        }

        foreach ($customers as $customer) {
            $phone = $customer->phone;
            $today = Carbon::today();

            $alreadySentToday = SmsReport::where('mobile', $phone)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadySentToday) {
                continue;
            }

            try {
                SendSmsJob::dispatch(
                    $phone,
                    $request->message,
                    [
                        'api_url'    => $sms_setting->api_url,
                        'api_key'    => $sms_setting->api_key,
                        'api_secret' => $sms_setting->api_secret,
                        'sender'     => $sms_setting->sender_id,
                    ],
                    $customer->id,
                    $charCount,
                    $smsCount
                );

                $successCount++;
                $sentToNumbers[] = $phone;
            } catch (\Exception $e) {
                \Log::error("Failed to send SMS to {$phone}", ['error' => $e->getMessage()]);

                SmsReport::create([
                    'customer_id'  => $customer->id,
                    'mobile'       => $phone,
                    'message_body' => $request->message,
                    'status_code'  => null,
                    'api_response' => $e->getMessage(),
                    'success'      => false,
                    'char_count'   => $charCount,
                    'sms_count'    => $smsCount,
                ]);

                $failCount++;
            }
        }

        // 🔹 Custom numbers input
        $customNumbers = [];
        if (!empty($request->mobile_numbers)) {
            $customNumbers = array_filter(array_map('trim', explode(',', $request->mobile_numbers)));
            $customNumbers = array_diff($customNumbers, $sentToNumbers);
        }

        foreach ($customNumbers as $number) {
            $today = Carbon::today();

            $alreadySentToday = SmsReport::where('mobile', $number)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadySentToday) {
                continue;
            }

            try {
                SendSmsJob::dispatch(
                    $number,
                    $request->message,
                    [
                        'api_url'    => $sms_setting->api_url,
                        'api_key'    => $sms_setting->api_key,
                        'api_secret' => $sms_setting->api_secret,
                        'sender'     => $sms_setting->sender,
                    ],
                    null,
                    $charCount,
                    $smsCount
                );

                $successCount++;
                $sentToNumbers[] = $number;
            } catch (\Exception $e) {
                \Log::error("Failed to send SMS to {$number}", ['error' => $e->getMessage()]);

                SmsReport::create([
                    'customer_id'  => null,
                    'mobile'       => $number,
                    'message_body' => $request->message,
                    'status_code'  => null,
                    'api_response' => $e->getMessage(),
                    'success'      => false,
                    'char_count'   => $charCount,
                    'sms_count'    => $smsCount,
                ]);

                $failCount++;
            }
        }

        // 🔹 Summary
        $seeReportUrl = route('admin.sms-report.index');
        $customerNumbers = $customers->pluck('phone')->toArray();
        $totalNumbers = array_unique(array_merge($customerNumbers, $customNumbers));

        $totalCount = count($totalNumbers);
        $skipCount = $totalCount - ($successCount + $failCount);

        $insufficientBalance = SmsReport::whereDate('created_at', Carbon::today())
            ->where('api_response', 'like', '%INSUFFICIENT_BALANCE%')
            ->exists();

        $statusMessage = '';

        if ($insufficientBalance) {
            $statusMessage .= "<span class='text-danger'>Insufficient Balance, Please recharge.</span><br>";
        } else {
            $statusMessage .= "
                <span class='text-success'>{$successCount} SMS Successful </span>,
                <span class='text-danger'>{$failCount} SMS Failed </span>,
                <span class='text-warning'>{$skipCount} SMS Cancel (Already Sent) </span>
                <a href='{$seeReportUrl}' class='btn btn-sm btn-info ms-2'>See SMS Report</a>
            ";
        }

        return back()->with('message', $statusMessage);
    }

    public function customSms()
    {
        $sms_setting = SmsSetting::where('is_active', true)->first();
        $successfulSms = SmsReport::where('success', 1)->count();

        $sms_reports = SmsReport::all();
        $totalSmsCount = 0;

        foreach ($sms_reports as $report) {
            $totalSmsCount += $report->sms_count ?? 0; // use saved value
        }

        return view('admin.layouts.pages.sms.custom-sms', compact('totalSmsCount', 'sms_setting', 'successfulSms'));
    }
}
