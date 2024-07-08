<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\ServiceCall;
use Illuminate\Http\Request;

class OnlineCallController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        return view('online-calls.create', compact('customers'));
    }

    public function getContactPersons($customerId)
    {
        $customer = Customer::find($customerId);
        $contactPersons = AddressBook::where('customer_id', $customerId)->get();
        return response()->json([
            'contactPersons' => $contactPersons,
            'customerAmc' => $customer->amc
        ]);
    }



    public function getContactPersonMobile($contactPersonId)
    {
        $contactPerson = AddressBook::where('address_id', $contactPersonId)->first();
        return response()->json(['mobile_no' => $contactPerson->mobile_no]);
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
        $contactPersons = AddressBook::where('customer_id', $visit->customer_id)->get();

        return view('online-calls.edit', compact('visit', 'customers', 'contactPersons'));
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
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Onsite Visit Updated Successfully.']);
        }

        return redirect()->route('online-calls.index')->with('success', 'Onsite Visit Updated Successfully.');
    }
}
