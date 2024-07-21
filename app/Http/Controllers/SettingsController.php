<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = Setting::whereIn('key', [
            'email.mail_host',
            'email.mail_port',
            'email.mail_encryption',
            'email.mail_username',
            'email.mail_password',
            'email.from_address',
            'email.from_name'
        ])->pluck('value', 'key');

        return view('settings.email', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'email.mail_host' => 'required',
            'email.mail_port' => 'required|integer',
            'email.mail_encryption' => 'required',
            'email.mail_username' => 'required',
            'email.mail_password' => 'required',
            'email.from_address' => 'required|email',
            'email.from_name' => 'required',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('email-settings.edit')->with('success', 'Email settings updated successfully!');
    }
}
