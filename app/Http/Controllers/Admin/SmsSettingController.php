<?php

namespace App\Http\Controllers\Admin;

use App\Models\SmsLog;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Carbon;
use App\Models\SmsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class SmsSettingController extends Controller
{
    public function edit()
    {
        $setting = SmsSetting::first();
        return view('admin.layouts.pages.sms-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'api_url'         => 'required|url',
                'api_key'         => 'required',
                'api_secret'      => 'required',
                'sender_id'       => 'required',
                'request_type'    => 'required',
                'message_type'    => 'required',
                'default_message' => 'required',
            ]);


            $setting = SmsSetting::first();
//            dd($request->all());

            $setting->update([
                'api_url'         => $request->api_url,
                'api_key'         => $request->api_key,
                'api_secret'      => $request->api_secret,
                'sender_id'       => $request->sender_id,
                'request_type'    => $request->request_type,
                'message_type'    => $request->message_type,
                'default_message' => $request->default_message,
                'is_active'       => $request->is_active,
            ]);

            Toastr::success('SMS Settings updated successfully!', 'Success');
        } catch (\Exception $e) {
            Toastr::error('Failed to update SMS Settings: ' . $e->getMessage(), 'Error');
        }

        return redirect()->back();
    }
}
