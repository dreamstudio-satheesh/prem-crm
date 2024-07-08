<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        return view('online-calls.create', compact('customers', 'issues'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:customer_types,id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'call_start_time' => 'required',
            'call_end_time' => 'required',
            'status_of_call' => 'required|in:completed,pending',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        $currentDate = Carbon::now()->toDateString();
        $callStartTime = Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->call_start_time);
        $callEndTime = $request->call_end_time ? Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->call_end_time) : null;

        ServiceCall::create([
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            'call_type' => 'online_call',
            'call_start_time' => $callStartTime,
            'call_end_time' => $callEndTime,
            'status_of_call' => $request->status_of_call,
            'nature_of_issue_id' => $request->nature_of_issue_id,
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Onsite Visit Created Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Onsite Visit Created Successfully.');
    }



    public function edit($id)
    {
        $visit = ServiceCall::findOrFail($id);

        // Convert call_start_time and call_end_time to Carbon instances
        $visit->call_start_time = Carbon::parse($visit->call_start_time);
        if ($visit->call_end_time) {
            $visit->call_end_time = Carbon::parse($visit->call_end_time);
        }

        $customers = Customer::all();
        $issues = NatureOfIssue::all();
        $contactPersons = AddressBook::where('customer_id', $visit->customer_id)->get();

        return view('online-calls.edit', compact('visit', 'customers', 'issues', 'contactPersons'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:customer_types,id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'call_start_time' => 'required',
            'call_end_time' => 'nullable',
            'status_of_call' => 'required|in:completed,pending',
            'nature_of_issue_id' => 'required|exists:nature_of_issues,id',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        $currentDate = Carbon::now()->toDateString();
        $callStartTime = Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->call_start_time);
        $callEndTime = $request->call_end_time ? Carbon::createFromFormat('Y-m-d h:i:s A', $currentDate . ' ' . $request->call_end_time) : null;

        $visit = ServiceCall::findOrFail($id);
        $visit->update([
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            //'call_type' => 'online_call',
            'call_start_time' => $callStartTime,
            'call_end_time' => $callEndTime,
            'status_of_call' => $request->status_of_call,
            'nature_of_issue_id' => $request->nature_of_issue_id,
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Onsite Visit Updated Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Onsite Visit Updated Successfully.');
    }
}
