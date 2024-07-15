<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\ServiceCall;
use Illuminate\Http\Request;
use App\Models\NatureOfIssue;
use App\Models\ServiceCallLog;

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
            'follow_up_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);
        $currentDate = Carbon::now()->toDateString();
        $bookingTime = Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->booking_time);

        $serviceCallData = [
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            'call_type' => $request->call_type,
            'staff_id' => $request->staff_id,
            'careated_by' => auth()->id(),
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
        $callDetails = $visit->call_details ? json_decode($visit->call_details, true) : [];
        $issues = NatureOfIssue::all();
        $users = User::all(); 
        $contactPersons = AddressBook::where('customer_id', $visit->customer_id)->get();

        return view('online-calls.edit', compact('visit',  'issues', 'users','contactPersons', 'callDetails'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:customer_types,id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'status_of_call' => 'required|in:completed,pending,on_process,follow_up,onsite_visit',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
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
            'remarks' => $request->remarks,
        ]);


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



}
