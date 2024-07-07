<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnsiteVisit;
use App\Models\Customer;
use App\Models\AddressBook;
use Carbon\Carbon;

class OnsiteVisitController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        return view('onsite-visits.create', compact('customers'));
    }

    public function getContactPersons($customerId)
    {
        $contactPersons = AddressBook::where('customer_id', $customerId)->get();
        return response()->json($contactPersons);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:address_books,address_id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'call_start_time' => 'required|date_format:h:i A',
            'call_end_time' => 'nullable|date_format:h:i A',
            'status_of_call' => 'required|in:completed,pending',
            'service_charges' => 'nullable|numeric',
            'remarks' => 'nullable|string',
        ]);

        OnsiteVisit::create([
            'customer_id' => $request->customer_id,
            'contact_person_id' => $request->contact_person_id,
            'type_of_call' => $request->type_of_call,
            'call_start_time' => Carbon::now()->toDateString() . ' ' . $request->call_start_time,
            'call_end_time' => Carbon::now()->toDateString() . ' ' . $request->call_end_time,
            'status_of_call' => $request->status_of_call,
            'service_charges' => $request->service_charges,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('onsite-visits.index')->with('success', 'Onsite Visit Created Successfully.');
    }
}
