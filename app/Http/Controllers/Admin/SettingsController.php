<?php

namespace App\Http\Controllers\Admin;

use App\Models\PosSetting;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\NotificationSetting;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $general = GeneralSetting::first();
        $pos = PosSetting::first();
        $notification = NotificationSetting::first();
        return view('admin.layouts.pages.setting.index', compact('general', 'pos', 'notification'));
    }

    public function update(Request $request)
    {
        // -------------------
        // General Settings
        // -------------------
        $general = GeneralSetting::first(); // ধরা যাক শুধু একটিই row থাকবে
        if (!$general) {
            $general = new GeneralSetting();
        }

        $general->restaurant_name = $request->restaurant_name;
        $general->restaurant_email = $request->restaurant_email;
        $general->restaurant_phone = $request->restaurant_phone;
        $general->restaurant_address = $request->restaurant_address;

        if ($request->hasFile('restaurant_logo')) {
            $logo = $request->file('restaurant_logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            $path = public_path('uploads/logo');

            $logo->move($path, $filename);
            $general->restaurant_logo = 'uploads/logo/' . $filename;
        }

        $general->save();

        // -------------------
        // POS Settings
        // -------------------
        $pos = PosSetting::first();
        if (!$pos) {
            $pos = new PosSetting();
        }

        $pos->currency = $request->currency;
        $pos->tax_rate = $request->tax_rate ?? 0;
        $pos->service_charge = $request->service_charge ?? 0;
        $pos->default_printer = $request->default_printer;
        $pos->save();

        // -------------------
        // Notification Settings
        // -------------------
        $notification = NotificationSetting::first();
        if (!$notification) {
            $notification = new NotificationSetting();
        }

        $notification->email_notification = $request->has('email_notification') ? 1 : 0;
        $notification->sms_notification = $request->has('sms_notification') ? 1 : 0;
        $notification->push_notification = $request->has('push_notification') ? 1 : 0;
        $notification->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Settings updated successfully!',
        ]);
    }
}
