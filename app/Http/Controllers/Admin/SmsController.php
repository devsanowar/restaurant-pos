<?php

namespace App\Http\Controllers\Admin;

use App\Models\SmsLog;
use Illuminate\Http\Request;
use App\Models\SmsApiSetting;
use App\Jobs\SendCustomSmsJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function index()
    {
        return view('admin.layouts.pages.sms.index');
    }

    public function customeSms()
    {
        return view('admin.layouts.pages.sms.custom_sms');
    }

    public function sendCustomSms(Request $request)
{
    $request->validate([
        'phone_numbers' => 'required|string',
        'message' => 'required|string',
    ]);

    $settings = SmsApiSetting::first();

    if (!$settings) {
        return response()->json([
            'status' => 'error',
            'message' => 'SMS API settings not found.',
        ], 500);
    }

    $phone_numbers = explode(',', $request->phone_numbers);
    $message = $request->message;

    foreach ($phone_numbers as $phone) {
        $phone = trim($phone);

        // ✅ Bangladesh number fix: 0 দিয়ে শুরু হলে 880 add
        if (substr($phone, 0, 1) === '0') {
            $phone = '880' . substr($phone, 1);
        }

        // ✅ Dispatch Job
        dispatch(new SendCustomSmsJob($phone, $message));
    }

    return response()->json([
        'status' => 'success',
        'message' => 'SMS sending process queued successfully.',
    ]);
}


   public function getSmsSummary()
{
    $settings = SmsApiSetting::first();

    if (!$settings) {
        return response()->json([
            'total' => 0,
            'sent' => 0,
            'remaining' => 0,
        ]);
    }

    $total = (int) $settings->total_sms;
    $used = (int) $settings->used_sms;

    $remaining = $total - $used;
    if ($remaining < 0) $remaining = 0;

    return response()->json([
        'total' => $total,
        'sent' => $used,
        'remaining' => $remaining,
    ]);
}

}
