<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Mail\MarketingEmail;
use Illuminate\Support\Facades\Mail;

class EmailMarketingController extends Controller
{
    public function create()
    {
        $customers = Customer::with(['addressBooks' => function ($query) {
            $query->select('customer_id', 'email')->whereNotNull('email');
        }])->get(['customer_id', 'customer_name']);

        return view('emails.marketing', compact('customers'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'recipients' => 'required_unless:send_to_all,on|array',
        ]);

        $recipients = $request->send_to_all ? Customer::pluck('email')->toArray() : $request->recipients;

        foreach ($recipients as $email) {
            Mail::to($email)->send(new MarketingEmail($request->subject, $request->message));
        }

        return redirect()->back()->with('success', 'Emails sent successfully!');
    }
}
