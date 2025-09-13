<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SmsSetting;
use App\Models\SmsReport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\SendSmsJob;

class SmsController extends Controller
{
    /**
     * Calculate SMS character and segment count
     */
    private function calculateSmsUsage($message)
    {
        $charCount   = mb_strlen($message, 'UTF-8');
        $isUnicode   = preg_match('/[^\x00-\x7F]/', $message);
        $segmentSize = $isUnicode ? 70 : 160;
        $smsCount    = ceil($charCount / $segmentSize);

        return [$charCount, $smsCount];
    }

    /**
     * SMS index page
     */
    public function index()
    {
        $customers   = Order::latest()->get();
        $sms_setting = SmsSetting::where('is_active', true)->first();

        return view('admin.layouts.pages.sms.index', compact('customers', 'sms_setting'));
    }

    /**
     * Send SMS
     */
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

        $successCount  = 0;
        $failCount     = 0;
        $sentToNumbers = [];

        [$charCount, $smsCount] = $this->calculateSmsUsage($request->message);

        // 🔹 Send to selected customers
        $customers = collect();
        if (!empty($request->selected)) {
            $customers = Order::whereIn('id', $request->selected)->get();
        }

        foreach ($customers as $customer) {
            $phone = $customer->phone;
            $customerId = $customer->customer_id ?? null; // null if no customer_id
            $today = Carbon::today();

            $alreadySentToday = SmsReport::where('mobile', $phone)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadySentToday) continue;

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
                    $customerId, // Correct position for customer_id
                    $charCount,  // Correct position for char_count
                    $smsCount    // Correct position for sms_count
                );

                $successCount++;
                $sentToNumbers[] = $phone;

            } catch (\Exception $e) {
                \Log::error("Failed to send SMS to {$phone}", ['error' => $e->getMessage()]);

                SmsReport::create([
                    'customer_id'  => $customerId,
                    'mobile'       => $phone,
                    'message_body' => $request->message,
                    'char_count'   => $charCount,
                    'sms_count'    => $smsCount,
                    'status_code'  => null,
                    'api_response' => $e->getMessage(),
                    'success'      => false,
                ]);

                $failCount++;
            }
        }

        // 🔹 Send to custom numbers
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

            if ($alreadySentToday) continue;

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
                    null,        // no customer_id
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
                    'char_count'   => $charCount,
                    'sms_count'    => $smsCount,
                    'status_code'  => null,
                    'api_response' => $e->getMessage(),
                    'success'      => false,
                ]);

                $failCount++;
            }
        }

        // 🔹 Summary
        $seeReportUrl = route('admin.sms-report.index');
        $totalNumbers = array_unique(array_merge(
            $customers->pluck('phone')->toArray(),
            $customNumbers
        ));

        $totalCount = count($totalNumbers);
        $skipCount  = $totalCount - ($successCount + $failCount);

        $insufficientBalance = SmsReport::whereDate('created_at', Carbon::today())
            ->where('api_response', 'like', '%INSUFFICIENT_BALANCE%')
            ->exists();

        $statusMessage = $insufficientBalance
            ? "<span class='text-danger'>Insufficient Balance, Please recharge.</span><br>"
            : "<span class='text-success'>{$successCount} SMS Successful </span>,
               <span class='text-danger'>{$failCount} SMS Failed </span>,
               <span class='text-warning'>{$skipCount} SMS Cancel (Already Sent) </span>
               <a href='{$seeReportUrl}' class='btn btn-sm btn-info ms-2'>See SMS Report</a>";

        return back()->with('message', $statusMessage);
    }

    /**
     * Custom SMS page
     */
    public function customSms()
    {
        $sms_setting   = SmsSetting::where('is_active', true)->first();
        $successfulSms = SmsReport::where('success', 1)->count();
        $totalSmsCount = SmsReport::sum('sms_count'); // sum all saved sms_count

        return view('admin.layouts.pages.sms.custom-sms', compact('totalSmsCount', 'sms_setting', 'successfulSms'));
    }
}
