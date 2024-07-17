<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\ServiceCall;
use App\Models\CustomerType;
use App\Models\MobileNumber;
use Illuminate\Http\Request;
use App\Models\NatureOfIssue;
use App\Models\ServiceCallLog;

class OnsiteVisitController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        $issues = NatureOfIssue::all();
        $staffId = auth()->id();
        $users = User::all();
        return view('onsite-visits.create', compact('customers', 'issues', 'staffId', 'users'));
    }


    public function store_customer(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'tally_serial_no' => 'required|string|max:255',
        ]);

        $customer = Customer::create([
            'customer_name' => $request->customer_name,
            'tally_serial_no' => $request->tally_serial_no,
        ]);

        return response()->json(['customer' => $customer]);
    }

    public function getCustomerTypes()
    {
        $customerTypes = CustomerType::all();
        return response()->json($customerTypes);
    }


    public function getContactPersons($customerId)
    {
        $customer = Customer::find($customerId);
        $contactPersons = AddressBook::where('customer_id', $customerId)->get();
        return response()->json([
            'contactPersons' => $contactPersons,
            'customerAmc' => $customer->amc,
            'primaryAddressId' => $customer->primary_address_id
        ]);
    }

    public function storeContactPerson(Request $request)
    {
        $request->validate([
            'contact_person' => 'required|string|max:255',
            'contact_person_mobile' => 'required|array|min:1',
            'contact_person_mobile.*' => 'required|string|max:15',
            'customer_id' => 'required|exists:customers,customer_id',
        ]);

        $contactPerson = AddressBook::create([
            'contact_person' => $request->contact_person,
            'customer_id' => $request->customer_id,
        ]);

        foreach ($request->contact_person_mobile as $mobileNo) {
            MobileNumber::create([
                'address_id' => $contactPerson->address_id,
                'mobile_no' => $mobileNo,
            ]);
        }

        $customer = Customer::find($request->customer_id);

        // Check and set primary_address_id if it is null
        if (is_null($customer->primary_address_id)) {
            $customer->primary_address_id = $contactPerson->address_id;
            $customer->save();
        }

        return response()->json(['contactPerson' => $contactPerson]);
    }


    public function getContactPersonMobile($contactPersonId)
    {
        $mobileNumbers = MobileNumber::where('address_id', $contactPersonId)->get();

        if ($mobileNumbers->isEmpty()) {
            return response()->json(['error' => 'Contact person not found'], 404);
        }

        $numbers = $mobileNumbers->pluck('mobile_no');  // Collects all numbers into a simple array

        return response()->json(['mobile_no' => $numbers]);
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
            return response()->json(['success' => 'Onsite Visit Created Successfully.']);
        }

        return redirect()->route('onsite-visits.index')->with('success', 'Onsite Visit Created Successfully.');
    }



    public function edit($id)
    {
        $visit = ServiceCall::findOrFail($id);
        $visit->update(['is_editing' => true]);

        $callDetails = $visit->call_details ? json_decode($visit->call_details, true) : [];
        $issues = NatureOfIssue::all();
        $users = User::all();
        $contactPersons = AddressBook::where('customer_id', $visit->customer_id)->get();

        return view('onsite-visits.edit', compact('visit',  'issues', 'users', 'contactPersons', 'callDetails'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'contact_person_id' => 'required|exists:customer_types,id',
            'type_of_call' => 'required|in:AMC Call,PER Call,FREE Call',
            'status_of_call' => 'required|in:completed,pending,cancelled,on_process,follow_up,onsite_visit,online_call',
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
            'is_editing' => false,
            'remarks' => $request->remarks,
        ]);


        ServiceCallLog::create([
            'service_call_id' => $visit->id,
            'call_start_time' => Carbon::createFromFormat('d F Y, h:i:s A', $request->call_start_time),
            'call_end_time' => $request->call_end_time ? Carbon::createFromFormat('d F Y, h:i:s A', $request->call_end_time) : null,
            'updated_by' => auth()->id(),
        ]);



        if ($request->ajax()) {
            return response()->json(['success' => 'Onsite Visit Updated Successfully.']);
        }

        return redirect()->route('onsite-visits.index')->with('success', 'Onsite Visit Updated Successfully.');
    }
}
