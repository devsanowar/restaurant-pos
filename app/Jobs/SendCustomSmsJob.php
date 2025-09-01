<?php

namespace App\Jobs;

use App\Models\SmsApiSetting;
use App\Models\SmsLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendCustomSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone_number, $message;

    public function __construct($phone_number, $message)
    {
        $this->phone_number = $phone_number;
        $this->message = $message;
    }

    public function handle(): void
{
    $settings = SmsApiSetting::first();

    if (!$settings) {
        Log::error('SMS API settings not found.');
        return;
    }

    // Unicode check
    $isUnicode = preg_match('/[^\x00-\x7F]/', $this->message) === 1;
    $length = strlen($this->message);
    $single = $isUnicode ? 70 : 160;
    $multi = $isUnicode ? 67 : 153;

    $smsCount = $length <= $single ? 1 : ceil(($length - $single) / $multi) + 1;

    // Balance check
    $used = $settings->used_sms ?? 0;
    $total = $settings->total_sms ?? 0;

    if ($used + $smsCount > $total) {
        SmsLog::create([
            'phone' => $this->phone_number,
            'message' => $this->message,
            'sms_count' => $smsCount,
            'status' => 'failed',
            'response' => 'Insufficient balance',
        ]);
        Log::warning("Insufficient balance to send SMS to {$this->phone_number}");
        return;
    }

    try {
        // Prepare API params
        $params = [
            'api_key'      => $settings->api_key,
            'api_secret'   => $settings->api_secret,
            'request_type' => 'single_sms',
            'message_type' => $isUnicode ? 'UNICODE' : 'TEXT',
            'sender'       => $settings->sender_id,
            'phone'        => $this->phone_number,
            'message'      => $this->message,
        ];

        $requestType = strtoupper($settings->request_type ?? 'GET');

        if ($requestType === 'POST') {
            $response = Http::asForm()->post($settings->api_url, $params);
        } else {
            $response = Http::get($settings->api_url, $params);
        }

        $responseBody = $response->json(); // API থেকে JSON decode
        $status = 'failed';

        // ✅ API response অনুযায়ী status handle
        if (isset($responseBody['api_response_code']) && $responseBody['api_response_code'] == 200) {
            $status = 'success';
            $settings->used_sms = $used + $smsCount;
            $settings->save();
        }

        // Save SMS log
        SmsLog::create([
            'phone' => $this->phone_number,
            'message' => $this->message,
            'sms_count' => $smsCount,
            'status' => $status,
            'response' => json_encode($responseBody),
        ]);

    } catch (\Exception $e) {
        SmsLog::create([
            'phone' => $this->phone_number,
            'message' => $this->message,
            'sms_count' => $smsCount,
            'status' => 'failed',
            'response' => $e->getMessage(),
        ]);
        Log::error("Exception while sending SMS to {$this->phone_number}: " . $e->getMessage());
    }
}


}
