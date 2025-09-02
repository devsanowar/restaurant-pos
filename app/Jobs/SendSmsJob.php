<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SmsReport;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone, $text, $messageConfig, $customerId;

    public function __construct($phone, $text, array $messageConfig, $customerId = null)
    {
        $this->phone = $phone;
        $this->text = $text;
        $this->messageConfig = $messageConfig;
        $this->customerId = $customerId;
    }

    public function handle()
    {
        try {
            $response = Http::post($this->messageConfig['api_url'], [
                'api_key'      => $this->messageConfig['api_key'],
                'api_secret'   => $this->messageConfig['api_secret'],
                'request_type' => 'single_sms',
                'message_type' => 'UNICODE',
                'sender'       => $this->messageConfig['sender'],
                'mobile'       => $this->phone,
                'message_body' => $this->text,
            ]);

            SmsReport::create([
                'customer_id'  => $this->customerId,
                'mobile'       => $this->phone,
                'message_body' => $this->text,
                'status_code'  => $response->status(),
                'api_response' => $response->body(),
                'success'      => $response->status() === 200,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS to {$this->phone}", ['error' => $e->getMessage()]);

            SmsReport::create([
                'customer_id'  => $this->customerId,
                'mobile'       => $this->phone,
                'message_body' => $this->text,
                'status_code'  => null,
                'api_response' => $e->getMessage(),
                'success'      => false,
            ]);
        }
    }
}

