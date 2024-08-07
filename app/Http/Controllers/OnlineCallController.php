<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\ServiceCall;
use App\Models\MobileNumber;
use Illuminate\Http\Request;
use App\Models\NatureOfIssue;
use App\Models\ServiceCallLog;
use Illuminate\Support\Facades\Log;
use App\Mail\CallClosedNotification;
use Illuminate\Support\Facades\Mail;

class OnlineCallController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        $issues = NatureOfIssue::all();
        $staffId = auth()->id();
        $users = User::all();
        return view('online-calls.create', compact('customers', 'issues', 'staffId', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:address_books,address_id',
            'contact_person_mobile' => 'required',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'call_booking_time' => 'required',
            'staff_id' => 'required',
            'status_of_call' => 'required|in:completed,pending,on_process,follow_up,onsite_visit',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'follow_up_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);
        $currentDate = Carbon::now()->toDateString();
        $bookingTime = Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->call_booking_time)->format('Y-m-d H:i:s');

        $mobileNumber = MobileNumber::firstOrCreate(
            ['mobile_no' => $request->contact_person_mobile],
            ['address_id' => $request->contact_person_id] // Add additional fields as necessary
        );

        $serviceCallData = [
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'contact_person_mobile_id' => $mobileNumber->id,
            'type_of_call' => $request->type_of_call,
            'call_type' => $request->call_type,
            'staff_id' => $request->staff_id,
            'created_by' => auth()->id(),
            'call_booking_time' => $bookingTime,
            'status_of_call' => $request->status_of_call,
            'nature_of_issue_id' => $request->nature_of_issue_id,
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ];

        if ($request->status_of_call === 'follow_up' && $request->follow_up_date) {
            $followUpDate = Carbon::createFromFormat('Y-m-d', $request->follow_up_date);
            $serviceCallData['follow_up_date'] = $followUpDate;
        }

        ServiceCall::create($serviceCallData);


        if ($request->ajax()) {
            return response()->json(['success' => 'Online Call Created Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Online Call Created Successfully.');
    }

    public function edit($id)
    {
        $visit = ServiceCall::findOrFail($id);
        $visit->update(['is_editing' => true]);

        $callDetails = $visit->call_details ? json_decode($visit->call_details, true) : [];
        $issues = NatureOfIssue::all();
        $users = User::all();
        $contactPersons = AddressBook::where('customer_id', $visit->customer_id)->get();

        // Fetch the mobile number from the MobileNumber model using the contact_person_mobile_id
        $contactPersonMobile = MobileNumber::where('id', $visit->contact_person_mobile_id)->value('mobile_no');


        return view('online-calls.edit', compact('visit',  'issues', 'users', 'contactPersons', 'callDetails','contactPersonMobile'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:address_books,address_id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'status_of_call' => 'required|in:completed,pending,cancelled,on_process,follow_up,onsite_visit',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'tally_serial_no' => 'nullable|string',
        ]);

        $visit = ServiceCall::findOrFail($id);

        $visit->update([
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            'call_type' => $request->call_type,
            'status_of_call' => $request->status_of_call,
            'nature_of_issue_id' => $request->nature_of_issue_id,
            'service_charges' => $request->service_charges,
            'is_editing' => false,
            'remarks' => $request->remarks,
        ]);

        if (!$visit->customer->tally_serial_no && $request->has('tally_serial_no')) {
            $visit->customer->update(['tally_serial_no' => $request->tally_serial_no]);
        }



        if ($request->status_of_call == 'completed') {
            // Get all email addresses for the current customer
            $customer = Customer::find($request->customer_id);
            $emails = $customer->AddressBooks->pluck('email')->filter();

            // Log email sending process
            foreach ($emails as $email) {
                Log::info('Sending email to: ' . $email);
                Mail::to($email)->send(new CallClosedNotification($email));
            }
        }



        ServiceCallLog::create([
            'service_call_id' => $visit->id,
            'call_start_time' => Carbon::createFromFormat('d F Y, h:i:s A', $request->call_start_time),
            'call_end_time' => $request->call_end_time ? Carbon::createFromFormat('d F Y, h:i:s A', $request->call_end_time) : null,
            'updated_by' => auth()->id(),
        ]);



        if ($request->ajax()) {
            return response()->json(['success' => 'Online Call Updated Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Online Call Updated Successfully.');
    }


    public function keepAlive($id)
    {
        $visit = ServiceCall::findOrFail($id);
        $visit->last_active_time = now();
        $visit->save();
    }
}
