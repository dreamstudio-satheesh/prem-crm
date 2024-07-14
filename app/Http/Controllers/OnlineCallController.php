<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\ServiceCall;
use Illuminate\Http\Request;
use App\Models\NatureOfIssue;

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
            'contact_person_id' => 'required|exists:customer_types,id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'booking_time' => 'required',
            'staff_id' => 'required',
            'status_of_call' => 'required|in:completed,pending,on_process,follow_up,onsite_visit',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);
        $currentDate = Carbon::now()->toDateString();
        $bookingTime = Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->booking_time);

        ServiceCall::create([
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            'call_type' => $request->call_type,
            'staff_id' => $request->staff_id,
            'call_booking_time' => $bookingTime,
            'status_of_call' => $request->status_of_call,
            'nature_of_issue_id' => $request->nature_of_issue_id,
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Online Call Created Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Online Call Created Successfully.');
    }

    public function edit($id)
    {
        $visit = ServiceCall::findOrFail($id);
        $callDetails = $visit->call_details ? json_decode($visit->call_details, true) : [];

        $customers = Customer::all();
        $issues = NatureOfIssue::all();
        $contactPersons = AddressBook::where('customer_id', $visit->customer_id)->get();

        return view('online-calls.edit', compact('visit', 'customers', 'issues', 'contactPersons', 'callDetails'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:customer_types,id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'call_start_time' => 'required',
            'call_end_time' => 'nullable',
            'status_of_call' => 'required|in:completed,pending,on_process,follow_up,onsite_visit',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        $visit = ServiceCall::findOrFail($id);

        $callDetails = $visit->call_details ? json_decode($visit->call_details, true) : [];
        $callDetails[] = [
            'staff_id' => auth()->id(),
            'start_time' => Carbon::createFromFormat('Y-m-d h:i:s A', $request->call_start_time)->toDateTimeString(),
            'end_time' => $request->call_end_time ? Carbon::createFromFormat('Y-m-d h:i:s A', $request->call_end_time)->toDateTimeString() : null
        ];

        $visit->update([
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            'call_type' => $request->call_type,
            'call_details' => json_encode($callDetails),
            'status_of_call' => $request->status_of_call,
            'nature_of_issue_id' => $request->nature_of_issue_id,
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Online Call Updated Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Online Call Updated Successfully.');
    }
}
