<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsApiSettingsController extends Controller
{
    public function index()
    {
        $smsApiSetting = \App\Models\SmsApiSetting::first();
        return view('admin.layouts.pages.sms-api-settings.index', compact('smsApiSetting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_url' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'sender_id' => 'nullable|string|max:100',
            'message_type' => 'required|in:TEXT,UNICODE,FLASH,WAPPUSH',
            'total_sms' => 'nullable|string',
            'default_message' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        

        $smsApiSetting = \App\Models\SmsApiSetting::first();
        if(!$smsApiSetting){
            $smsApiSetting = new \App\Models\SmsApiSetting();
        }

        $smsApiSetting->api_url = $request->api_url;
        $smsApiSetting->api_key = $request->api_key;
        $smsApiSetting->api_secret = $request->api_secret;
        $smsApiSetting->sender_id = $request->sender_id;
        $smsApiSetting->message_type = $request->message_type;
        $smsApiSetting->total_sms = $request->total_sms;
        $smsApiSetting->default_message = $request->default_message;
        $smsApiSetting->status = $request->status;
        $smsApiSetting->save();

        return response()->json([
            'success' => true,
            'message' => 'SMS API settings saved successfully!',
        ]);
    }
}
